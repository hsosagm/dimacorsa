<?php

class InformeGeneralController extends \BaseController {

    public function procesarInformeDelDia($tienda_id)
    {
        $data['guardado'] = $this->guardarInformeDelDia($tienda_id);
        $data['enviado'] = $this->enviarInformeDelDia($tienda_id);

        return json_encode($data);
    }

    public function guardarInformeDelDia($tienda_id)
    {
        $fecha = InformeGeneral::select(DB::raw('max(created_at) as fecha'))
        ->whereTiendaId($tienda_id)->first();

        $informe = InformeGeneral::select('id')->whereCreatedAt($fecha->fecha)->first();

        $data = $this->resumenInformeGeneral($informe->id, $tienda_id);

        $inversion = ($data['inversionActual'] + $data['compras']) - ($data['ventas'] + $data['descargas'] + $data['traslados']);
        $cuentas_cobrar = ($data['cuentasCobrarActual'] + $data['ventas_credito']) - ($data['abonos_ventas']);
        $cuentas_pagar = ($data['cuentasPagarActual'] + $data['compras_credito']) - ($data['abonos_compras']);

        $newInforme = new InformeGeneral;
        $newInforme->inversion = $inversion;
        $newInforme->cuentas_cobrar = $cuentas_cobrar;
        $newInforme->cuentas_pagar = $cuentas_pagar;
        $newInforme->save();

        return "Informe general guardado con exito..!";
    }

    public function enviarInformeDelDia($tienda_id)
    {
        $correos = DB::table('notificaciones')->select('correo')->whereTiendaId($tienda_id)
        ->where('notificacion','InformeGeneral')->get();

        if (!count($correos))
            return 'No hay correos asignados a esta notificacion..!';

        $fecha = InformeGeneral::select(DB::raw('max(created_at) as fecha'))
        ->whereTiendaId($tienda_id)->first();

        $informe = InformeGeneral::whereTiendaId($tienda_id)
        ->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') = DATE_FORMAT('{$fecha->fecha}', '%Y-%m-%d')")
        ->first();

        $tienda = Tienda::find($tienda_id);

        foreach ($correos as $val) {
            $emails [] = $val->correo;
        }

        $tienda_titulo = $tienda->nombre;
        $detalle_ventas = $this->getConsultaPorProducto(true, $tienda_id);
        $kardex = $this->getInformeKardexConsulta(true, $tienda_id);
        $data = $this->resumenInformeGeneral($informe->id, $tienda_id);

        Mail::queue('emails.mensaje', array('asunto' => 'Informe General Diario'), function($message)
        use($data, $kardex, $detalle_ventas, $tienda_titulo, $emails)
        {
            $pdfInforme = PDF::loadView('informes.resumenInformeGeneralPdf',  array('data' => $data))->setOrientation('landscape')->setPaper('letter');
            $pdfVentas = PDF::loadView('informes.informePorProducto',  array('detalle_ventas' => $detalle_ventas))->setOrientation('landscape')->setPaper('letter');
            $pdfKardex = PDF::loadView('informes.kardexInformeDelDia',  array('kardex' => $kardex))->setOrientation('landscape')->setPaper('letter');

            $message->to($emails)->subject('Notificacion Informe General '.$tienda_titulo);
            $message->attachData($pdfInforme->output(), Carbon::now()."-informe.pdf");
            $message->attachData($pdfVentas->output(), Carbon::now()."-ventas.pdf");
            $message->attachData($pdfKardex->output(), Carbon::now()."-kardex.pdf");
        });

        $datos['mensaje'] = 'Mensajes enviados con exito';
        $datos['correos'] = $emails;
        return $datos;
    }

    public function verInformeTabla()
    {
        $fecha_query = "'".Input::get("fecha")."'";

        if (Input::get("fecha") == "current_date")
            $fecha_query = Input::get("fecha");

        $fecha = InformeGeneral::select(DB::raw('min(created_at) as fecha'))
        ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = DATE_FORMAT({$fecha_query}, '%Y-%m')")
        ->whereTiendaId(Auth::user()->tienda_id)->first();

        $informe = InformeGeneral::select('id')->whereCreatedAt(@$fecha->fecha)->first();

        $data = $this->resumenInformeGeneral(@$informe->id, Auth::user()->tienda_id);

        $arrayFechas = InformeGeneral::select(DB::raw('id, current_date as fecha'))
            ->whereTiendaId(Auth::user()->tienda_id)
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = DATE_FORMAT({$fecha_query}, '%Y-%m')")
            ->get();

        return Response::json(array(
            'success' => true,
            'view' => View::make('informes.resumenInformeGeneralTabla', compact('informes', 'data','arrayFechas'))->render()
        ));
    }

    public function getDetalleInformeGeneral()
    {
        $informe = InformeGeneral::find(Input::get('informe_id'));
        $data = $this->resumenInformeGeneral(Input::get('informe_id'), $informe->created_at);

        return Response::json(array(
            "success" => true,
            "table" => View::make('informes.detalleInformeGeneral', compact('data'))->render()
        ));

    }

    public function getKardexInformeDelDia()
    {
        $informe = InformeGeneral::find(Input::get('informe_id'));
        $kardex = $this->getInformeKardexConsulta();

        return Response::json(array(
            "titulo" => "INFORME DE KARDEX DEL ".substr($informe->created_at, 0, 10),
            "success" => true,
            "table" => View::make('informes.kardexInformeDelDia', compact('kardex'))->render()
        ));
    }

    public function getInformeKardexConsulta($current_date = false, $tienda_id = 0)
    {
        if ($current_date) {
            $fecha =  "current_date";
            $tienda_id = $tienda_id;
        }
        else {
            $informe = InformeGeneral::find(Input::get('informe_id'));
            $fecha =  "'".$informe->created_at."'";
            $tienda_id = Auth::user()->tienda_id;
        }

        $kardex = DB::table('kardex')
        ->select(
            "kardex.created_at as fecha",
            "productos.descripcion as producto",
            "kardex_transaccion.nombre as transaccion",
            "kardex.evento as evento",
            "kardex.cantidad as cantidad",
            "kardex.existencia as existencia",
            "kardex.costo as costo",
            "kardex.costo_promedio as costo_promedio",
            DB::raw("(kardex.costo * kardex.cantidad) as total_movimiento"),
            DB::raw("(kardex.costo_promedio * kardex.existencia) as total_acumulado"))
        ->join('productos','productos.id','=','kardex.producto_id')
        ->join('kardex_transaccion','kardex_transaccion.id','=','kardex.kardex_transaccion_id')
        ->where('kardex.tienda_id', '=', $tienda_id)
        ->whereRaw("DATE_FORMAT(kardex.created_at, '%Y-%m-%d') = DATE_FORMAT({$fecha}, '%Y-%m-%d')")
        ->get();

        return $kardex;
    }

    public function getInformePorProducto()
    {
        $informe = InformeGeneral::find(Input::get('informe_id'));

        $detalle_ventas = $this->getConsultaPorProducto();

        return Response::json(array(
            "titulo" => "INFORME DE VENTAS DEL ".substr($informe->created_at, 0, 10),
            "success" => true,
            "table" => View::make('informes.informePorProducto', compact('detalle_ventas'))->render()
        ));
    }

    public function getConsultaPorProducto($current_date = false, $tienda_id = 0)
    {
        if ($current_date) {
            $fecha =  "current_date";
            $tienda_id = $tienda_id;
        }
        else {
            $informe = InformeGeneral::find(Input::get('informe_id'));
            $fecha =  "'".$informe->created_at."'";
            $tienda_id = Auth::user()->tienda_id;
        }

        $detalle_ventas = DetalleVenta::with('producto')
            ->join('ventas', 'venta_id', '=', 'ventas.id')
            ->whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m-%d') = DATE_FORMAT({$fecha}, '%Y-%m-%d')")
            ->whereTiendaId($tienda_id)->get();

        return $detalle_ventas;
    }

    public function resumenInformeGeneral($informe_id, $fecha = 'current_date', $tienda_id = 0)
    {
        $informe = DB::table('informe_general_diario')->find($informe_id);

        $selectVenta = "sum((detalle_ventas.precio - detalle_ventas.ganancias) * detalle_ventas.cantidad)";
        $selectCompra = "sum(detalle_compras.precio * detalle_compras.cantidad)";
        $selectDescarga = "sum(detalle_descargas.precio * detalle_descargas.cantidad)";
        $selectTraslado = "sum(detalle_traslados.precio * detalle_traslados.cantidad)";
        $selectAbonosVenta = "sum(detalle_abonos_ventas.monto)";
        $selectAbonosCompra = "sum(detalle_abonos_compra.monto)";
        $selectVentaCredito = "sum(pagos_ventas.monto)";
        $selectCompraCredito = "sum(pagos_compras.monto)";

        $ventas = $this->sumTotalEntidadesConRelacion('ventas', 'detalle_ventas', 'venta_id', $selectVenta, $fecha, $tienda_id);
        $compras = $this->sumTotalEntidadesConRelacion('compras', 'detalle_compras', 'compra_id', $selectCompra, $fecha, $tienda_id);
        $descargas = $this->sumTotalEntidadesConRelacion('descargas', 'detalle_descargas', 'descarga_id', $selectDescarga, $fecha, $tienda_id);
        $traslados = $this->sumTotalEntidadesConRelacion('traslados', 'detalle_traslados', 'traslado_id', $selectTraslado, $fecha, $tienda_id);
        $abonos_ventas = $this->sumTotalEntidadesConRelacion('abonos_ventas', 'detalle_abonos_ventas', 'abonos_ventas_id', $selectAbonosVenta, $fecha, $tienda_id);
        $abonos_compras = $this->sumTotalEntidadesConRelacion('abonos_compras', 'detalle_abonos_compra', 'abonos_compra_id', $selectAbonosCompra, $fecha, $tienda_id);
        $compras_credito = $compras = $this->sumTotalEntidadesConRelacion('compras', 'pagos_compras', 'compra_id', $selectCompraCredito, $fecha, $tienda_id, true);
        $ventas_credito =  $this->sumTotalEntidadesConRelacion('ventas', 'pagos_ventas', 'venta_id', $selectVentaCredito, $fecha, $tienda_id,true);

        $data["inversionActual"] = @$informe->inversion;
        $data["cuentasCobrarActual"] =  @$informe->cuentas_cobrar;
        $data["cuentasPagarActual"] =  @$informe->cuentas_pagar;
        $data["inversionReal"] = @$informe->real_inversion;
        $data["cuentasCobrarReal"] =  @$informe->real_cuentas_cobrar;
        $data["cuentasPagarReal"] =  @$informe->real_cuentas_pagar;

        $data["ventas"] = $ventas;
        $data["compras"] = $compras;
        $data["descargas"] = $descargas;
        $data["traslados"] = $traslados;
        $data["abonos_ventas"] = $abonos_ventas;
        $data["abonos_compras"] = $abonos_compras;
        $data["compras_credito"] = $compras_credito;
        $data["ventas_credito"] = $ventas_credito;

        return $data;
    }

    /*
        Funcion para procesar la suma del detalle o de pagos de una tabla
        Devuelve una variable con el total de la suma
        Detalle (compras, ventas, traslados o descargas)
        Pagos a credito (total ventas o compras al credito)
        Abonos (abonos compras y abonos ventas) para cuentas por cobrar y cuentas por pagar
        **** Variables ****
        $tabla_maestro (puede ser ventas, compras, abonos_ventas, abonos_compras, descargas, traslados)
        $tabla_detalle (para el detalle de ventas,compras,abonos_ventas,abonos_compras, descargas, traslados o para los pagos ventas y pagos compras))
        $llaveForanea ()
        $select (son los campos que se sumaran el la consulta)
        $tienda_id ()
        $credito (es para los pagos al credito de compras y ventas)
    */

    public function sumTotalEntidadesConRelacion($tabla_maestro, $tabla_detalle, $llaveForanea, $select, $fecha, $tienda_id, $credito = false)
    {
        $fecha_query = "'".$fecha."'";

        if($tienda_id == 0)
            $tienda_id = Auth::user()->tienda_id;

        if ($fecha == "current_date")
            $fecha_query = $fecha;

        $entidad = DB::table("{$tabla_maestro}")
        ->select(DB::raw("{$select} as total "))
        ->join("{$tabla_detalle}", "{$llaveForanea}", "=", "{$tabla_maestro}.id")
        ->whereRaw("DATE_FORMAT({$tabla_maestro}.created_at, '%Y-%m-%d') = DATE_FORMAT({$fecha_query}, '%Y-%m-%d')")
        ->whereTiendaId($tienda_id);

        if ($credito)
            $entidad = $entidad->whereMetodoPagoId(2)->first();

        else
            $entidad = $entidad->first();

        return $entidad->total;
    }
}

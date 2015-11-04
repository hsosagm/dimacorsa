<?php

class InformeGeneralController extends \BaseController {

    public function procesarInformeDelDia($tienda_id)
    {
        $this->guardarInformeDelDia($tienda_id);
        $this->enviarInformeDelDia($tienda_id);
    }

    public function guardarInformeDelDia($tienda_id)
    {
        $informe = InformeGeneral::whereTiendaId($tienda_id)
        ->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') = DATE_FORMAT({$fecha_query}, '%Y-%m-%d')")
        ->get();

        $data = $this->resumenInformeGeneral($informe->id);

        $inversion = ($data['inversionActual'] + $data['compras']) - ($data['ventas'] + $data['descargas'] + $data['traslados']);
        $cuentas_cobrar = ($data['cuentasCobrarActual'] + $data['ventas_credito']) - ($data['abonos_ventas']);
        $cuentas_pagar = ($data['cuentasPagarActual'] + $data['compras_credito']) - ($data['abonos_compras']);

        $newInforme = new InformeGeneral;
        $newInforme->inversion = $inversion;
        $newInforme->cuentas_cobrar = $cuentas_cobrar;
        $newInforme->cuentas_pagar = $cuentas_pagar;
        $newInforme->save();

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
        $data = $this->resumenInformeGeneral($informe->id);

        Mail::queue('emails.mensaje', array('asunto' => 'Informe General Diario'), function($message)
        use($data, $kardex, $detalle_ventas, $tienda_titulo, $emails)
        {
            $pdfInforme = PDF::loadView('informes.resumenInformeGeneralPdf',  array('data' => $data))->setOrientation('landscape');
            $pdfVentas = PDF::loadView('informes.informePorProducto',  array('detalle_ventas' => $detalle_ventas))->setOrientation('landscape');
            $pdfKardex = PDF::loadView('informes.kardexInformeDelDia',  array('kardex' => $kardex))->setOrientation('landscape');

            $message->to($emails)->subject('Notificacion Informe General '.$tienda_titulo);
            $message->attachData($pdfInforme->output(), Carbon::now()."-informe.pdf");
            $message->attachData($pdfVentas->output(), Carbon::now()."-ventas.pdf");
            $message->attachData($pdfKardex->output(), Carbon::now()."-kardex.pdf");
        });

        echo 'Correo enviado con exito...!';
    }

    public function verInformePdf()
    {
        $data = $this->resumenInformeGeneral(Input::get('informe_id'));

        $pdf = PDF::loadView('informes.resumenInformeGeneralPdf',  array('data' => $data))->setOrientation('landscape');

        return $pdf->stream();
    }

    public function verInformeTabla()
    {
        $fecha_query = "'".Input::get("fecha")."'";

        if (Input::get("fecha") == "current_date")
            $fecha_query = Input::get("fecha");

        $informes = InformeGeneral::whereTiendaId(Auth::user()->tienda_id)
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = DATE_FORMAT({$fecha_query}, '%Y-%m')")
            ->get();

        return Response::json(array(
            'success' => true,
            'view' => View::make('informes.resumenInformeGeneralTabla', compact('informes'))->render()
        ));
    }

    public function getDetalleInformeGeneral()
    {
        $data = $this->resumenInformeGeneral(Input::get('informe_id'));

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
        if ($current_date == true)
        {
            $fecha =  "current_date";
            $tienda_id = $tienda_id;
        }
        else
        {
            $informe = InformeGeneral::find(Input::get('informe_id'));
            $fecha =  "'".$informe->created_at."'";
            $tienda_id = Auth::user()->tienda_id;
        }

        $kardex = DB::table('kardex')
        ->select("kardex.created_at as fecha",
            DB::raw("productos.descripcion as producto"),
            DB::raw("kardex_transaccion.nombre as transaccion"),
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
        if ($current_date == true)
        {
            $fecha =  "current_date";
            $tienda_id = $tienda_id;
        }
        else
        {
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

    public function resumenInformeGeneral($informe_id)
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
        $fecha = $informe->created_at;

        $ventas = $this->sumTotalEntidadesConRelacion('ventas', 'detalle_ventas', 'venta_id', $selectVenta, $fecha);
        $compras = $this->sumTotalEntidadesConRelacion('compras', 'detalle_compras', 'compra_id', $selectCompra, $fecha);
        $descargas = $this->sumTotalEntidadesConRelacion('descargas', 'detalle_descargas', 'descarga_id', $selectDescarga, $fecha);
        $traslados = $this->sumTotalEntidadesConRelacion('traslados', 'detalle_traslados', 'traslado_id', $selectTraslado, $fecha);
        $abonos_ventas = $this->sumTotalEntidadesConRelacion('abonos_ventas', 'detalle_abonos_ventas', 'abonos_ventas_id', $selectAbonosVenta, $fecha);
        $abonos_compras = $this->sumTotalEntidadesConRelacion('abonos_compras', 'detalle_abonos_compra', 'abonos_compra_id', $selectAbonosCompra, $fecha);
        $compras_credito = $compras = $this->sumTotalEntidadesConRelacion('compras', 'pagos_compras', 'compra_id', $selectCompraCredito, $fecha, true);
        $ventas_credito =  $this->sumTotalEntidadesConRelacion('ventas', 'pagos_ventas', 'venta_id', $selectVentaCredito, $fecha, true);

        $data["inversionActual"] = $informe->inversion;
        $data["cuentasCobrarActual"] =  $informe->cuentas_cobrar;
        $data["cuentasPagarActual"] =  $informe->cuentas_pagar;
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

    public function sumTotalEntidadesConRelacion($entidadPadre, $entidadHijo, $llaveForanea, $select, $fecha, $credito = false)
    {
        $fecha_query = "'".$fecha."'";

        if ($fecha == "current_date")
            $fecha_query = $fecha;

        $entidad = DB::table("{$entidadPadre}")
            ->select(DB::raw("{$select} as total "))
            ->join("{$entidadHijo}", "{$llaveForanea}", "=", "{$entidadPadre}.id")
            ->whereRaw("DATE_FORMAT({$entidadPadre}.created_at, '%Y-%m-%d') = DATE_FORMAT({$fecha_query}, '%Y-%m-%d')")
            ->whereTiendaId(Auth::user()->tienda_id);

        if ($credito == true)
            $entidad = $entidad->whereMetodoPagoId(2)->first();

        else
            $entidad = $entidad->first();

        return $entidad->total;
    }
}

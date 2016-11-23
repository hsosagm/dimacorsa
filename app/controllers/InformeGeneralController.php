<?php

class InformeGeneralController extends \BaseController {

    public function getTableInformeGeneral()
    {
        return Response::json(array(
            'success'=> true,
            'table' => View::make('informes.tableInformeGeneral')->render()
        ));
    }

    public function tableInformeGeneral_DT()
    {
        $table = 'informe_general';

        $columns = array(
            "created_at as fecha",
            "diferencia_inversion as inversion",
            "diferencia_pagar as pagar",
            "diferencia_cobrar as cobrar",
        );

        $Search_columns = array("diferencia_inversion");
        $Join = null;
        $where = null;

        echo TableSearch::get($table, $columns, $Search_columns, $Join, $where);
    }

    public function getInformeInversion()
    {
        $infInv = $this->informeInversion();

        return Response::json(array(
            'success' => true,
            'table'   => View::make('informes.DT_detalleInformeInventario', compact('infInv'))->render()
        ));
    }

    public function informeInversion()
    {
        return DB::table('informe_inversion')
        ->select(array('ventas', 'compras', 'descargas', 'traslados', 'esperado', 'real'))
        ->where('informe_general_id', Input::get('informe_general_id'))->first();
    }

    public function getInformeCuentasPorPagar()
    {
        $infInv = $this->informeCuentasPorPagar();

        return Response::json(array(
            'success' => true,
            'table'   => View::make('informes.DT_detalleInformeCuentasPorPagar', compact('infInv'))->render()
        ));
    }

    public function informeCuentasPorPagar()
    {
        return DB::table('informe_cuentas_por_pagar')
        ->select(array('creditos', 'abonos', 'esperado', 'real'))
        ->where('informe_general_id', Input::get('informe_general_id'))->first();
    }

    public function getInformeCuentasPorCobrar()
    {
        $infInv = $this->informeCuentasPorCobrar();

        return Response::json(array(
            'success' => true,
            'table'   => View::make('informes.DT_detalleInformeCuentasPorCobrar', compact('infInv'))->render()
        ));
    }

    public function informeCuentasPorCobrar()
    {
        return DB::table('informe_cuentas_por_cobrar')
        ->select(array('creditos', 'abonos', 'esperado', 'real'))
        ->where('informe_general_id', Input::get('informe_general_id'))->first();
    }


    public function procesarInformeDelDia()
    {
        $informeGeneral = DB::table('informe_general')
        ->whereRaw("id = (select max(id) from informe_general)")->first();

        if ($informeGeneral)
            $this->guardarInformeDelDia($informeGeneral);
        else
            $this->datosIniciales();
    }

    public function datosIniciales()
    {
        //consultas de lo real del sistema
        $informe_cuentas_por_pagar = Compra::first(array(DB::raw('sum(saldo) as total')));

        $informe_cuentas_por_cobrar = Venta::first(array(DB::raw('sum(saldo) as total')));

        $informe_inversion = Existencia::join('productos', 'productos.id', '=', 'existencias.producto_id')
        ->where('existencias.existencia', '>', 0)
        ->first(array(DB::raw('sum(existencias.existencia * (productos.p_costo)) as total')));

        //inversion
        $ventas = DB::table('ventas')
        ->join('detalle_ventas', 'venta_id', '=', 'ventas.id')
        ->whereRaw("DATE(ventas.created_at) = CURDATE()")
        ->first(array(DB::raw('sum((precio - ganancias) * cantidad) as total')));

        $compras = DB::table('compras')
        ->join('detalle_compras', 'compra_id', '=', 'compras.id')
        ->whereRaw("DATE(compras.created_at) = CURDATE()")
        ->first(array(DB::raw('sum(precio * cantidad) as total')));

        $descargas = DB::table('descargas')
        ->join('detalle_descargas', 'descarga_id', '=', 'descargas.id')
        ->whereRaw("DATE(descargas.created_at) = CURDATE()")
        ->first(array(DB::raw('sum(precio * cantidad) as total')));

        $traslados = DB::table('traslados')
        ->join('detalle_traslados', 'traslado_id', '=', 'traslados.id')
        ->whereRaw("DATE(traslados.created_at) = CURDATE()")
        ->first(array(DB::raw('sum(precio * cantidad) as total')));

        //cuentas por cobrar
        $creditosVentas = DB::table('ventas')
        ->join('pagos_ventas', 'venta_id', '=', 'ventas.id')
        ->whereRaw("DATE(ventas.created_at) = CURDATE()")
        ->whereMetodoPagoId(2)
        ->first(array(DB::raw('sum(monto) as total')));

        $abonosVentas = DB::table('abonos_ventas')
        ->join('detalle_abonos_ventas', 'abonos_ventas_id', '=', 'abonos_ventas.id')
        ->whereRaw("DATE(abonos_ventas.created_at) = CURDATE()")
        ->first(array(DB::raw('sum(detalle_abonos_ventas.monto) as total')));

        //cuentas por pagar
        $abonosCompras = DB::table('abonos_compras')
        ->join('detalle_abonos_compra', 'abonos_compra_id', '=', 'abonos_compras.id')
        ->whereRaw("DATE(abonos_compras.created_at) = CURDATE()")
        ->first(array(DB::raw('sum(detalle_abonos_compra.monto) as total')));

        $creditosCompras = DB::table('compras')
        ->join('pagos_compras', 'compra_id', '=', 'compras.id')
        ->whereRaw("DATE(compras.created_at) = CURDATE()")
        ->whereMetodoPagoId(2)
        ->first(array(DB::raw('sum(monto) as total')));

        //insertando informacion del dia
        $informe_general_id = DB::table('informe_general')->insertGetId(array(
            'diferencia_inversion' => 0.00,
            'diferencia_cobrar' => 0.00,
            'diferencia_pagar' => 0.00,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ));

        DB::table('informe_inversion')->insert(array(
            "informe_general_id" => $informe_general_id,
            "ventas" => 0.00,
            "compras" => 0.00,
            "descargas" => 0.00,
            "traslados" => 0.00,
            "esperado" => floatval($informe_inversion->total),
            "real" => floatval($informe_inversion->total),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ));

        DB::table('informe_cuentas_por_cobrar')->insert(array(
            "informe_general_id" => $informe_general_id,
            "creditos" => 0.00,
            "abonos" => 0.00,
            "esperado" => floatval($informe_cuentas_por_cobrar->total),
            "real" => floatval($informe_cuentas_por_cobrar->total),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ));

        DB::table('informe_cuentas_por_pagar')->insert(array(
            "informe_general_id" => $informe_general_id,
            "creditos" => 0.00,
            "abonos" => 0.00,
            "esperado" => floatval($informe_cuentas_por_pagar->total),
            "real" => floatval($informe_cuentas_por_pagar->total),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ));

        echo "Datos iniciales guardados tienda";
    }

    public function guardarInformeDelDia($informe_general_anterior)
    {
        //consultas de lo real del sistema
        $informe_cuentas_por_pagar = Compra::first(array(DB::raw('sum(saldo) as total')));

        $informe_cuentas_por_cobrar = Venta::first(array(DB::raw('sum(saldo) as total')));

        $informe_inversion = Existencia::join('productos', 'productos.id', '=', 'existencias.producto_id')
        ->first(array(DB::raw('sum(existencias.existencia * (productos.p_costo)) as total')));

        //inversion
        $ventas = DB::table('ventas')
        ->join('detalle_ventas', 'venta_id', '=', 'ventas.id')
        ->whereRaw("DATE(ventas.created_at) = CURDATE()")
        ->first(array(DB::raw('sum((precio - ganancias) * cantidad) as total')));

        $devoluciones = DB::table('devoluciones')
        ->join('devoluciones_detalle', 'devolucion_id', '=', 'devoluciones.id')
        ->whereRaw("DATE(devoluciones.created_at) = CURDATE()")
        ->first(array(DB::raw('sum((precio - ganancias) * cantidad) as total')));

        $devolucionesSobreSaldo = DB::table('devoluciones')
        ->join('devoluciones_detalle', 'devoluciones_detalle.devolucion_id', '=', 'devoluciones.id')
        ->join('devoluciones_pagos', 'devoluciones_pagos.devolucion_id', '=', 'devoluciones.id')
        ->whereRaw("DATE(devoluciones.created_at) = CURDATE()")
        ->whereMetodoPagoId(7)
        ->first(array(DB::raw('sum(precio *cantidad) as total')));

        $compras = DB::table('compras')
        ->join('detalle_compras', 'compra_id', '=', 'compras.id')
        ->whereRaw("DATE(compras.created_at) = CURDATE()")
        ->first(array(DB::raw('sum(precio * cantidad) as total')));

        $descargas = DB::table('descargas')
        ->join('detalle_descargas', 'descarga_id', '=', 'descargas.id')
        ->whereRaw("DATE(descargas.created_at) = CURDATE()")
        ->first(array(DB::raw('sum(precio * cantidad) as total')));

        $trasladosE = DB::table('traslados')
        ->join('detalle_traslados', 'traslado_id', '=', 'traslados.id')
        ->whereRaw("DATE(traslados.created_at) = CURDATE()")
        ->first(array(DB::raw('sum(precio * cantidad) as total')));

        $trasladosR = DB::table('traslados')
        ->join('detalle_traslados', 'traslado_id', '=', 'traslados.id')
        ->whereRaw("DATE(traslados.created_at) = CURDATE()")
        ->whereRaw("recibido = 1")
        ->first(array(DB::raw('sum(precio * cantidad) as total')));

        $real_informe_inversion = DB::table('informe_inversion')
        ->whereInformeGeneralId($informe_general_anterior->id)->first();

        $informe_inversion_esperado =  floatval((($real_informe_inversion->real + $compras->total + $trasladosR->total + $devoluciones->total) - ($ventas->total + $descargas->total + $trasladosE->total)));
        $informe_inversion_real = floatval($informe_inversion->total);
        $diferencia_inversion =  $informe_inversion_real - $informe_inversion_esperado;

        //cuentas por cobrar
        $creditosVentas = DB::table('ventas')
        ->join('pagos_ventas', 'venta_id', '=', 'ventas.id')
        ->whereRaw("DATE(ventas.created_at) = CURDATE()")
        ->whereMetodoPagoId(2)
        ->first(array(DB::raw('sum(monto) as total')));

        $abonosVentas = DB::table('abonos_ventas')
        ->join('detalle_abonos_ventas', 'abonos_ventas_id', '=', 'abonos_ventas.id')
        ->whereRaw("DATE(abonos_ventas.created_at) = CURDATE()")
        ->first(array(DB::raw('sum(detalle_abonos_ventas.monto) as total')));

        $real_informe_cuentas_por_cobrar = DB::table('informe_cuentas_por_cobrar')
        ->whereInformeGeneralId($informe_general_anterior->id)->first();

        $informe_cuentas_por_cobrar_esperado = floatval(($real_informe_cuentas_por_cobrar->real + $creditosVentas->total) - ($abonosVentas->total + $devolucionesSobreSaldo->total ));
        $informe_cuentas_por_cobrar_real = floatval($informe_cuentas_por_cobrar->total);
        $diferencia_cobrar = $informe_cuentas_por_cobrar_real - $informe_cuentas_por_cobrar_esperado;

        //cuentas por pagar
        $abonosCompras = DB::table('abonos_compras')
        ->join('detalle_abonos_compra', 'abonos_compra_id', '=', 'abonos_compras.id')
        ->whereRaw("DATE(abonos_compras.created_at) = CURDATE()")
        ->first(array(DB::raw('sum(detalle_abonos_compra.monto) as total')));

        $creditosCompras = DB::table('compras')
        ->join('pagos_compras', 'compra_id', '=', 'compras.id')
        ->whereRaw("DATE(compras.created_at) = CURDATE()")
        ->whereMetodoPagoId(2)
        ->first(array(DB::raw('sum(monto) as total')));

        $real_informe_cuentas_por_pagar = DB::table('informe_cuentas_por_pagar')
        ->whereInformeGeneralId($informe_general_anterior->id)->first();

        $informe_cuentas_por_pagar_esperado = floatval(($real_informe_cuentas_por_pagar->real + $creditosCompras->total) - $abonosCompras->total);
        $informe_cuentas_por_pagar_real = floatval($informe_cuentas_por_pagar->total);
        $diferencia_pagar = $informe_cuentas_por_pagar_real - $informe_cuentas_por_pagar_esperado;

        //insertando informacion del dia
        $informe_general_id = DB::table('informe_general')->insertGetId(array(
            'diferencia_inversion' => 0.00,
            'diferencia_cobrar' => 0.00,
            'diferencia_pagar' => 0.00,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ));

        DB::table('informe_inversion')->insert(array(
            "informe_general_id" => $informe_general_id,
            "ventas" => floatval($ventas->total),
            "compras" => floatval($compras->total),
            "descargas" => floatval($descargas->total),
            "traslados" => floatval($trasladosE->total),
            "esperado" => $informe_inversion_esperado,
            "real" => $informe_inversion_real,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ));

        DB::table('informe_cuentas_por_cobrar')->insert(array(
            "informe_general_id" => $informe_general_id,
            "creditos" => floatval($creditosVentas->total),
            "abonos" => floatval($abonosVentas->total),
            "esperado" => $informe_cuentas_por_cobrar_esperado,
            "real" => $informe_cuentas_por_cobrar_real,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ));

        DB::table('informe_cuentas_por_pagar')->insert(array(
            "informe_general_id" => $informe_general_id,
            "creditos" => floatval($creditosCompras->total),
            "abonos" => floatval($abonosCompras->total),
            "esperado" => floatval($informe_cuentas_por_pagar_esperado),
            "real" => floatval($informe_cuentas_por_pagar_real),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ));

        DB::table('informe_cuentas_por_pagar')->insert(array(
            "informe_general_id" => $informe_general_id,
            "creditos" => floatval($creditosCompras->total),
            "abonos" => floatval($abonosCompras->total),
            "esperado" => $informe_cuentas_por_pagar_esperado,
            "real" => $informe_cuentas_por_pagar_real,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ));

        $informe_general_id = DB::table('informe_general')->whereId($informe_general_id)
        ->update(array(
            'diferencia_inversion' => $diferencia_inversion,
            'diferencia_cobrar' => $diferencia_cobrar,
            'diferencia_pagar' => $diferencia_pagar
        ));

        echo "Informe general almacenado con exito...";
    }

    public function getDetalleInformeGeneral()
    {
        $informeGeneral = InformeGeneral::find(Input::get('informe_id'));
        $data = $this->resumenInformeGeneral(Input::get('informe_id'), $informeGeneral->created_at);

        return Response::json(array(
            "success" => true,
            "table" => View::make('informes.detalleInformeGeneral', compact('data'))->render()
        ));

    }

    public function getKardexInformeDelDia()
    {
        $informeGeneral = InformeGeneral::find(Input::get('informe_id'));
        $kardex = $this->getInformeKardexConsulta();

        return Response::json(array(
            "titulo" => "INFORME DE KARDEX DEL ".substr($informeGeneral->created_at, 0, 10),
            "success" => true,
            "table" => View::make('informes.kardexInformeDelDia', compact('kardex'))->render()
        ));
    }

    /*
        $tienda_id = 0
        es para cuando se consulta desde la aplicacion el kardex respectivos de la tienda en la que el usuario esta logueado
    */
    public function getInformeKardexConsulta($current_date = false, $tienda_id = 0)
    {
        if ($current_date) {
            $fecha =  "current_date";
            $tienda_id = $tienda_id;
        }
        else {
            $informeGeneral = InformeGeneral::find(Input::get('informe_id'));
            $fecha =  "'".$informeGeneral->created_at."'";
            $tienda_id = @Auth::user()->tienda_id;
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
        $informeGeneral = InformeGeneral::find(Input::get('informe_id'));

        $detalle_ventas = $this->getConsultaPorProducto();

        return Response::json(array(
            "titulo" => "INFORME DE VENTAS DEL ".substr($informeGeneral->created_at, 0, 10),
            "success" => true,
            "table" => View::make('informes.informePorProducto', compact('detalle_ventas'))->render()
        ));
    }

    /*
        $tienda_id = 0
        es para cuando se consulta desde la aplicacion los detalle de ventas respectivos de la tienda en la que el usuario esta logueado
    */
    public function getConsultaPorProducto($current_date = false, $tienda_id = 0)
    {
        if ($current_date) {
            $fecha =  "current_date";
            $tienda_id = $tienda_id;
        }
        else {
            $informeGeneral = InformeGeneral::find(Input::get('informe_id'));
            $fecha =  "'".$informeGeneral->created_at."'";
            $tienda_id = @Auth::user()->tienda_id;
        }

        $detalle_ventas = DetalleVenta::with('producto')
            ->join('ventas', 'venta_id', '=', 'ventas.id')
            ->whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m-%d') = DATE_FORMAT({$fecha}, '%Y-%m-%d')")
            ->whereTiendaId($tienda_id)->get();

        return $detalle_ventas;
    }

    /*
        $tienda_id = 0
        es para cuando se consulta desde la aplicacion los informes respectivos de la tienda en la que el usuario esta logueado
    */
    public function resumenInformeGeneral($informe_id, $fecha = 'current_date', $tienda_id = 0)
    {
        if ($tienda_id == 0)
            $tienda_id = @Auth::user()->tienda_id;

        $informe = DB::table('informe_general_diario')->find($informe_id);

        $informe_old = DB::table('informe_general_diario')->whereTiendaId($tienda_id)
        ->where('id', '<', $informe_id)->orderBy('id','desc')->first();

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
        $compras_credito = $this->sumTotalEntidadesConRelacion('compras', 'pagos_compras', 'compra_id', $selectCompraCredito, $fecha, $tienda_id, true);
        $ventas_credito =  $this->sumTotalEntidadesConRelacion('ventas', 'pagos_ventas', 'venta_id', $selectVentaCredito, $fecha, $tienda_id,true);

        $data["inversionActual"] = @$informe_old->inversion;
        $data["cuentasCobrarActual"] =  @$informe_old->cuentas_cobrar;
        $data["cuentasPagarActual"] =  @$informe_old->cuentas_pagar;
        $data["inversionReal"] = @$informe->inversion;
        $data["cuentasCobrarReal"] =  @$informe->cuentas_cobrar;
        $data["cuentasPagarReal"] =  @$informe->cuentas_pagar;

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
            $tienda_id = @Auth::user()->tienda_id;

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

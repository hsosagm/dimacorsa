<?php

class CierreController extends \BaseController {

    function CierreDelDia()
    {   
      //consulta para obtener los abonos a compras
        $query_abonos_ventas = DB::table('metodo_pago')
       ->select(DB::raw('metodo_pago.descripcion as descripcion, sum(monto) as total'))
       ->join('detalle_abonos_venta','detalle_abonos_venta.metodo_pago_id','=','metodo_pago.id')
       ->whereRaw("DATE_FORMAT(detalle_abonos_venta.created_at, '%Y-%m-%d')= DATE_FORMAT(current_date, '%Y-%m-%d')")
       ->groupBy('metodo_pago.id')->get();

       $abonos_ventas = $this->llenar_arreglo($query_abonos_ventas);

        //consulta para obtener los pagos de compraas
       $query_pagos_ventas = DB::table('metodo_pago')
       ->select(DB::raw('metodo_pago.descripcion as descripcion, sum(monto) as total'))
       ->join('pagos_ventas','pagos_ventas.metodo_pago_id','=','metodo_pago.id')
       ->whereRaw("DATE_FORMAT(pagos_ventas.created_at, '%Y-%m-%d')= DATE_FORMAT(current_date, '%Y-%m-%d')")
       ->groupBy('metodo_pago.id')->get();

       $pagos_ventas = $this->llenar_arreglo($query_pagos_ventas);

        //consulta para obtener los soportes
        $query_soporte = DB::table('metodo_pago')
       ->select(DB::raw('metodo_pago.descripcion as descripcion, sum(monto) as total'))
       ->join('detalle_soporte','detalle_soporte.metodo_pago_id','=','metodo_pago.id')
       ->whereRaw("DATE_FORMAT(detalle_soporte.created_at, '%Y-%m-%d')= DATE_FORMAT(current_date, '%Y-%m-%d')")
       ->groupBy('metodo_pago.id')->get();

       $soporte = $this->llenar_arreglo($query_soporte);

       //consulta para obtener los adelantos
        $query_adelantos = DB::table('metodo_pago')
       ->select(DB::raw('metodo_pago.descripcion as descripcion, sum(monto) as total'))
       ->join('detalle_adelantos','detalle_adelantos.metodo_pago_id','=','metodo_pago.id')
       ->whereRaw("DATE_FORMAT(detalle_adelantos.created_at, '%Y-%m-%d')= DATE_FORMAT(current_date, '%Y-%m-%d')")
       ->groupBy('metodo_pago.id')->get();

       $adelantos = $this->llenar_arreglo($query_adelantos);

        //consulta para obtener los ingresos
        $query_ingresos = DB::table('metodo_pago')
       ->select(DB::raw('metodo_pago.descripcion as descripcion, sum(monto) as total'))
       ->join('detalle_ingresos','detalle_ingresos.metodo_pago_id','=','metodo_pago.id')
       ->whereRaw("DATE_FORMAT(detalle_ingresos.created_at, '%Y-%m-%d')= DATE_FORMAT(current_date, '%Y-%m-%d')")
       ->groupBy('metodo_pago.id')->get();

       $ingresos = $this->llenar_arreglo($query_ingresos);

        //consulta para obtener los gastos
        $query_gastos = DB::table('metodo_pago')
       ->select(DB::raw('metodo_pago.descripcion as descripcion, sum(monto) as total'))
       ->join('detalle_gastos','detalle_gastos.metodo_pago_id','=','metodo_pago.id')
       ->whereRaw("DATE_FORMAT(detalle_gastos.created_at, '%Y-%m-%d')= DATE_FORMAT(current_date, '%Y-%m-%d')")
       ->groupBy('metodo_pago.id')->get();

       $gastos = $this->llenar_arreglo($query_gastos);

        //consulta para obtener los egresos
        $query_egresos = DB::table('metodo_pago')
       ->select(DB::raw('metodo_pago.descripcion as descripcion, sum(monto) as total'))
       ->join('detalle_egresos','detalle_egresos.metodo_pago_id','=','metodo_pago.id')
       ->whereRaw("DATE_FORMAT(detalle_egresos.created_at, '%Y-%m-%d')= DATE_FORMAT(current_date, '%Y-%m-%d')")
       ->groupBy('metodo_pago.id')->get();

       $egresos = $this->llenar_arreglo($query_egresos);

        //consulta para obtener los abonos a compras
        $query_abonos_compras = DB::table('metodo_pago')
       ->select(DB::raw('metodo_pago.descripcion as descripcion, sum(monto) as total'))
       ->join('detalle_abonos_compra','detalle_abonos_compra.metodo_pago_id','=','metodo_pago.id')
       ->whereRaw("DATE_FORMAT(detalle_abonos_compra.created_at, '%Y-%m-%d')= DATE_FORMAT(current_date, '%Y-%m-%d')")
       ->groupBy('metodo_pago.id')->get();

       $abonos_compras = $this->llenar_arreglo($query_abonos_compras);

        //consulta para obtener los pagos de compraas
       $query_pagos_compras = DB::table('metodo_pago')
       ->select(DB::raw('metodo_pago.descripcion as descripcion, sum(monto) as total'))
       ->join('pagos_compras','pagos_compras.metodo_pago_id','=','metodo_pago.id')
       ->whereRaw("DATE_FORMAT(pagos_compras.created_at, '%Y-%m-%d')= DATE_FORMAT(current_date, '%Y-%m-%d')")
       ->groupBy('metodo_pago.id')->get();

       $pagos_compras = $this->llenar_arreglo($query_pagos_compras);

       return View::make('cierre.table',compact('pagos_compras','abonos_compras','egresos','gastos','ingresos','adelantos','soporte','abonos_ventas','pagos_ventas'));

   }

   function llenar_arreglo($arreglo)
   {
    $arreglo_ordenado = array( 
        'efectivo'=>"0.00",
        'credito' =>"0.00",
        'cheque'  =>"0.00",
        'tarjeta' =>"0.00",
        'deposito'=>"0.00",
        'total'   =>"0.00");

    foreach ($arreglo as $key => $val) 
    {   
        if($val->descripcion == 'Efectivo')
            $arreglo_ordenado['efectivo'] = $val->total;

        if($val->descripcion == 'Credito')
            $arreglo_ordenado['credito'] = $val->total;

        if($val->descripcion == 'Cheque')
            $arreglo_ordenado['cheque'] = $val->total;

        if($val->descripcion == 'Tarjeta')
            $arreglo_ordenado['tarjeta'] = $val->total;

        if($val->descripcion == 'Deposito')
            $arreglo_ordenado['deposito '] = $val->total;

        $arreglo_ordenado['total'] = $arreglo_ordenado['total'] + $val->total;
    }

    return $arreglo_ordenado;
}

}
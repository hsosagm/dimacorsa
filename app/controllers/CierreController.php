<?php 

class CierreController extends \BaseController {

    function CierreDelDia()
    {    
      //consulta para obtener los abonos a compras
        $query_abonos_ventas = DB::table('metodo_pago')
       ->select(DB::raw('metodo_pago.descripcion as descripcion, sum(monto) as total'))
       ->join('abonos_ventas','abonos_ventas.metodo_pago_id','=','metodo_pago.id')
       ->whereRaw("DATE_FORMAT(abonos_ventas.created_at, '%Y-%m-%d')= DATE_FORMAT(current_date, '%Y-%m-%d')")
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
       ->select(DB::raw('metodo_pago.descripcion as descripcion, sum(total) as total'))
       ->join('abonos_compras','abonos_compras.metodo_pago_id','=','metodo_pago.id')
       ->whereRaw("DATE_FORMAT(abonos_compras.created_at, '%Y-%m-%d')= DATE_FORMAT(current_date, '%Y-%m-%d')")
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

   function CierreDelMes()
   {

      $ventas = Venta::whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m')= DATE_FORMAT(current_date, '%Y-%m')")->first(array(DB::raw('sum(total) as total')));

      $ganancias  = DetalleVenta::whereRaw("DATE_FORMAT(detalle_ventas.created_at, '%Y-%m')= DATE_FORMAT(current_date, '%Y-%m')")->first(array(DB::raw(' sum(cantidad * ganancias) as total')));

       $soporte = Soporte::join('detalle_soporte','detalle_soporte.soporte_id','=','soporte.id')
      ->whereRaw("DATE_FORMAT(soporte.created_at, '%Y-%m')= DATE_FORMAT(current_date, '%Y-%m')")
      ->first(array(DB::raw('sum(monto) as total')));

      $gastos = Gasto::join('detalle_gastos','detalle_gastos.gasto_id','=','gastos.id')
      ->whereRaw("DATE_FORMAT(gastos.created_at, '%Y-%m')= DATE_FORMAT(current_date, '%Y-%m')")
      ->first(array(DB::raw('sum(monto) as total')));

      $compras = Compra::where('tienda_id','=',Auth::user()->tienda_id)
      ->first(array(DB::raw('sum(saldo) as total')));

      $ventas_c = Venta::where('tienda_id','=',Auth::user()->tienda_id)
      ->first(array(DB::raw('sum(saldo) as total')));
        
      $inversion = Existencia::join('productos','productos.id','=','existencias.producto_id')
      ->where('tienda_id','=',Auth::user()->tienda_id)
      ->where('existencias.existencia','>', 0)
      ->first(array(DB::raw('sum(existencias.existencia * (productos.p_costo/100)) as total')));

      $ventas_usuarios =  DB::table('users')
      ->select(DB::raw('users.nombre, users.apellido,
                        sum(detalle_ventas.cantidad * detalle_ventas.precio) as total,
                        sum(detalle_ventas.cantidad * detalle_ventas.ganancias) as utilidad'))
      ->join('ventas','ventas.user_id','=','users.id')
      ->join('detalle_ventas','detalle_ventas.venta_id','=','ventas.id')
      ->where('users.tienda_id','=',Auth::user()->tienda_id)
      ->where('users.status','=',1)
      ->whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m')= DATE_FORMAT(current_date, '%Y-%m')")
      ->groupBy('users.id','users.nombre','users.apellido')->get();

      $total_ventas    = f_num::get($ventas->total);
      $total_ganancias = f_num::get($ganancias->total);
      $total_soporte   = f_num::get($soporte->total);
      $total_gastos    = f_num::get($gastos->total);
      $ganancias_netas = f_num::get(($ganancias->total+$soporte->total)-$gastos->total);
      $compras_credito = f_num::get($compras->total);
      $ventas_credito =  f_num::get($ventas_c->total);
      $inversion_actual = f_num::get($inversion->total);
 
      return View::make('cierre.CierreMes',compact('total_ventas','total_ganancias','total_soporte','total_gastos','ganancias_netas','ventas_usuarios','compras_credito','ventas_credito','inversion_actual'));
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
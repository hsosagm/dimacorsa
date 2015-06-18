<?php 

class CierreController extends \BaseController {

    function CierreDelDia()
    {    
        $abonos_ventas = $this->generar_consulta('abonos_ventas','monto');

        $pagos_ventas = $this->generar_consulta('pagos_ventas','monto');

        $soporte = $this->generar_consulta('detalle_soporte','monto');

        $adelantos = $this->generar_consulta('detalle_adelantos','monto');

        $ingresos = $this->generar_consulta('detalle_ingresos','monto');

        $gastos = $this->generar_consulta('detalle_gastos','monto');

        $egresos = $this->generar_consulta('detalle_egresos','monto');

        $abonos_compras = $this->generar_consulta('abonos_compras','total');

        $pagos_compras = $this->generar_consulta('pagos_compras','monto');

        return View::make('cierre.CierreDia',compact('pagos_compras','abonos_compras','egresos','gastos','ingresos','adelantos','soporte','abonos_ventas','pagos_ventas'));

    }

    //funcion para genrar la consulta agrupandolos por el metodo de pago
    //$tabla = es la tabla a la que se le va a sumar el $campo que mande como segundo parametro
    function generar_consulta( $tabla , $campo )
    {
        $Query = DB::table('metodo_pago')
        ->select(DB::raw("metodo_pago.descripcion as descripcion, sum({$campo}) as total"))
        ->join($tabla,"{$tabla}.metodo_pago_id" , "=" , "metodo_pago.id")
        ->whereRaw("DATE_FORMAT({$tabla}.created_at, '%Y-%m-%d')= DATE_FORMAT(current_date, '%Y-%m-%d')")
        ->groupBy('metodo_pago.id')->get();

        return $this->llenar_arreglo($Query);
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

    function CierreDelMes()
    {
        $ventas = Venta::whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m')= DATE_FORMAT(current_date, '%Y-%m')")
        ->first(array(DB::raw('sum(total) as total')));

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

        $total_ventas     = f_num::get($ventas->total   );
        $total_ganancias  = f_num::get($ganancias->total);
        $total_soporte    = f_num::get($soporte->total  );
        $total_gastos     = f_num::get($gastos->total   );
        $compras_credito  = f_num::get($compras->total  );
        $ventas_credito   = f_num::get($ventas_c->total );
        $inversion_actual = f_num::get($inversion->total);
        $ganancias_netas  = f_num::get(($ganancias->total+$soporte->total)-$gastos->total);

        return View::make('cierre.CierreMes',compact('total_ventas','total_ganancias','total_soporte','total_gastos','ganancias_netas','ventas_usuarios','compras_credito','ventas_credito','inversion_actual'));
    }

}

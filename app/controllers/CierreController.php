<?php 

class CierreController extends \BaseController {

    function CierreDelDia()
    {
        $data = $this->resumen_movimientos('current_date');

        return View::make('cierre.CierreDia',compact('data'));
    }

    public function CierreDelDiaPorFecha()
    {
        $data = $this->resumen_movimientos(Input::get('fecha'));

        return View::make('cierre.CierreDia',compact('data'));
    }

    //funcion para genrar la consulta agrupandolos por el metodo de pago
    //$tabla = es la tabla a la que se le va a sumar el $campo que mande como segundo parametro
    function query( $tabla , $campo , $fecha )
    {
        $fecha_enviar = "'{$fecha}'";

        if ($fecha == 'current_date') 
            $fecha_enviar = 'current_date';

        $Query = DB::table('metodo_pago')
        ->select(DB::raw("metodo_pago.descripcion as descripcion, sum({$campo}) as total"))
        ->join($tabla,"{$tabla}.metodo_pago_id" , "=" , "metodo_pago.id")
        ->whereRaw("DATE_FORMAT({$tabla}.created_at, '%Y-%m-%d')= DATE_FORMAT({$fecha_enviar}, '%Y-%m-%d')")
        ->groupBy('metodo_pago.id')->get();

        return $this->llenar_arreglo($Query);
    }

    //funcion para ordenar el arreglo de los metodos de pago
    //retorna un arreglo de una dimencion 
    //forma de uso $arreglo['efectivo']
    function llenar_arreglo($Query)
    {
        $arreglo_ordenado = array( 
            'efectivo'=>"0.00",
            'credito' =>"0.00",
            'cheque'  =>"0.00",
            'tarjeta' =>"0.00",
            'deposito'=>"0.00",
            'total'   =>"0.00"
        );

        foreach ($Query as $key => $val) 
        {   
            if($val->descripcion == 'Efectivo')
                $arreglo_ordenado['efectivo'] = $val->total;

            if($val->descripcion == 'Credito')
                $arreglo_ordenado['credito'] = $val->total;

            if($val->descripcion == 'Cheque')
                $arreglo_ordenado['cheque'] = $val->total;

            if($val->descripcion == 'Tarjeta')
                $arreglo_ordenado['tarjeta'] = $val->total;

            if($val->descripcion == 'Deposito'){
                $arreglo_ordenado['deposito'] = $val->total;
            }

            $arreglo_ordenado['total'] = $arreglo_ordenado['total'] + $val->total;
        }

        return $arreglo_ordenado;
    }

    function CierreDelMes()
    {
        $ventas = Venta::where('ventas.tienda_id' , '=' , Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m')= DATE_FORMAT(current_date, '%Y-%m')")
        ->first(array(DB::raw('sum(total) as total')));

       $ganancias =  DB::table('users')
        ->select(DB::raw('sum(detalle_ventas.cantidad * detalle_ventas.ganancias) as total'))
        ->join('ventas','ventas.user_id','=','users.id')
        ->join('detalle_ventas','detalle_ventas.venta_id','=','ventas.id')
        ->where('users.tienda_id','=',Auth::user()->tienda_id)->where('users.status','=',1)
        ->whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m')= DATE_FORMAT(current_date, '%Y-%m')")
        ->orderBy('total', 'DESC')->first();

        $soporte = Soporte::join('detalle_soporte','detalle_soporte.soporte_id','=','soporte.id')
        ->where('tienda_id','=',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(soporte.created_at, '%Y-%m')= DATE_FORMAT(current_date, '%Y-%m')")
        ->first(array(DB::raw('sum(monto) as total')));

        $gastos = Gasto::join('detalle_gastos','detalle_gastos.gasto_id','=','gastos.id')
        ->where('tienda_id','=',Auth::user()->tienda_id)
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
        ->orderBy('total', 'DESC')
        ->groupBy('users.id','users.nombre','users.apellido')
        ->get();

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


    function cierre()
    {
        if ( Input::has('_token') )
        {
            $cierre = new Cierre;

            if (!$cierre->create_master())
            {
                return $cierre->errors();
            }

            return Response::json(array( 'success' => true ));
        }

        $query = Cierre::where(DB::raw('DATE(created_at)'), '=', DATE('Y-m-d'))
            ->where('tienda_id', Auth::user()->tienda_id)
            ->first();

        if (count($query))
            return Response::json(array(
                'success' => false,
                'user' => $query->user->nombre. " " . $query->user->apellido
            ));

        $data = $this->resumen_movimientos('current_date');

        $efectivo = $data['adelantos']['efectivo'] + $data['soporte']['efectivo'] + $data['pagos_ventas']['efectivo'] + $data['abonos_ventas']['efectivo']
        - $data['gastos']['efectivo'] - $data['egresos']['efectivo'] - $data['pagos_compras']['efectivo'] - $data['abonos_compras']['efectivo'];

        $cheque = $data['pagos_ventas']['cheque'] + $data['abonos_ventas']['cheque'] + $data['soporte']['cheque'] + $data['adelantos']['cheque'] + $data['ingresos']['cheque'];
        $tarjeta = $data['pagos_ventas']['tarjeta'] + $data['abonos_ventas']['tarjeta'] + $data['soporte']['tarjeta'] + $data['adelantos']['tarjeta'] + $data['ingresos']['tarjeta'];
        
        $deposito = $data['pagos_ventas']['deposito'] + $data['abonos_ventas']['deposito'] + $data['soporte']['deposito'] + $data['adelantos']['deposito'] + $data['ingresos']['deposito'];

        $movimientos = array(
            'efectivo' => $efectivo,
            'cheque'   => $cheque,
            'tarjeta'  => $tarjeta,
            'deposito' => $deposito
        );

        $movimientos = json_encode($movimientos);

        return Response::json(array(
            'success' => true,
            'form' => View::make('cierre.cierre', compact('movimientos'))->render()
        ));
    }

    //Funcion que nos retorna una matriz de dos dimenciones
    //su forma de uso es  $data['pagos_ventas']['efectivo'];
    public function resumen_movimientos($fecha)
    {
        $data = [];

        $data['pagos_ventas']     =   $this->query('pagos_ventas','monto',$fecha);
        $data['abonos_ventas']    =   $this->query('abonos_ventas','monto',$fecha);
        $data['soporte']          =   $this->query('detalle_soporte','monto',$fecha);
        $data['adelantos']        =   $this->query('detalle_adelantos','monto',$fecha);
        $data['ingresos']         =   $this->query('detalle_ingresos','monto',$fecha);
        $data['egresos']          =   $this->query('detalle_egresos','monto',$fecha);
        $data['gastos']           =   $this->query('detalle_gastos','monto',$fecha);
        $data['abonos_compras']   =   $this->query('abonos_compras','total',$fecha);
        $data['pagos_compras']    =   $this->query('pagos_compras','monto',$fecha);

        return $data;
    }

    function CierreDelMesPorFecha()
    {

        $fecha = Input::get('fecha');

        $ventas = Venta::where('ventas.tienda_id' , '=' , Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m')= DATE_FORMAT('{$fecha}', '%Y-%m')")
        ->first(array(DB::raw('sum(total) as total')));

        $ganancias =  DB::table('users')
        ->select(DB::raw('sum(detalle_ventas.cantidad * detalle_ventas.ganancias) as total'))
        ->join('ventas','ventas.user_id','=','users.id')
        ->join('detalle_ventas','detalle_ventas.venta_id','=','ventas.id')
        ->where('users.tienda_id','=',Auth::user()->tienda_id)->where('users.status','=',1)
        ->whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m')= DATE_FORMAT('{$fecha}', '%Y-%m')")
        ->orderBy('total', 'DESC')->first();

        $soporte = Soporte::join('detalle_soporte','detalle_soporte.soporte_id','=','soporte.id')
        ->where('tienda_id','=',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(soporte.created_at, '%Y-%m')= DATE_FORMAT('{$fecha}', '%Y-%m')")
        ->first(array(DB::raw('sum(monto) as total')));

        $gastos = Gasto::join('detalle_gastos','detalle_gastos.gasto_id','=','gastos.id')
        ->where('tienda_id','=',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(gastos.created_at, '%Y-%m')= DATE_FORMAT('{$fecha}', '%Y-%m')")
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
        ->whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m')= DATE_FORMAT('{$fecha}', '%Y-%m')")
        ->orderBy('total', 'DESC')
        ->groupBy('users.id','users.nombre','users.apellido')
        ->get();

        $total_ventas     = f_num::get($ventas->total   );
        $total_ganancias  = f_num::get($ganancias->total);
        $total_soporte    = f_num::get($soporte->total  );
        $total_gastos     = f_num::get($gastos->total   );
        $compras_credito  = f_num::get($compras->total  );
        $ventas_credito   = f_num::get($ventas_c->total );
        $inversion_actual = f_num::get($inversion->total);
        $ganancias_netas  = f_num::get(($ganancias->total+$soporte->total)-$gastos->total);

        return View::make('cierre.CierreMes',compact('total_ventas','total_ganancias','total_soporte','total_gastos','ganancias_netas','ventas_usuarios','compras_credito','ventas_credito','inversion_actual','fecha'));
    }


}

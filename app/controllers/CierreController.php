<?php 

class CierreController extends \BaseController {

    function CierreDelDia()
    {
        $data = $this->resumen_movimientos('current_date');
        $fecha = 'current_date';
        return View::make('cierre.CierreDia',compact('data','fecha'));
    }

    public function ExportarCierreDelDia($tipo,$fecha)
    {
        $data = $this->resumen_movimientos($fecha);

        $caja_negativos = $data['abonos_compras']['efectivo'] + $data['pagos_compras']['efectivo'] + $data['egresos']['efectivo'] + $data['gastos']['efectivo'];
        $caja_positivos = $data['ingresos']['efectivo'] + $data['adelantos']['efectivo'] + $data['soporte']['efectivo'] + $data['pagos_ventas']['efectivo'] + $data['abonos_ventas']['efectivo'];
        $caja =  $caja_positivos - $caja_negativos;
        $esperado_caja = f_num::get($caja); 
        if ($fecha == 'current_date')
            $fecha = Carbon::now();

        $data['pagos_ventas']['titulo']   = 'Ventas';
        $data['abonos_ventas']['titulo']  = 'Abonos';
        $data['soporte']['titulo']        = 'Soporte';
        $data['adelantos']['titulo']      = 'Adelantos';
        $data['ingresos']['titulo']       = 'Ingresos';
        $data['egresos']['titulo']        = 'Egresos';
        $data['gastos']['titulo']         = 'Gastos';
        $data['abonos_compras']['titulo'] = 'Abonos Compras';
        $data['pagos_compras']['titulo']  = 'Pagos Compras';
        $data['resultados'] = array('Efectivo esperado en caja' ,$esperado_caja,'','Fecha:','',$fecha);

        Excel::create('Cierre del dia', function($excel) use($data) 
        {
            $excel->setTitle('Cierre del dia');
            $excel->setCreator('Leonel Madrid [ leonel.madrid@hotmail.com ]')
            ->setCompany('Click Chiquimula');
            $excel->setDescription('Creada desde la aplicacion web @powerby Nelug');
            $excel->setSubject('Click');

            $excel->sheet('datos', function($hoja) use($data) 
            {
                $hoja->setBorder('A1:G13', 'dashDotDot');
                $hoja->setOrientation('landscape');
                $hoja->fromArray($data, null, 'A3', true);
                //$sheet->loadView('cierre.CierreDia', array('data' => $data , 'fecha' => ''));
                $hoja->appendRow( 1, array(
                    'Constancia de movimientos del dia'
                ));
                $hoja->cells('A3:G3', function($celda) 
                {   
                     $celda->setValignment('middle');
                     $celda->setAlignment('center');
                });
                $hoja->cells('A3:A13', function($celda) 
                {   
                     $celda->setValignment('middle');
                     $celda->setAlignment('left');
                });
                $hoja->cells('B3:G13', function($celda) 
                {   
                     $celda->setValignment('middle');
                     $celda->setAlignment('right');
                });
                $hoja->setColumnFormat(array(
                    'B3:G13' => '#,##0.00_-'
                ));
                $hoja->setWidth(array(
                    'A'     =>  30,  'B'     =>  15,
                    'C'     =>  15,  'D'     =>  15,
                    'E'     =>  15,  'F'     =>  15,
                    'G'     =>  15,  
                ));
                $hoja->setHeight(array(
                   1     =>  23,     5 =>  23,     9 =>  23,    13 =>  23,
                   2     =>  23,     6 =>  23,     10 =>  23,
                   3     =>  23,     7 =>  23,     11 =>  23,
                   4     =>  23,     8 =>  23,     12 =>  23,
                ));
            });

        })->export("{$tipo}");
    }

    public function CierreDelDiaPorFecha()
    {
        $data = $this->resumen_movimientos(Input::get('fecha'));
        $fecha = Input::get('fecha');
        return View::make('cierre.CierreDia',compact('data','fecha'));
    }

    /*
        funcion para ordenar el arreglo de los metodos de pago
        retorna un arreglo de una dimencion 
        forma de uso $arreglo['efectivo']
    */
    function llenar_arreglo($Query)
    {
        $arreglo_ordenado = array( 
            'titulo'  => '',
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

                return Response::json(array( 
                    'success' => true ,
                    'id' => $cierre->get_id()
                    ));
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

    /*
        Funcion que nos retorna una matriz de dos dimencionespero voy a esperar que este solo
        su forma de uso es  $data['pagos_ventas']['efectivo'];
    */
    public function resumen_movimientos($fecha)
    {
        $data = [];

        $data['pagos_ventas']     =   $this->_query('pagos_ventas','venta','monto',$fecha); //lo tiene en la tabla ventas.tienda_id
        $data['abonos_ventas']    =   $this->query('abonos_ventas','monto',$fecha); // si tiene tienda_id
        $data['soporte']          =   $this->__query('detalle_soporte','soporte','monto',$fecha); //lo tieene en la tabla soporte.tienda_id
        $data['adelantos']        =   $this->_query('detalle_adelantos','adelanto','monto',$fecha); //lo tiene en la tabla adelantos
        $data['ingresos']         =   $this->_query('detalle_ingresos','ingreso','monto',$fecha); //lo tiene en la tabla ingresos
        $data['egresos']          =   $this->_query('detalle_egresos','egreso','monto',$fecha); // lo tiene en la tabla egreso
        $data['gastos']           =   $this->_query('detalle_gastos','gasto','monto',$fecha); // lo tiene en la tabla gastos
        $data['abonos_compras']   =   $this->query('abonos_compras','monto',$fecha); //si tiene tienda_id
        $data['pagos_compras']    =   $this->_query('pagos_compras','compra','monto',$fecha); // lo tiene en la tabla compras.tienda_id
        $data['resultados']       =   array();
        return $data;
    }

    /*********************************************************************************************************************************    
        Inicio de Funciones para generar la consulta agrupandolos por el metodo de pago
    **********************************************************************************************************************************/

    // funcion cuando la tabla si tiene el campo tienda id
        function query( $tabla , $campo , $fecha ) 
        {
            $fecha_enviar = "'{$fecha}'";

            if ($fecha == 'current_date') 
                $fecha_enviar = 'current_date';

            $Query = DB::table('metodo_pago')
            ->select(DB::raw("metodo_pago.descripcion as descripcion, sum({$campo}) as total"))
            ->join($tabla,"{$tabla}.metodo_pago_id" , "=" , "metodo_pago.id")
            ->whereRaw("DATE_FORMAT({$tabla}.created_at, '%Y-%m-%d')= DATE_FORMAT({$fecha_enviar}, '%Y-%m-%d')")
            ->where("{$tabla}.tienda_id", '=' , Auth::user()->tienda_id)
            ->groupBy('metodo_pago.id')->get();

            return $this->llenar_arreglo($Query);
        }

    // funcion cuando la tabla no tiene el campo tienda id y  el nombre de la tabla que tiene el campo esta en plural
        function _query( $tabla ,$tabla_master, $campo , $fecha ) 
        {
            $fecha_enviar = "'{$fecha}'";

            if ($fecha == 'current_date') 
                $fecha_enviar = 'current_date';

            $Query = DB::table('metodo_pago')
            ->select(DB::raw("metodo_pago.descripcion as descripcion, sum({$campo}) as total"))
            ->join($tabla,"{$tabla}.metodo_pago_id" , "=" , "metodo_pago.id")
            ->join("{$tabla_master}s","{$tabla_master}s.id" , "=" , "{$tabla}.{$tabla_master}_id")
            ->whereRaw("DATE_FORMAT({$tabla}.created_at, '%Y-%m-%d')= DATE_FORMAT({$fecha_enviar}, '%Y-%m-%d')")
            ->where("{$tabla_master}s.tienda_id", '=' , Auth::user()->tienda_id)
            ->groupBy('metodo_pago.id')->get();

            return $this->llenar_arreglo($Query);
        }

     // funcion cuando la tabla no tiene el campo tienda id y  el nombre de la tabla que tiene el campo esta en singular
        function __query( $tabla ,$tabla_master, $campo , $fecha ) 
        {
            $fecha_enviar = "'{$fecha}'";

            if ($fecha == 'current_date') 
                $fecha_enviar = 'current_date';

            $Query = DB::table('metodo_pago')
            ->select(DB::raw("metodo_pago.descripcion as descripcion, sum({$campo}) as total"))
            ->join($tabla,"{$tabla}.metodo_pago_id" , "=" , "metodo_pago.id")
            ->join("{$tabla_master}","{$tabla_master}.id" , "=" , "{$tabla}.{$tabla_master}_id")
            ->whereRaw("DATE_FORMAT({$tabla}.created_at, '%Y-%m-%d')= DATE_FORMAT({$fecha_enviar}, '%Y-%m-%d')")
            ->where("{$tabla_master}.tienda_id", '=' , Auth::user()->tienda_id)
            ->groupBy('metodo_pago.id')->get();

            return $this->llenar_arreglo($Query);
        }
    /*********************************************************************************************************************************    
        Fin de Funciones para generar la consulta agrupandolos por el metodo de pago
    **********************************************************************************************************************************/

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

        public function CierresDelMes()
        {
         return View::make('cierre.CierresDelMes');
     }

     public function CierresDelMes_dt()
     {
         $table = 'cierre_diario';

         $columns = array(
            "tiendas.nombre as tienda_nombre",
            "CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
            "nota",
            "cierre_diario.created_at as fecha"
            );

         $Searchable = array("users.nombre","users.apellido","cierre_diario.created_at","nota");

         $Join = "
         JOIN users ON (users.id = cierre_diario.user_id)
         JOIN tiendas ON (tiendas.id = cierre_diario.tienda_id)";

         $where = " DATE_FORMAT(cierre_diario.created_at, '%Y-%m')  = DATE_FORMAT(current_date, '%Y-%m')";
         $where .= ' AND cierre_diario.tienda_id = '.Auth::user()->tienda_id;

         echo TableSearch::get($table, $columns, $Searchable, $Join, $where ); 
     }

     public function VerDetalleDelCierreDelDia()
     {
        $cierre = Cierre::find(Input::get('cierre_id'));

        return Response::json(array(
            'success' => true,
            'table'   => View::make('cierre.DT_detalle_cierre', compact('cierre'))->render()
            ));
    }

    public function ImprimirCierreDelDia_dt($cod , $id)
    {
        $cierre = Cierre::with('user')->find($id);
        return View::make('cierre.ImprimirCierreDelDia_dt', compact('cierre'));
    }
}

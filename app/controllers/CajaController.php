<?php

class CajaController extends \BaseController
{ 
	//funcion para crear cajas pero antes de crear verificar si la tienda ya creo las cantidad de cajas disponibles
	public function create()
    {
        if (Input::has('_token'))
        {
            $cantidad_cajas = Caja::whereTiendaId(Auth::user()->tienda_id)->count();
            $tienda = Tienda::find(Auth::user()->tienda_id);

            if ($cantidad_cajas >= $tienda->limite_cajas)
                return "no puede crear mas cajas porque exede la cantidad de cajas pagadas...!";

            $caja = new Caja;

            if (!$caja->_create())
            {
                return $caja->errors();
            }

			$cierre = new CierreCaja;

            $datos = array();
            $datos['fecha_inicial'] = Carbon::now();
            $datos['fecha_final'] = Carbon::now();
            $datos['caja_id'] = $caja->get_id();

            if (!$cierre->create_master($datos))
            {
                return $cierre->errors();
            }

            return 'success';
        }

        return View::make('cajas.create');
    }

	//funcion par asignar caja a un usuario
    public function asignar()
    {
        if (Input::has('_token'))
        {
            if (Input::get('caja_id') <= 0 )
                return 'Seleccione una Caja..!';

            $user = User::find(Auth::user()->id);
            $user->caja_id = Input::get('caja_id');
            $user->save();

            $caja = Caja::find(Input::get('caja_id'));

            return 'success';
        }

        return View::make('cajas.asignar');
    }

	//funcion par asignar caja a un usuario
	public function asignarDt()
	{
		if (Input::has('_token'))
        {
			if (Input::get('user_id') <= 0)
				return 'Seleccione Usuario';

			$caja = Caja::find(Input::get('caja_id'));
			$caja->user_id = Input::get('user_id');
			$caja->save();

			return 'success';
		}

		$caja = Caja::find(Input::get('caja_id'));

		return Response::json(array(
			'success' => true,
			'view' => View::make('cajas.asignarDt',compact('caja'))->render()
		));
	}

	public function desAsignarDt()
	{
		$caja = Caja::find(Input::get('caja_id'));
		$caja->user_id = 0;
		$caja->save();

		return Response::json(array(
			'success' => true,
		));
	}

	//funcion para editar solo el nombre de la caja
	public function edit()
    {
    	if (Input::has('_token'))
        {
	    	$caja = Caja::find(Input::get('id'));

			if ( $caja->_update() )
			{
		        return 'success';
			}

			return $caja->errors();
    	}

    	$caja = Caja::find(Input::get('id'));

    	return View::make('cajas.edit', compact('caja'));
    }

	//funcion para ver los movimientos actuales de la caja
    public function getMovimientosDeCaja()
    {
        $caja = Caja::whereUserId(Auth::user()->id)->first();

        $datos['fecha_inicial'] = CierreCaja::where('caja_id','=', $caja->id)->max('created_at');
        $datos['fecha_final']   = Carbon::now();
        $datos['caja_id'] = $caja->id;

        $data = $this->resumen_movimientos($datos);

        return Response::json(array(
            'success' => true,
            'view' => View::make('cajas.movimientosDeCaja', compact('data','datos'))->render()
        ));
    } 

    public function getEstadoDeCajas() {
        $caja = Caja::whereTiendaId(Auth::user()->tienda_id)->get(array('id', 'nombre', 'user_id'));
        $data = array();

        foreach ($caja as $dt) 
        {
            $data[] = $this->detalleResumenDeActividadDeCajas($dt);
        }

        foreach ($data as $dt) 
        {
            if (floatval($dt['efectivo']) > 0 || floatval($dt['cheque']) > 0 || floatval($dt['tarjeta']) > 0 || floatval($dt['deposito']) > 0) 
            {
                return false;
            }
        }

        return true;
    }

	//funcion para ver los movimientos de caja desde la tabla cortes de caja
    public function getMovimientosDeCajaDt()
    {
        $cierre_caja = CierreCaja::find(Input::get('cierre_caja_id'));

        $datos['fecha_inicial'] = $cierre_caja->fecha_inicial;
        $datos['fecha_final']   = $cierre_caja->fecha_final;
        $datos['caja_id'] = $cierre_caja->caja_id;

        $data = $this->resumen_movimientos($datos);

        return Response::json(array(
            'success' => true,
            'view' => View::make('cajas.detalleMovimientos', compact('data','datos','cierre_caja'))->render()
        ));
    }

	//funcion para obtener un arryay con los datos de las tablas a necesitar
    public function resumen_movimientos($datos)
    {
        $data = [];
        $data['pagos_ventas']             =   $this->Vquery('pagos_ventas', 'venta', 'monto',$datos);
        $data['abonos_ventas']            =   $this->query('abonos_ventas', 'monto', $datos);
        $data['soporte']                  =   $this->__query('detalle_soporte', 'soporte', 'monto',$datos);
        $data['ingresos']                 =   $this->_query('detalle_ingresos', 'ingreso', 'monto',$datos);
        $data['egresos']                  =   $this->_query('detalle_egresos', 'egreso', 'monto',$datos);
        $data['gastos']                   =   $this->_query('detalle_gastos', 'gasto', 'monto', $datos);
        $data['devolucion']               =   $this->__query('devoluciones_pagos', 'devoluciones','monto', $datos);

        return $data;
    }

    // funcion cuando la tabla si tiene el campo tienda id
    public function query( $tabla , $campo , $data )
    {
        $Query = DB::table('metodo_pago')
        ->select(DB::raw("metodo_pago.id as id, sum({$campo}) as total"))
        ->join($tabla,"{$tabla}.metodo_pago_id" , "=" , "metodo_pago.id")
        ->whereRaw("DATE_FORMAT({$tabla}.updated_at, '%Y-%m-%d %H:%i:%s') >  DATE_FORMAT('{$data['fecha_inicial']}', '%Y-%m-%d %H:%i:%s')")
        ->whereRaw("DATE_FORMAT({$tabla}.updated_at, '%Y-%m-%d %H:%i:%s') <= DATE_FORMAT('{$data['fecha_final']}', '%Y-%m-%d %H:%i:%s')")
        ->where("{$tabla}.tienda_id", '=' , Auth::user()->tienda_id)
        ->where("{$tabla}.caja_id", '=' , $data['caja_id'])
        ->groupBy('metodo_pago.id')->get();

        return $this->llenar_arreglo($Query);
    }

	// funcion cuando la tabla no tiene el campo tienda id y  el nombre de la tabla que tiene el campo esta en plural exclusivo para ventas
    public function Vquery( $tabla ,$tabla_master, $campo , $data )
    {
        $Query = DB::table('metodo_pago')
        ->select(DB::raw("metodo_pago.id as id, sum({$campo}) as total"))
        ->join($tabla,"{$tabla}.metodo_pago_id" , "=" , "metodo_pago.id")
        ->join("{$tabla_master}s","{$tabla_master}s.id" , "=" , "{$tabla}.{$tabla_master}_id")
        ->whereRaw("DATE_FORMAT({$tabla_master}s.updated_at, '%Y-%m-%d %H:%i:%s') >  DATE_FORMAT('{$data['fecha_inicial']}', '%Y-%m-%d %H:%i:%s')")
        ->whereRaw("DATE_FORMAT({$tabla_master}s.updated_at, '%Y-%m-%d %H:%i:%s') <= DATE_FORMAT('{$data['fecha_final']}', '%Y-%m-%d %H:%i:%s')")
		->where("{$tabla_master}s.tienda_id", '=' , Auth::user()->tienda_id)
		->where("{$tabla_master}s.caja_id", '=' , $data['caja_id'])
		->where("{$tabla_master}s.abono", '=' , 0)
        ->where("{$tabla_master}s.canceled", '=' , 0)
        ->groupBy('metodo_pago.id')->get();

        return $this->llenar_arreglo($Query);
    }

    // funcion cuando la tabla no tiene el campo tienda id y  el nombre de la tabla que tiene el campo esta en plural
    public function _query( $tabla ,$tabla_master, $campo , $data )
    {
        $Query = DB::table('metodo_pago')
        ->select(DB::raw("metodo_pago.id as id, sum({$campo}) as total"))
        ->join($tabla,"{$tabla}.metodo_pago_id" , "=" , "metodo_pago.id")
        ->join("{$tabla_master}s","{$tabla_master}s.id" , "=" , "{$tabla}.{$tabla_master}_id")
        ->whereRaw("DATE_FORMAT({$tabla_master}s.updated_at, '%Y-%m-%d %H:%i:%s') >  DATE_FORMAT('{$data['fecha_inicial']}', '%Y-%m-%d %H:%i:%s')")
        ->whereRaw("DATE_FORMAT({$tabla_master}s.updated_at, '%Y-%m-%d %H:%i:%s') <= DATE_FORMAT('{$data['fecha_final']}', '%Y-%m-%d %H:%i:%s')")
		->where("{$tabla_master}s.tienda_id", '=' , Auth::user()->tienda_id)
        ->where("{$tabla_master}s.caja_id", '=' , $data['caja_id'])
        ->groupBy('metodo_pago.id')->get();

        return $this->llenar_arreglo($Query);
    }

    // funcion cuando la tabla no tiene el campo tienda id y  el nombre de la tabla que tiene el campo esta en singular
    public function __query( $tabla ,$tabla_master, $campo , $data )
    {
        $tabla_master_id = $tabla_master;

        if ($tabla_master == 'devoluciones') 
            $tabla_master_id = substr($tabla_master, 0, -2);
        

        $Query = DB::table('metodo_pago')
        ->select(DB::raw("metodo_pago.id as id, sum({$campo}) as total"))
        ->join($tabla,"{$tabla}.metodo_pago_id" , "=" , "metodo_pago.id")
        ->join("{$tabla_master}","{$tabla_master}.id" , "=" , "{$tabla}.{$tabla_master_id}_id")
        ->whereRaw("DATE_FORMAT({$tabla_master}.updated_at, '%Y-%m-%d %H:%i:%s') >  DATE_FORMAT('{$data['fecha_inicial']}', '%Y-%m-%d %H:%i:%s')")
        ->whereRaw("DATE_FORMAT({$tabla_master}.updated_at, '%Y-%m-%d %H:%i:%s') <= DATE_FORMAT('{$data['fecha_final']}', '%Y-%m-%d %H:%i:%s')")
        ->where("{$tabla_master}.tienda_id", '=' , Auth::user()->tienda_id)
        ->where("{$tabla_master}.caja_id", '=' , $data['caja_id'])
        ->groupBy('metodo_pago.id')->get();

        return $this->llenar_arreglo($Query);
    }

    public function llenar_arreglo($Query)
    {
        $arreglo_ordenado = array(
            'efectivo'    =>"0.00",
            'credito'     =>"0.00",
            'cheque'      =>"0.00",
            'tarjeta'     =>"0.00",
            'deposito'    =>"0.00",
			'notaCredito' =>"0.00",
            'total'       =>"0.00"
        );
 
        foreach ($Query as $key => $val)
        {
            if($val->id == 1)
                $arreglo_ordenado['efectivo'] = $val->total;

            if($val->id == 2)
                $arreglo_ordenado['credito'] = $val->total;

            if($val->id == 3)
                $arreglo_ordenado['cheque'] = $val->total;

            if($val->id == 4)
                $arreglo_ordenado['tarjeta'] = $val->total;

            if($val->id == 5)
                $arreglo_ordenado['deposito'] = $val->total;
				
			if($val->id == 6)
                $arreglo_ordenado['notaCredito'] = $val->total;

            if($val->id != 7)
                $arreglo_ordenado['total'] = $arreglo_ordenado['total'] + $val->total;
        }

        return $arreglo_ordenado;
    }

    public function corteDeCaja()
    {
        if ( Input::has('_token') )
        {
            $cierre = new CierreCaja;
            $caja = Caja::whereUserId(Auth::user()->id)->first();

            $datos = Input::all();
            $datos['fecha_inicial'] = CierreCaja::where('caja_id','=', $caja->id)->max('created_at');
            $datos['fecha_final'] = Carbon::now();
            $datos['caja_id'] = $caja->id;

            if (!$cierre->create_master($datos))
            {
                return $cierre->errors();
            }

            return Response::json(array(
                'success' => true ,
                'id' => $cierre->get_id()
            ));
        }

        $caja = Caja::whereUserId(Auth::user()->id)->first();

        $datos['fecha_inicial'] = CierreCaja::where('caja_id','=',$caja->id)->max('created_at');
        $datos['fecha_final']   = Carbon::now();
        $datos['caja_id']   = $caja->id;

        $data = $this->resumen_movimientos($datos);

        $efectivo = $data['soporte']['efectivo'] + $data['pagos_ventas']['efectivo'] + $data['abonos_ventas']['efectivo'] + $data['ingresos']['efectivo']
		 - $data['gastos']['efectivo'] - $data['egresos']['efectivo'] - $data['devolucion']['efectivo'];

        $cheque = $data['pagos_ventas']['cheque'] + $data['abonos_ventas']['cheque'] + $data['soporte']['cheque'] + $data['ingresos']['cheque'];

        $tarjeta = $data['pagos_ventas']['tarjeta'] + $data['abonos_ventas']['tarjeta'] + $data['soporte']['tarjeta'] + $data['ingresos']['tarjeta'];

        $deposito = $data['pagos_ventas']['deposito'] + $data['abonos_ventas']['deposito'] + $data['soporte']['deposito'] + $data['ingresos']['deposito'];

        $movimientos = array(
            'efectivo' => $efectivo,
            'cheque'   => $cheque,
            'tarjeta'  => $tarjeta,
            'deposito' => $deposito
        );

        $movimientos = json_encode($movimientos);

        return Response::json(array(
            'success' => true,
            'form' => View::make('cajas.corteDeCaja', compact('movimientos'))->render()
        ));
    }

    public function cortesDeCajaPorDia()
    {
		$fecha_inicial = Carbon::now()->startOfDay();
		$fecha_final  = Carbon::now()->endOfDay();

		if (Input::has('fecha')) {
			$fecha_inicial = Carbon::createFromFormat('Y-m-d',Input::get('fecha'))->startOfDay();
		    $fecha_final  = Carbon::createFromFormat('Y-m-d',Input::get('fecha'))->endOfDay();
		}

		return Response::json(array(
			'success' => true,
			'view' => View::make('cajas.cortesDeCajasPorDia', compact('fecha_inicial', 'fecha_final'))->render()
		));
    }

    public function DtCortesDeCajasPorDia()
    {
		$fecha_inicial = "'".Input::get('fecha_inicial')."'";
		$fecha_final  ="'".Input::get('fecha_final')."'";

        $table = 'cierre_caja';

        $columns = array(
            "cajas.nombre as caja_nombre",
            "CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
            "nota",
            "cierre_caja.fecha_inicial as fecha_inicial",
            "cierre_caja.fecha_final as fecha_final"
        );

        $Searchable = array("users.nombre", "users.apellido", "cierre_caja.created_at", "nota");

        $Join  = "JOIN users ON (users.id = cierre_caja.user_id)";
        $Join .= "JOIN cajas ON (cajas.id = cierre_caja.caja_id)";

		$where  = " DATE_FORMAT(cierre_caja.fecha_final, '%Y-%m-%d')  >= DATE_FORMAT({$fecha_inicial}, '%Y-%m-%d')";
        $where .= " AND DATE_FORMAT(cierre_caja.fecha_final, '%Y-%m-%d')  <= DATE_FORMAT({$fecha_final}, '%Y-%m-%d')";
        $where .= " AND cierre_caja.tienda_id = ".Auth::user()->tienda_id;

        echo TableSearch::get($table, $columns, $Searchable, $Join, $where );
    }

	public function getConsultarCajas()
	{
		return View::make('cajas.consultarCajas');
	}

	public function DtConsultarCajas()
	{
		$table = 'cajas';

		$columns = array(
			"tiendas.nombre as tienda",
			"cajas.nombre as caja",
			"(select CONCAT_WS(' ',nombre,apellido) from users where id = cajas.user_id) as usuario",
			"cajas.updated_at as fecha"
		);

		$Search_columns = array("cajas.nombre", "tiendas.nombre");
		$Join = "JOIN tiendas ON (tiendas.id = cajas.tienda_id)";
		$where = "cajas.tienda_id =".Auth::user()->tienda_id;

		echo TableSearch::get($table, $columns, $Search_columns, $Join, $where );
	}

	public function retirarDineroDeCajaPdf()
	{
		$datos = [];
		$caja = Caja::whereUserId(Auth::user()->id)->first();

		$datos['fecha_inicial'] = CierreCaja::where('caja_id','=', $caja->id)->max('created_at');
		$datos['fecha_final']   = Carbon::now();
		$datos['caja_id']       = $caja->id;

		$data = $this->resumen_movimientos($datos);

		$efectivo = $data['soporte']['efectivo'] + $data['pagos_ventas']['efectivo'] + $data['abonos_ventas']['efectivo'] + $data['ingresos']['efectivo'] - $data['gastos']['efectivo'] - $data['egresos']['efectivo'];

		$monto = Input::get('monto');

		$pdf = PDF::loadView('cajas.retirarDineroDeCajaPdf',compact('caja', 'efectivo', 'monto'));

		return $pdf->stream('DineroCaja');
	}

	public function retirarEfectivoDeCaja()
	{
		return Response::json(array(
			'success' => true,
			'view' => View::make('cajas.retirarEfectivoDeCaja')->render()
		));
	}

	public function imprimirCorteCaja($id)
	{
		$cierre_caja = CierreCaja::find($id);

        $datos['fecha_inicial'] = $cierre_caja->fecha_inicial;
        $datos['fecha_final']   = $cierre_caja->fecha_final;
        $datos['caja_id'] = $cierre_caja->caja_id;

        $data = $this->resumen_movimientos($datos);

	    $pdf = PDF::loadView('cajas.detalleMovimientos', compact('data', 'datos', 'cierre_caja')); 
        //$pdf->download("corete_caja_{$cierre_caja->fecha_inicial}__{$cierre_caja->fecha_final}_CajaId_{$cierre_caja->caja_id}.pdf");
	    
        return $pdf->stream('Caja');
	}

	public function resumenDeActividadActualDeCajas()
	{
		$caja = Caja::whereTiendaId(Auth::user()->tienda_id)->get(array('id', 'nombre', 'user_id'));
		$data = array();

		foreach ($caja as $dt) {
			$data[] = $this->detalleResumenDeActividadDeCajas($dt);
		}

        return Response::json(array(
            'success' => true,
            'view' => View::make('cajas.resumenDeActividadActualDeCajas', compact('data'))->render()
        ));
	}

	public function detalleResumenDeActividadDeCajas($caja)
	{
		$datos['fecha_inicial'] = CierreCaja::where('caja_id','=',$caja->id)->max('created_at');
        $datos['fecha_final']   = Carbon::now();
        $datos['caja_id']       = $caja->id;

        $data = $this->resumen_movimientos($datos);

        $efectivo = $data['soporte']['efectivo'] + $data['pagos_ventas']['efectivo'] + $data['abonos_ventas']['efectivo'] + $data['ingresos']['efectivo']
		- $data['gastos']['efectivo'] - $data['egresos']['efectivo'];

        $cheque = $data['pagos_ventas']['cheque'] + $data['abonos_ventas']['cheque'] + $data['soporte']['cheque'] + $data['ingresos']['cheque'];

        $tarjeta = $data['pagos_ventas']['tarjeta'] + $data['abonos_ventas']['tarjeta'] + $data['soporte']['tarjeta'] + $data['ingresos']['tarjeta'];

        $deposito = $data['pagos_ventas']['deposito'] + $data['abonos_ventas']['deposito'] + $data['soporte']['deposito'] + $data['ingresos']['deposito'];

		$user = User::find($caja->user_id);

        $movimientos = array(
			'caja'     => $caja->nombre,
			'usuario'  => @$user->nombre.' '.@$user->apellido,
            'efectivo' => $efectivo,
            'cheque'   => $cheque,
            'tarjeta'  => $tarjeta,
            'deposito' => $deposito
        );

		return $movimientos;
	}
}

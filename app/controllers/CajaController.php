<?php

class CajaController extends \BaseController 
{

	public function create()
    {
        if (Input::has('_token'))
        {
            $cantidad_cajas = Caja::count();
            $tienda = Tienda::find(Auth::user()->tienda_id);

            if ($cantidad_cajas >= $tienda->limite_cajas) 
                return "no puede crear mas cajas porque exede la cantidad de cajas pagadas...!";

            $caja = new Caja;

            if (!$caja->_create())
            {
                return $caja->errors(); 
            }

            return 'success';
        }

        return View::make('cajas.create');
    }

    public function asignar()
    {
        if (Input::has('_token'))
        {
            $user = User::find(Auth::user()->id);
            $user->caja_id = Input::get('caja_id');
            $user->save();

            $caja = Caja::find(Input::get('caja_id'));

            return 'success';
        }

        return View::make('cajas.asignar');
    }

    public function getMovimientosDeCaja()
    {

        $fecha['inicial'] = CierreCaja::max('created_at');
        $fecha['final']   = Carbon::now();

        $data = $this->resumen_movimientos($fecha);

        return Response::json(array(
            'success' => true,
            'view' => View::make('cajas.movimientosDeCaja',compact('data'))->render()
        ));
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
			"cajas.created_at as fecha"
			);

		$Search_columns = array("cajas.nombre","tiendas.nombre");
		$Join = "JOIN tiendas ON (tiendas.id = cajas.tienda_id)";
		$where = "cajas.tienda_id =".Auth::user()->tienda_id;

		echo TableSearch::get($table, $columns, $Search_columns, $Join, $where );
	}

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

        return $data;
    }

    // funcion cuando la tabla si tiene el campo tienda id
    function query( $tabla , $campo , $fecha ) 
    {
        $Query = DB::table('metodo_pago')
        ->select(DB::raw("metodo_pago.descripcion as descripcion, sum({$campo}) as total"))
        ->join($tabla,"{$tabla}.metodo_pago_id" , "=" , "metodo_pago.id")
        ->whereRaw("DATE_FORMAT({$tabla}.created_at, '%Y-%m-%d %H:%i:%s') >  DATE_FORMAT('{$fecha['inicial']}', '%Y-%m-%d %H:%i:%s')")
        ->whereRaw("DATE_FORMAT({$tabla}.created_at, '%Y-%m-%d %H:%i:%s') <= DATE_FORMAT('{$fecha['final']}', '%Y-%m-%d %H:%i:%s')")
        ->where("{$tabla}.tienda_id", '=' , Auth::user()->tienda_id)
        ->where("{$tabla}.caja_id", '=' , Auth::user()->caja_id)
        ->groupBy('metodo_pago.id')->get();

        return $this->llenar_arreglo($Query);
    }

    // funcion cuando la tabla no tiene el campo tienda id y  el nombre de la tabla que tiene el campo esta en plural
    function _query( $tabla ,$tabla_master, $campo , $fecha ) 
    {
        $Query = DB::table('metodo_pago')
        ->select(DB::raw("metodo_pago.descripcion as descripcion, sum({$campo}) as total"))
        ->join($tabla,"{$tabla}.metodo_pago_id" , "=" , "metodo_pago.id")
        ->join("{$tabla_master}s","{$tabla_master}s.id" , "=" , "{$tabla}.{$tabla_master}_id")
        ->whereRaw("DATE_FORMAT({$tabla_master}s.created_at, '%Y-%m-%d %H:%i:%s') >  DATE_FORMAT('{$fecha['inicial']}', '%Y-%m-%d %H:%i:%s')")
        ->whereRaw("DATE_FORMAT({$tabla_master}s.created_at, '%Y-%m-%d %H:%i:%s') <= DATE_FORMAT('{$fecha['final']}', '%Y-%m-%d %H:%i:%s')")            ->where("{$tabla_master}s.tienda_id", '=' , Auth::user()->tienda_id)
        ->where("{$tabla_master}s.caja_id", '=' , Auth::user()->caja_id)
        ->groupBy('metodo_pago.id')->get();

        return $this->llenar_arreglo($Query);
    }

    // funcion cuando la tabla no tiene el campo tienda id y  el nombre de la tabla que tiene el campo esta en singular
    function __query( $tabla ,$tabla_master, $campo , $fecha ) 
    {
        $Query = DB::table('metodo_pago')
        ->select(DB::raw("metodo_pago.descripcion as descripcion, sum({$campo}) as total"))
        ->join($tabla,"{$tabla}.metodo_pago_id" , "=" , "metodo_pago.id")
        ->join("{$tabla_master}","{$tabla_master}.id" , "=" , "{$tabla}.{$tabla_master}_id")
        ->whereRaw("DATE_FORMAT({$tabla_master}.created_at, '%Y-%m-%d %H:%i:%s') >  DATE_FORMAT('{$fecha['inicial']}', '%Y-%m-%d %H:%i:%s')")
        ->whereRaw("DATE_FORMAT({$tabla_master}.created_at, '%Y-%m-%d %H:%i:%s') <= DATE_FORMAT('{$fecha['final']}', '%Y-%m-%d %H:%i:%s')")
        ->where("{$tabla_master}.tienda_id", '=' , Auth::user()->tienda_id)
        ->where("{$tabla_master}.caja_id", '=' , Auth::user()->caja_id)
        ->groupBy('metodo_pago.id')->get();

        return $this->llenar_arreglo($Query);
    }

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
}
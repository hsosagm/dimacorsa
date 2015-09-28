<?php

class CotizacionController extends \BaseController {

	public function create()
	{
		if (Input::has('_token'))
		{
			$cotizacion = new Cotizacion;

			$data = Input::all();

			if (!$cotizacion->create_master($data))
			{
				return $cotizacion->errors();
			}

			$cotizacion_id = $cotizacion->get_id();

			return Response::json(array(
				'success' => true,
				'detalle' => View::make('cotizaciones.detalle', compact('cotizacion_id'))->render()
            ));
		}

		return View::make('cotizaciones.create');
	}

	public function detalle()
	{
		if (Input::has('_token'))
		{
			Input::merge(array('precio' => str_replace(',', '', Input::get('precio'))));

            if (Auth::user()->hasRole("Admin"))
            {
            	$producto = Producto::find(Input::get('producto_id'));

            	if ((@$producto->p_publico * 0.90) > Input::get('precio')) {
            		return 'no puede hacer mas descuento que el autorizado';
            	}
            } 

            else if (Auth::user()->hasRole("User"))
            {
            	$producto = Producto::find(Input::get('producto_id'));

            	if ((@$producto->p_publico * 0.95) > Input::get('precio')) {
            		return 'no puede hacer mas descuento que el autorizado';
            	}
            } 


			if ($this->verificarSiExisteEnlaCotizacionElProducto() == true) {
				return "El codigo ya ha sido ingresado..";
			}

			$nueva_existencia = $this->check_inventory();
			if ($nueva_existencia === false) {
				return "La cantidad que esta ingresando es mayor a la existencia..";
			}

			$query = new DetalleCotizacion;

			if ( !$query->_create())
			{
				return $query->errors();
			}

			$detalle = $this->getCotizacionDetalle();

			$detalle = json_encode($detalle);

			return Response::json(array(
				'success' => true,
				'table'   => View::make('cotizaciones.detalle_body', compact('detalle'))->render()
	        ));
		}

		return 'Token invalido';
	}


	public function verificarSiExisteEnlaCotizacionElProducto()
    {
		$query = DB::table('detalle_ventas')->select('id')
	    ->where('venta_id', Input::get("cotizacion_id"))
	    ->where('producto_id', Input::get("producto_id"))
	    ->first();

	    if($query == null)
	    {
	        return false;
	    }

	    return true;
    }


    public function check_inventory( $producto_id = null, $cantidad = null )
    {
    	if ($producto_id === null) {
    		$producto_id = Input::get('producto_id');
    	}

    	if ($cantidad === null) {
    		$cantidad = Input::get('cantidad');
    	}

	    $query = Existencia::where('producto_id', $producto_id )->where('tienda_id', Auth::user()->tienda_id)->first();

	    if ( $query == null || $query->existencia < $cantidad ) {
	    	return false;
	    }

	    $nueva_existencia = $query->existencia - $cantidad;

	    return $nueva_existencia;
    }


    public function getCotizacionDetalle()
	{
		$detalle = DB::table('detalle_cotizaciones')
        ->select(array(
        	'detalle_cotizaciones.id',
        	'cotizacion_id', 'producto_id',
        	'cantidad', 
        	'precio', 
        	DB::raw('CONCAT(productos.descripcion, " ", marcas.nombre) AS descripcion, cantidad * precio AS total') ))
        ->where('cotizacion_id', Input::get('cotizacion_id'))
        ->join('productos', 'detalle_cotizaciones.producto_id', '=', 'productos.id')
        ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
        ->get();

        return $detalle;
	}

	public function removeItemCotizacion()
	{
		$dv = DetalleCotizacion::find(Input::get('id'));

		$delete = DetalleCotizacion::destroy(Input::get('id'));

		if ($delete)
		{
			return Response::json(array(
				'success' => true
            ));
		}

		return 'Huvo un error al tratar de eliminar';	
	}

	public function updateClienteId()
	{
		$venta = Cotizacion::find(Input::get('cotizacion_id'));
		$venta->cliente_id = Input::get('cliente_id');
		$venta->save();

		if (!$venta)
			return false;

		return Response::json(array(
			'success' => true
        ));
	}
}

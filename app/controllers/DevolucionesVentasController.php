<?php

class DevolucionesVentasController extends \BaseController {

	public function getVentaConDetalleParaDevolucion()
	{
		if (Input::has('_token'))
		{
			$devolucion = new Devolucion;

			if (!$devolucion->create_master_with_caja())
			{
				return $devolucion->errors();
			}

			$devolucion_id = $devolucion->get_id();

			return Response::json(array(
				'success' => true,
				'detalle' => View::make('ventas.devoluciones.detalle', compact('devolucion_id'))->render()
            ));
		}

		$venta = Venta::with('cliente')->find(Input::get('venta_id'));

		return Response::json(array(
            'success' => true,
            'table' => View::make('ventas.devoluciones.create', compact('venta'))->render()
        ));

	}

    public function findProducto()
    {
        $codigo = trim(Input::get('codigo'));
        $codigo = preg_replace('/\s{2,}/', ' ', $codigo);

        if ($codigo == '')
            return 'El campo del codigo se encuentra vacio...!';

        $producto = Producto::whereCodigo($codigo)->first();

        if(!count($producto))
            return 'el codigo que buscas no existe..!';

        $dv = DetalleVenta::whereVentaId(Input::get('venta_id'))
        ->whereProductoId($producto->id)
        ->first();

        if(!count($dv))
            return 'el codigo que buscas no existe en esta venta..!';

        return array(
            'success' => true,
            'values' => array(
					        'id' => $dv->producto_id,
					        'descripcion' => $producto->descripcion,
					        'cantidad'    => $dv->cantidad,
					        'precio'      => $dv->precio
            	        )
        );
    }

    public function postDevolucionDetalle()
    {
		if ($this->check_if_code_exists_in_this_devolucion())
			return "El codigo ya ha sido ingresado..";

		if ($this->check_cantidad_vendida())
			return "La cantidad que esta ingresando es mayor a la cantidad vendida..";

		$data = Input::except('venta_id');

		$dd = new DevolucionDetalle;
		if (!$dd->_create($data))
		{
			return $dd->errors();
		}

		return Response::json(array(
			'success' => true,
			'detalle' => $this->getDevolucionesDetalle()
        ));
    }

    public function check_if_code_exists_in_this_devolucion()
    {
		$query = DB::table('devoluciones_detalle')->select('id')
	    ->where('devolucion_id', Input::get("devolucion_id"))
	    ->where('producto_id', Input::get("producto_id"))
	    ->first();

	    if($query == null)
	    {
	        return false;
	    }

	    return true;
    }

	public function getDevolucionesDetalle()
	{
		$detalle = DB::table('devoluciones_detalle')
        ->select(array(
        	'devoluciones_detalle.id',
        	'devolucion_id', 
        	'producto_id',
        	'cantidad',
        	'precio',
        	'serials',
        	DB::raw('CONCAT(productos.descripcion, " ", marcas.nombre) AS descripcion, cantidad * precio AS total') ))
        ->where('devolucion_id', Input::get('devolucion_id'))
        ->join('productos', 'devoluciones_detalle.producto_id', '=', 'productos.id')
        ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
        ->get();

        return $detalle;
	}

	public function removeItem()
	{
		$delete = DevolucionDetalle::destroy(Input::get('id'));

		if ($delete) {
			return Response::json(array(
				'success' => true
            ));
		}

		return 'Huvo un error al tratar de eliminar';
	}

    public function check_cantidad_vendida()
    {
	    $query = DetalleVenta::whereVentaId(Input::get('venta_id'))->whereProductoId(Input::get('producto_id'))->first();

	    if ( $query == null || $query->cantidad < Input::get('cantidad') ) {
	    	return true;
	    }

	    return false;
    }

	public function finalizarDevolucion()
	{
            $Existencia = Existencia::where('producto_id', $dv->producto_id)
            ->where('tienda_id', Auth::user()->tienda_id)->first();

            $Existencia->existencia = $Existencia->existencia + $dv->cantidad;
            $Existencia->save();
	}

	public function eliminarDevolucion()
	{
		$delete = Devolucion::destroy(Input::get('devolucion_id'));

		if ($delete) {
			return Response::json(array(
				'success' => true
            ));
		}

		return 'Huvo un error al tratar de eliminar';
	}

}

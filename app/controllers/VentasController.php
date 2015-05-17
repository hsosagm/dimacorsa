<?php

class VentasController extends \BaseController {

	public function create()
	{
		if (Input::has('_token'))
		{
			$venta = new Venta;

			if (!$venta->create_master())
			{
				return $venta->errors();
			}

			$id = $venta->get_id();

			return Response::json(array(
				'success' => true,
				'detalle' => View::make('ventas.detalle', compact('id'))->render()
            ));
		}

		return View::make('ventas.create');
	}


	public function detalle()
	{
		if (Session::token() == Input::get('_token'))
		{
			if ($this->sheck_if_exist() == false) {
				return "El codigo ya ha sido ingresado..";
			}

			$nueva_existencia = $this->sheck_existencia();

			if ($nueva_existencia == false) {
				return "La cantidad que esta ingresando es mayor a la existencia..";
			}

			$query = new DetalleVenta;

			if ( !$query->SaleItem())
			{
				return $query->errors();
			}

			Existencia::where('producto_id', Input::get('producto_id'))
			->where('tienda_id', Auth::user()->tienda_id)
			->update(array('existencia' => $nueva_existencia));

			return $this->table_detail();
		}

		return 'Token invalido';
	}


	public function RemoveSale()
	{
		$delete = Venta::destroy(Input::get('id'));

		if ($delete)
		{
			return Response::json(array(
				'success' => true
            ));
		}

		return 'Huvo un error al tratar de eliminar';
	}


	public function RemoveSaleItem()
	{
		$delete = DetalleVenta::destroy(Input::get('id'));

		if ($delete)
		{
			return Response::json(array(
				'success' => true
            ));
		}

		return 'Huvo un error al tratar de eliminar';	
	}


	public function table_detail()
    {
    	$detalle = DB::table('detalle_ventas')
        ->select(array('detalle_ventas.id', 'venta_id', 'producto_id', 'cantidad', 'precio', DB::raw('CONCAT(productos.descripcion, " ", marcas.nombre) AS descripcion, cantidad * precio AS total') ))
        ->where('venta_id', Input::get('venta_id'))
        ->join('productos', 'detalle_ventas.producto_id', '=', 'productos.id')
        ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
        ->get();

		$deuda = 0;

		return Response::json(array(
			'success' => true,
			'table'   => View::make('ventas.detalle_body', compact('detalle', 'deuda'))->render()
        ));
    }


    public function sheck_if_exist()
    {
		$query = DB::table('detalle_ventas')->select('id')
	    ->where('venta_id', Input::get("venta_id"))
	    ->where('producto_id', Input::get("producto_id"))
	    ->first();

	    if(!$query == null)
	    {
	        return false;
	    }

	    return true;
    }


    public function sheck_existencia()
    {
	    $existencia = Existencia::where('producto_id', Input::get('producto_id'))->where('tienda_id', Auth::user()->tienda_id)->first();

	    if ($existencia->existencia < Input::get('cantidad')) {
	    	return false;
	    }

	    $nueva_existencia = $existencia->existencia - Input::get('cantidad');

	    return $nueva_existencia;
    }

}

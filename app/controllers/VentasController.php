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
			$query = new DetalleVenta;

			if (!$query->_create())
			{
				return $query->errors();
			}

			$detalle = $this->table_detail();

			$deuda = 0;

			return Response::json(array(
				'success' => true,
				'table'   => View::make('ventas.detalle_body', compact('detalle', 'deuda'))->render()
            ));
		}

		return 'Token invalido';
	}


	public function delete_master()
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


	public function table_detail()
    {
    	$query = DB::table('detalle_ventas')
        ->select(array('venta_id', 'producto_id', 'cantidad', 'precio', DB::raw('CONCAT(productos.descripcion, " ", marcas.nombre) AS descripcion, cantidad * precio AS total') ))
        ->where('venta_id', Input::get('venta_id'))
        ->join('productos', 'detalle_ventas.producto_id', '=', 'productos.id')
        ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
        ->get();

        return $query;
    }

}

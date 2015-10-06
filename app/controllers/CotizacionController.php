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

			$query = new DetalleCotizacion;

			$data = Input::all();

			if (Input::get('producto_id') > 0)
			{
				$producto = Producto::find(Input::get('producto_id'));
				$data['descripcion'] = $producto->descripcion;
			}
			else
			{
				$data['producto_id'] = 0;
			}

			if ( !$query->_create($data))
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

    public function getCotizacionDetalle()
	{
		$detalle = DB::table('detalle_cotizaciones')
        ->select(array(
        	'detalle_cotizaciones.id',
        	'cotizacion_id', 'producto_id',
        	'cantidad',
        	'precio',
        	DB::raw('detalle_cotizaciones.descripcion AS descripcion,
			cantidad * precio AS total')))
        ->where('cotizacion_id', Input::get('cotizacion_id'))
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

	public function ingresarProductoRapido()
	{
		if (Input::has('_token'))
		{
			Input::merge(array('precio' => str_replace(',', '', Input::get('precio'))));
			Input::merge(array('producto_id' => 0));

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

		return Response::json(array(
			'success' => true,
			'view'   => View::make('cotizaciones.ingresarProductoRapido')->render()
		));
	}

	public function EliminarCotizacion()
	{
		$cotizacion = Cotizacion::find(Input::get('cotizacion_id'));
		if($cotizacion->delete()){
			return Response::json(array(
				'success' => true
	        ));
		}

		return 'error al tratar e eliminar';
	}

	public function ImprimirCotizacion($op, $id)
	{
		$cotizacion = Cotizacion::with('cliente', 'detalle_cotizacion')->find($id);
		$tienda = Tienda::find(Auth::user()->tienda_id);

		if (trim($op) == 'pdf') {
			$pdf = PDF::loadView('cotizaciones.exportPdf',  array('cotizacion' => $cotizacion, 'tienda' => $tienda));
			return $pdf->stream('cotizacion-'.$id);
		}

		$emails = array($cotizacion->cliente->email);


		if (!filter_var($cotizacion->cliente->email, FILTER_VALIDATE_EMAIL))
			return 'el cliente ingresado no tiene Correo Electronico Valido...!';

		Mail::queue('emails.mensaje', array('asunto' => 'Cotizacion'), function($message) use($emails, $cotizacion, $tienda)
		{
			$pdf = PDF::loadView('cotizaciones.exportPdf',  array('cotizacion' => $cotizacion, 'tienda' => $tienda));
			$message->to($emails)->subject('Cotizacion');
			$message->attachData($pdf->output(), Carbon::now()."-Cotizacion.pdf");
		});

		return Response::json(array(
			'success' => true,
			'mensaje' => 'Correo Enviado a '.$cotizacion->cliente->email
		));

	}
}

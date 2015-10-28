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

		return Response::json(array(
			'success' => true,
			'view' => View::make('cotizaciones.create')->render()
		));
	}

	public function EditarCotizacion()
	{
		$cotizacion = Cotizacion::with('cliente', 'detalle_cotizacion')->find(Input::get('cotizacion_id'));

		$detalle = $this->getCotizacionDetalle();

		$detalle = json_encode($detalle);

		$cotizacion_id = $cotizacion->id;

		return Response::json(array(
			'success' => true,
			'view' => View::make('cotizaciones.edit', compact('cotizacion', 'detalle', 'cotizacion_id'))->render()
        ));
	}

	public function detalle()
	{
		if (Input::has('_token'))
		{
			Input::merge(array('precio' => str_replace(',', '', Input::get('precio'))));

			$query = new DetalleCotizacion;

			$data = Input::all();

			if (Input::get('producto_id') > 0)
			{
				$producto = Producto::find(Input::get('producto_id'));
				$data['descripcion'] = $producto->descripcion;
			}

			else
				$data['producto_id'] = 0;

			if (!$query->_create($data))
				return $query->errors();

			$detalle = $this->getCotizacionDetalle();
			$detalle = json_encode($detalle);
			$totalCotizacion = DetalleCotizacion::select(DB::raw('sum(precio * cantidad) as total'))->first();

			$cotizacion = Cotizacion::find(Input::get('cotizacion_id'));
			$cotizacion->total = $totalCotizacion->total;
			$cotizacion->save();

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
        	'cotizacion_id',
			'producto_id',
        	'cantidad',
        	'precio',
			'detalle_cotizaciones.descripcion AS descripcion',
        	DB::raw('cantidad * precio AS total')))
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

			if (!$query->_create())
				return $query->errors();

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

		if (trim($op) == 'pdf')
		{
			$pdf = PDF::loadView('cotizaciones.exportPdf',  array('cotizacion' => $cotizacion, 'tienda' => $tienda));
			return $pdf->stream('cotizacion-'.$id);
		}

		$emails = array($cotizacion->cliente->email);

		if (!filter_var($cotizacion->cliente->email, FILTER_VALIDATE_EMAIL))
			return 'El cliente ingresado no tiene correo electronico valido...!';

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

	public function getCotizaciones($value='')
	{
		 return View::make('cotizaciones.getContizaciones')->render();
	}

	public function getMisCotizaciones($value='')
	{
		return View::make('cotizaciones.getMisCotizaciones')->render();
	}

	public function DtCotizaciones()
    {
		$table = 'cotizaciones';

		$columns = array(
			"cotizaciones.created_at as fecha",
			"CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
			"clientes.nombre as cliente",
			"(select sum(precio * cantidad) from detalle_cotizaciones where cotizacion_id = cotizaciones.id) as total",
		);

		$Search_columns = array("users.nombre","users.apellido","clientes.nombre","cotizaciones.total",'cotizaciones.created_at');

		$where = "cotizaciones.tienda_id = ".Auth::user()->tienda_id ;

		$Join = "JOIN users ON (users.id = cotizaciones.user_id) JOIN clientes ON (clientes.id = cotizaciones.cliente_id)";

		return TableSearch::get($table, $columns, $Search_columns, $Join, $where );
    }

	public function DtMisCotizaciones()
    {
		$table = 'cotizaciones';

		$columns = array(
			"cotizaciones.created_at as fecha",
			"CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
			"clientes.nombre as cliente",
			"(select sum(precio * cantidad) from detalle_cotizaciones where cotizacion_id = cotizaciones.id) as total",
		);

		$Search_columns = array("users.nombre","users.apellido","clientes.nombre","cotizaciones.total",'cotizaciones.created_at');

		$where = "cotizaciones.tienda_id = ".Auth::user()->tienda_id ;
		$where .= " AND cotizaciones.user_id = ".Auth::user()->id ;

		$Join = "JOIN users ON (users.id = cotizaciones.user_id) JOIN clientes ON (clientes.id = cotizaciones.cliente_id)";

		return TableSearch::get($table, $columns, $Search_columns, $Join, $where );
    }

	public function getDetalleCotizacion()
	{
		$detalle = DB::table('detalle_cotizaciones')
        ->select(array(
        	'detalle_cotizaciones.id',
        	'cotizacion_id', 'producto_id',
        	'cantidad',
        	'precio',
			'descripcion',
        	DB::raw('cantidad * precio AS total') ))
        ->where('cotizacion_id', Input::get('cotizacion_id'))
        ->get();

		return Response::json(array(
			'success' => true,
			'table'   => View::make('cotizaciones.DT_detalle_cotizacion', compact('detalle'))->render()
        ));
	}

	public function UpdateDetalle()
	{
		if ( Input::get('field') == 'precio' ) {
			$precio = str_replace(',', '', Input::get('values.precio'));
			$precio = preg_replace('/\s{2,}/', ' ', $precio);

			DetalleCotizacion::find( Input::get('values.id') )
			->update(array('precio' => Input::get('values.precio')));

			$detalle = $this->getCotizacionDetalle();
			$detalle = json_encode($detalle);

			return Response::json( array(
				'success' => true,
				'table'   => View::make('cotizaciones.detalle_body', compact('detalle'))->render()
	        ));
		}

		if ( Input::get('field') == 'descripcion' ) {
			$precio = str_replace(',', '', Input::get('values.descripcion'));
			$precio = preg_replace('/\s{2,}/', ' ', $precio);

			DetalleCotizacion::find( Input::get('values.id') )
			->update(array('descripcion' => Input::get('values.descripcion')));

			$detalle = $this->getCotizacionDetalle();
			$detalle = json_encode($detalle);

			return Response::json( array(
				'success' => true,
				'table'   => View::make('cotizaciones.detalle_body', compact('detalle'))->render()
	        ));
		}

		if ( Input::get('values.cantidad') < 1 ) {
			return 'La cantidad deve ser mayor a 0';
		}

		DetalleCotizacion::find( Input::get('values.id') )
		->update(array('cantidad' => Input::get('values.cantidad')));

		$detalle = $this->getCotizacionDetalle();
		$detalle = json_encode($detalle);

		return Response::json( array(
			'success' => true,
			'table'   => View::make('cotizaciones.detalle_body', compact('detalle'))->render()
        ));
	}
}

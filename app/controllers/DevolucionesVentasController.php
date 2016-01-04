<?php

class DevolucionesVentasController extends \BaseController {

	public function getVentasParaDevoluciones()
	{
        return Response::json(array(
            'success'=> true,
            'view' => View::make('ventas.devoluciones.ventasParaDevoluciones')->render()
        ));
	}

	public function DT_ventasParaDevoluciones()
	{
        $table = 'ventas';

		$columns = array(
			"ventas.created_at as fecha",
			"CONCAT_WS(' ',users.nombre, users.apellido) as usuario",
			"clientes.nombre as cliente",
			"total",
			"saldo"
		);

        $Search_columns = array("users.nombre", "users.apellido", "clientes.nombre", "ventas.total", "ventas.created_at");
        $Join = "JOIN users ON (users.id = ventas.user_id) JOIN clientes ON (clientes.id = ventas.cliente_id)";
        $where = "ventas.canceled = 0";
        $where .= " AND ventas.tienda_id = ".Auth::user()->tienda_id;

        echo TableSearch::get($table, $columns, $Search_columns, $Join, $where);
	}

	public function createDevolucion()
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
	    	return false;

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

        foreach ($detalle as $dt) {
        	if ($dt->serials) {
        		$dt->serials = explode(',', $dt->serials);
        	}
        }

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

		return 'Hubo un error al tratar de eliminar';
	}

    public function check_cantidad_vendida()
    {
	    $query = DetalleVenta::whereVentaId(Input::get('venta_id'))->whereProductoId(Input::get('producto_id'))->first();

	    if ($query == null || $query->cantidad < Input::get('cantidad'))
	    	return true;

	    return false;
    }

    public function UpdateDetalle()
    {
		if ($this->check_cantidad_vendida())
			return "La cantidad que esta ingresando es mayor a la cantidad vendida..";

        $update = DevolucionDetalle::find(Input::get('id'))->update(array('cantidad' => Input::get('cantidad')));

        if ($update) {
        	return Response::json(array(
				'success' => true,
				'detalle' => $this->getDevolucionesDetalle()
        	));
        }
    }

    public function getPaymentForm()
    {
    	$dd = DevolucionDetalle::whereDevolucionId(Input::get('devolucion_id'))->get();

    	if (count($dd)) {
	        $venta = Venta::find(Input::get('venta_id'));
	        return  Response::json(array(
	        	'success' => true,
	        	'detalle' => View::make('ventas.devoluciones.paymentForm', compact('venta'))->render()
	        ));
    	}
    }

	public function eliminarDevolucion()
	{
		$delete = Devolucion::destroy(Input::get('devolucion_id'));

		if ($delete) {
			return Response::json(array(
				'success' => true
            ));
		}

		return 'Hubo un error al tratar de eliminar';
	}

	public function finalizarDevolucion()
	{
		$descuento_sobre_saldo = Input::get('descuento_sobre_saldo');
		$monto_a_devolver      = Input::get('monto_a_devolver');
		$devolucion_id         = Input::get('devolucion_id');
		$totalDevolucion       = Input::get('totalDevolucion');
		$detalleTable          = Input::get('detalleTable');

		$devolucion = Devolucion::find($devolucion_id);
		$devolucion->total = $totalDevolucion;
		$devolucion->completed = 1;
		$devolucion->save();

		foreach ($detalleTable as $dt)
		{
			if ($dt['serials'])
			{
				$dv = DetalleVenta::whereVentaId($devolucion->venta_id)->whereProductoId($dt['producto_id'])->first();

				if ($dv->serials)
				{
					DB::table('detalle_ventas')->whereId($dv->id)
					->update(array('serials' => implode(",", array_diff( explode(",", $dv->serials), $dt['serials'] )) ));
				}
			}
		}

		if ($descuento_sobre_saldo > 0) {
			$dp = new DevolucionPago;
			$dp->devolucion_id = $devolucion_id;
			$dp->metodo_pago_id = 7;
			$dp->monto = $descuento_sobre_saldo;
			$dp->save();
		}

		$venta = Venta::find($devolucion->venta_id);

		if ($monto_a_devolver > 0) {
			if (Input::get('devolucion_opcion') == 'pagoCaja') {
				$dp = new DevolucionPago;
				$dp->devolucion_id = $devolucion_id;
				$dp->metodo_pago_id = Input::get('mp_devolucion');
				$dp->monto = $monto_a_devolver;
				$dp->save();
			} else {
				$dp = new DevolucionPago;
				$dp->devolucion_id = $devolucion_id;
				$dp->metodo_pago_id = 6;
				$dp->monto = $monto_a_devolver;
				$dp->save();

				$nc = new NotaCredito;
				$nc->cliente_id = $venta->cliente_id;
				$nc->tienda_id = $venta->tienda_id;
				$nc->user_id = Auth::user()->id;
				$nc->tipo = 'devolucion';
				$nc->tipo_id = $devolucion_id;
				$nc->monto = $monto_a_devolver;
				$nc->save();
			}
		}

		$devolucion_detalle = DevolucionDetalle::whereDevolucionId($devolucion_id)->get();

		foreach ($devolucion_detalle as $key => $dd)
		{
            $Existencia = Existencia::whereProductoId($dd->producto_id)->whereTiendaId($venta->tienda_id)->first();
            $Existencia->existencia = $Existencia->existencia + $dd->cantidad;
            $Existencia->save(); 
		}

        if ($venta->total == $totalDevolucion)
        {
        	DetalleVenta::whereVentaId($devolucion->venta_id)->delete();

        	DB::table('ventas')->whereId($venta->id)
        	->update(array('total' => 0, 'saldo' => 0, 'canceled' => 1));
        }
        else
        {

        	$venta_total = $venta->total - $totalDevolucion;
        	$venta_saldo = 0;

		    if( $totalDevolucion >= $venta->saldo )
		        $venta_saldo = 0;
		    else
		        $venta_saldo = $venta->saldo - $totalDevolucion;

        	DB::table('ventas')->whereId($venta->id)
        	->update(array('total' => $venta_total, 'saldo' => $venta_saldo));

			foreach ($devolucion_detalle as $dd)
			{
	            $dv = DetalleVenta::where('venta_id', $devolucion->venta_id)
	            ->where('producto_id', $dd->producto_id)->first();

                if ($dv->cantidad == $dd->cantidad) {
	            	$dv->delete();
	            }
	            else {
		            DB::table('detalle_ventas')->whereId($dv->id)
        			->update(array('cantidad' => $dv->cantidad - $dd->cantidad));
	            }
			}
        }

		return Response::json(array(
			'success' => true
		));
	}

    public function devoluciones()
    {
		$where = "devoluciones.tienda_id = ".Auth::user()->tienda_id;

		return $this->devolucionesTableResponse($where);
    }

    public function misDevolucionesDelDia()
    {
		$where  = "DATE_FORMAT(devoluciones.created_at, '%Y-%m-%d') = DATE_FORMAT(current_date, '%Y-%m-%d')";
		$where .= " AND users.id = ".Auth::user()->id;
		$where .= " AND devoluciones.tienda_id = ".Auth::user()->tienda_id;

		return $this->devolucionesTableResponse($where);
    }

    public function devolucionesTableResponse($where)
    {
		return Response::json(array(
			'success' => true,
			'table'   => View::make('ventas.devoluciones.devoluciones', compact('where'))->render()
		));
    }

	public function devoluciones_DT()
	{
		$table = 'devoluciones';

		$columns = array(
			"devoluciones.created_at as fecha",
			"CONCAT_WS(' ', users.nombre, users.apellido) as usuario",
			"clientes.nombre as cliente",
			"total"
		);

		$Search_columns = array("users.nombre", "users.apellido", "clientes.nombre");
		$Join = "JOIN users ON (users.id = devoluciones.user_id) JOIN clientes ON (clientes.id = devoluciones.cliente_id)";
		$where = Input::get('where');

		echo TableSearch::get($table, $columns, $Search_columns, $Join, $where );
	}

	public function getDevolucionesDetail()
	{
		$detalle = $this->getDevolucionesDetalle();

		return Response::json(array(
			'success' => true,
			'table'   => View::make('ventas.devoluciones.DT_detalleDevolucion', compact('detalle'))->render()
        ));
	}

	public function openDevolucion()
	{
		$devolucion = Devolucion::find(Input::get('devolucion_id'));

        if ($devolucion->completed)
            return 'No puede abrir la devolucion porque ya fue finalizada...!';

		$detalle = json_encode($this->getDevolucionesDetalle());

		$venta = Venta::with('cliente')->find($devolucion->venta_id);

		$devolucion_id = Input::get('devolucion_id');

		return Response::json(array(
			'success' => true,
			'table' => View::make('ventas.devoluciones.unfinishedDevoluciones', compact('venta', 'devolucion_id', 'detalle'))->render()
        ));
	}

	public function deleteDevolucion()
	{
		$devolucion = Devolucion::find(Input::get('devolucion_id'));

        if ($devolucion->completed)
            return 'No puede eliminar la devolucion porque ya fue finalizada...!';

        if ($devolucion->delete()) {
			return Response::json(array(
				'success' => true
	        ));
        }
	}

	public function getSerialsForm()
	{
		$serials = json_encode(Input::get('serials'));
		$serial_index = Input::get('serial_index'); // El index del producto que se esta modificando para actualizar los seriales

		return Response::json(array(
			'success' => true,
			'view' => View::make('ventas.devoluciones.serialsForm', compact('serials', 'serial_index'))->render()
		));
	}

	public function post_detalle_devolulcion_serie()
	{
		$dd = DevolucionDetalle::find(Input::get('devolucion_detalle_id'));

		if ($dd->serials)
			$dd->serials = $dd->serials .','.Input::get('serie');

		else
			$dd->serials = Input::get('serie');

		$dd->save();

		return Response::json(array(
			'success' => true
		));
	}

	public function post_detalle_devolulcion_serie_delete()
	{
		$dd = DevolucionDetalle::find(Input::get('devolucion_detalle_id'));

	    $dd->serials = implode(",", array_diff(explode(",", $dd->serials), array(Input::get('serie'))));
	    $dd->save();

		return Response::json(array(
			'success' => true
		));
	}

    public function table_productos_para_devolucion()
    {
    	$venta_id = Input::get('venta_id');

        return View::make('ventas.devoluciones.table_productos_para_devolucion', compact('venta_id'));
    }

    public function productos_para_devolucion_DT()
    {
       $table = 'detalle_ventas';

        $columns = array(
        	'codigo',
        	'marcas.nombre as marca',
        	'descripcion',
        	'cantidad',
        	'precio',
        	'cantidad * precio as total'
        );

        $Searchable = array("descripcion");
        $Join = 'JOIN productos ON detalle_ventas.producto_id = productos.id  JOIN  marcas ON productos.marca_id = marcas.id';
        $where = "detalle_ventas.venta_id = ".Input::get('venta_id');

        echo TableSearch::get($table, $columns, $Searchable, $Join, $where);
    }

	public function printDevolucion()
	{
		$devolucion = Devolucion::with('devolucion_detalle', 'devolucion_pagos', 'cliente')
		->find(Input::get('devolucion_id'));

		$pdf = PDF::loadView('ventas.devoluciones.printDevolucion',  array('devolucion' => $devolucion))->setPaper('letter');
		return $pdf->stream('Devolucion');
	}

}

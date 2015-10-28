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

		Devolucion::find($devolucion_id)->update(array('total' => $totalDevolucion, 'completed' => 1));

		if ($descuento_sobre_saldo > 0) {
			$dp = new DevolucionPago;
			$dp->devolucion_id = $devolucion_id;
			$dp->metodo_pago_id = 7;
			$dp->monto = $descuento_sobre_saldo;
			$dp->save();
		}

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
				$nc->cliente_id = Input::get('cliente_id');
				$nc->tienda_id = Input::get('tienda_id');
				$nc->user_id = Auth::user()->id;
				$nc->tipo = 'devolucion';
				$nc->tipo_id = $devolucion_id;
				$nc->monto = $monto_a_devolver;
				$nc->save();
			}
		}

		$devolucion_detalle = DevolucionDetalle::whereDevolucionId($devolucion_id)->get();

		foreach ($devolucion_detalle as $key => $devolucion)
		{
            $Existencia = Existencia::whereProductoId($devolucion->producto_id)->whereTiendaId(Input::get('tienda_id'))->first();
            $Existencia->existencia = $Existencia->existencia + $devolucion->cantidad;
            $Existencia->save();
		}

	    $venta = Venta::find(Input::get('venta_id'));

        if ($venta->total == $totalDevolucion)
        {
        	DetalleVenta::whereVentaId(Input::get('venta_id'))->delete();
        	$venta->total = 0;
        	$venta->saldo = 0;
        	$venta->canceled = 1;
        	$venta->save();
        }
        else
        {
        	$venta->total = $venta->total - $totalDevolucion;

		    if( $totalDevolucion >= $venta->saldo )
		        $venta->saldo = 0;
		    else
		        $venta->saldo = $venta->saldo - $totalDevolucion;

        	$venta->save();

			foreach ($devolucion_detalle as $key => $devolucion)
			{
	            $detalle_venta = DetalleVenta::where('venta_id', Input::get('venta_id'))
	            ->where('producto_id', $devolucion->producto_id)->first();

	            if ($detalle_venta->cantidad == $devolucion->cantidad) {
	            	$detalle_venta->delete();
	            } else {
		            $detalle_venta->cantidad = $detalle_venta->cantidad - $devolucion->cantidad;
		            $detalle_venta->save();
	            }
			}
        }

		return Response::json(array(
			'success' => true
		));
	}

    public function misDevolucionesDelDia()
    {
		return Response::json(array(
			'success' => true,
			'table'   => View::make('ventas.devoluciones.devolucionesDelDia')->render()
		));
    }

	public function misDevolucionesDelDia_dt()
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
		$where = "DATE_FORMAT(devoluciones.created_at, '%Y-%m-%d') = DATE_FORMAT(current_date, '%Y-%m-%d')";
		$where .= " AND users.id = ".Auth::user()->id;
		$where .= " AND devoluciones.tienda_id = ".Auth::user()->tienda_id;

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

}

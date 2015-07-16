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

			$venta_id = $venta->get_id();

			return Response::json(array(
				'success' => true,
				'detalle' => View::make('ventas.detalle', compact('venta_id'))->render()
            ));
		}

		return View::make('ventas.create');
	}


	public function detalle()
	{
		if (Input::has('_token'))
		{
			Input::merge(array('precio' => str_replace(',', '', Input::get('precio'))));

			if ($this->check_if_code_exists_in_this_sale() == true) {
				return "El codigo ya ha sido ingresado..";
			}

			$nueva_existencia = $this->check_inventory();
			if ($nueva_existencia === false) {
				return "La cantidad que esta ingresando es mayor a la existencia..";
			}

			$query = new DetalleVenta;
			if ( !$query->SaleItem())
			{
				return $query->errors();
			}

			Existencia::where('producto_id', Input::get('producto_id'))
			->where('tienda_id',Auth::user()->tienda_id)
			->update(array('existencia' => $nueva_existencia));

			$detalle = $this->getSalesDetail();
			$detalle = json_encode($detalle);

			return Response::json(array(
				'success' => true,
				'table'   => View::make('ventas.detalle_body', compact('detalle'))->render()
	        ));
		}

		return 'Token invalido';
	}




	public function getSalesDetail()
	{
		$detalle = DB::table('detalle_ventas')
        ->select(array(
        	'detalle_ventas.id',
        	'venta_id', 'producto_id',
        	'cantidad', 
        	'precio', 
        	DB::raw('CONCAT(productos.descripcion, " ", marcas.nombre) AS descripcion, cantidad * precio AS total') ))
        ->where('venta_id', Input::get('venta_id'))
        ->join('productos', 'detalle_ventas.producto_id', '=', 'productos.id')
        ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
        ->get();

        return $detalle;
	}
	

	public function RemoveSale()
	{
		$detalle_venta = DetalleVenta::where('venta_id', Input::get('id'))->get();

		$destroy = Venta::destroy(Input::get('id'));

		if ($destroy)
		{
			foreach ($detalle_venta as $dv) {
				$q = Existencia::where('producto_id', $dv->producto_id )
	            ->where('tienda_id', Auth::user()->tienda_id)->first();
	            $q->existencia = $q->existencia + $dv->cantidad;
	            $q->save();
			}

			return Response::json(array(
				'success' => true
            ));
		}

		return 'Huvo un error al tratar de eliminar';
	}


	public function RemoveSaleItem()
	{
		$dv = DetalleVenta::find(Input::get('id'));

		$delete = DetalleVenta::destroy(Input::get('id'));

		if ($delete)
		{
            $Existencia = Existencia::where('producto_id', $dv->producto_id)
            ->where('tienda_id', Auth::user()->tienda_id)->first();

            $Existencia->existencia = $Existencia->existencia + $dv->cantidad;
            $Existencia->save();

			return Response::json(array(
				'success' => true
            ));
		}

		return 'Huvo un error al tratar de eliminar';	
	}


    public function check_if_code_exists_in_this_sale()
    {
		$query = DB::table('detalle_ventas')->select('id')
	    ->where('venta_id', Input::get("venta_id"))
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


	public function ModalSalesPayments()
	{
		if (Input::has('_token'))
		{
			if($this->check_if_payment_already_exists() == true) 
				return "Seleccione otro metodo de pago o modifique el que ya existe";

            $vuelto = 0;
            $monto = str_replace(',', '', Input::get('monto'));
            $TotalVenta = $this->getTotalVenta();
	        $resta_abonar = $TotalVenta - $this->getTotalPagado();

            if ($monto > $resta_abonar)
            {
            	Input::merge(array('monto' => $resta_abonar));
            	$vuelto = $monto - $resta_abonar;
            	$resta_abonar = 0;

            } else {
            	$resta_abonar = $resta_abonar - $monto;
            	Input::merge(array('monto' => $monto));
            }

			$pv = new PagosVenta;

			if (!$pv->_create())
			{
				return $pv->errors();
			}

			$pv = PagosVenta::with('metodo_pago')->where('venta_id', Input::get('venta_id'))->get();

			return Response::json(array(
				'success' => true, 
				'detalle' => View::make('ventas.payments', compact('pv', 'TotalVenta', 'resta_abonar', 'vuelto'))->render()
			));

		}

		PagosVenta::where('venta_id', Input::get('venta_id'))->delete();

        if ($this->getTotalVenta() == null ) {
            return 'No a ingresado ningun producto a la factura...!';
        }

        return $this->ViewPayments();
	}


    public function check_if_payment_already_exists()
    {
		$query = PagosVenta::where('venta_id', Input::get('venta_id'))
		->where('metodo_pago_id', Input::get('metodo_pago_id'))->first();

	    if($query == null)
	        return false;

	    return true;
    }


	public function getTotalVenta()
	{
        $dv = DetalleVenta::where('venta_id','=', Input::get('venta_id'))
        ->first(array(DB::raw('sum(cantidad * precio) as total')));

        return $dv->total;
	}


	public function ViewPayments()
	{
		$pv = PagosVenta::with('metodo_pago')->where('venta_id', Input::get('venta_id'))->get();
		$TotalVenta = $this->getTotalVenta();
        $resta_abonar = $TotalVenta - $this->getTotalPagado();
        $vuelto = 0;

		return Response::json(array(
			'success' => true, 
			'detalle' => View::make('ventas.payments', compact('pv', 'TotalVenta', 'resta_abonar', 'vuelto'))->render()
		));
	}


	public function getTotalPagado()
	{
        $pagos = PagosVenta::where('venta_id', Input::get('venta_id'))
        ->first(array(DB::raw('sum(monto) as total')));

        if ($pagos == null) {
        	return 0;
        }

        return $pagos->total;
	}


	public function RemoveSalePayment()
	{
		$destroy = PagosVenta::destroy(Input::get('id'));

		if ($destroy) {
			return $this->ViewPayments();
		}

		return 'error';
	}


	public function FinalizeSale()
	{
        $credit = PagosVenta::where('venta_id', Input::get('venta_id'))
        ->where('metodo_pago_id', 2)
        ->first(array(DB::raw('monto')));

        if ($credit == null) {
            $saldo = 0;
        }
        else {
            $saldo = $credit->monto;
        }
        $total = DetalleVenta::where('venta_id','=',Input::get('venta_id'))->first(array(DB::raw('sum(cantidad * precio) as total')));

		$venta = Venta::where('id', Input::get('venta_id'))
		->update(array('completed' => 1, 'saldo' => $saldo,'total' => $total->total));
		
		if ($venta) {
			return Response::json(array( 'success' => true ));
		}

		return 'Huvo un error intentelo de nuevo';
	}


	public function showSalesDetail()
	{
		$detalle = $this->getSalesDetail();

		return Response::json(array(
			'success' => true,
			'table'   => View::make('ventas.DT_detalle_venta', compact('detalle'))->render()
        ));
	}


	public function openSale()
	{
		$venta = Venta::with('cliente', 'detalle_venta')->find(Input::get('venta_id'));

		if ($venta->completed != 0) {
			return json_encode('La venta no se puede abrir porque ya fue finalizada');
		}

		$venta->update(array('completed' => 0, 'saldo' => 0));

		$detalle = $this->getSalesDetail();

		$detalle = json_encode($detalle);

		$venta_id = $venta->id;

		return Response::json(array(
			'success' => true,
			'table' => View::make('ventas.unfinishedSale', compact('venta', 'detalle', 'venta_id'))->render()
        ));
	}


	public function getCreditSales()
	{
		$ventas = DB::table('ventas')
        ->select(DB::raw("ventas.id,
        	ventas.total,
        	DATE_FORMAT(ventas.created_at, '%Y-%m-%d') as fecha,  
            CONCAT_WS(' ',users.nombre,users.apellido) as usuario, 
            CONCAT_WS(' ',clientes.nombre,clientes.apellido) as cliente,
            saldo"))
        ->join('users', 'ventas.user_id', '=', 'users.id')
        ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
        ->where('ventas.tienda_id', Auth::user()->tienda_id)
        ->where('saldo', '>', 0)
        ->orderBy('fecha', 'ASC')
        ->get();

		return Response::json(array(
			'success' => true,
			'table' => View::make('ventas.creditSales', compact('ventas'))->render()
        ));
	}

	function ImprimirVentaModal()
	{
		$venta_id = Input::get('venta_id');

		return Response::json(array(
			'success' => true,
			'form' => View::make('ventas.ImprimirVentaModal',compact('venta_id'))->render()
        ));
	}

	function ImprimirFacturaVenta($id)
	{
		$venta_id = Crypt::decrypt($id);

		$venta = Venta::with('cliente', 'detalle_venta')->find($venta_id);
    	if(count($venta->detalle_venta)>0)
    	{
        	return View::make('ventas.ImprimirFactura', compact('venta'))->render();
    	}
    	else
        	return 'Ingrese productos ala factura para poder inprimir';
	}

	function ImprimirFacturaVenta_dt($code,$id)
	{
		$venta_id = $id;

		$venta = Venta::with('cliente', 'detalle_venta')->find($venta_id);
    	if(count($venta->detalle_venta)>0)
    	{
        	return View::make('ventas.ImprimirFactura', compact('venta'))->render();
    	}
    	else
        	return 'Ingrese productos ala factura para poder inprimir';
	}

	function ImprimirGarantiaVenta_dt($code,$id)
	{
		$venta_id = $id;

		$venta = Venta::with('cliente', 'detalle_venta')->find($venta_id);
    	if(count($venta->detalle_venta)>0)
    	{
        	return View::make('ventas.ImprimirGarantia', compact('venta'))->render();
    	}
    	else
        	return 'Ingrese productos ala factura para poder inprimir';
	}

	function ImprimirGarantiaVenta($id)
	{
		$venta_id = Crypt::decrypt($id);

		$venta = Venta::with('cliente', 'detalle_venta')->find($venta_id);
    	if(count($venta->detalle_venta)>0)
    	{
        	return View::make('ventas.ImprimirGarantia', compact('venta'))->render();
    	}
    	else
        	return 'Ingrese productos ala factura para poder inprimir';
	}

	function updateClienteId()
	{
		$venta = Venta::find(Input::get('venta_id'));
		$venta->cliente_id = Input::get('cliente_id');
		$venta->save();

		if (!$venta)
			return false;

		return Response::json(array(
			'success' => true
        ));
	}

	
	
	public function UpdateDetalle()
	{
		if ( Input::get('field') == 'precio' ) {
			$precio = str_replace(',', '', Input::get('values.precio'));
			$precio = preg_replace('/\s{2,}/', ' ', $precio);
	        $query = Producto::find(Input::get('values.producto_id'));
	        $ganancias = $precio - ( $query->p_costo / 100);

			DetalleVenta::find( Input::get('values.id') )
			->update(array('precio' => Input::get('values.precio'), 'ganancias' => $ganancias ));

			return $this->returnDetail();
		}

		if ( Input::get('values.cantidad') < 1 ) {
			return 'La cantidad deve ser mayor a 0';
		}

		$cantidad =  Input::get('values.cantidad') - Input::get('oldvalue');

		$nueva_existencia = $this->check_inventory( Input::get('values.producto_id'), $cantidad );

		if ($nueva_existencia === false) {
			return "La cantidad que esta ingresando es mayor a la existencia..";
		}

		DetalleVenta::find( Input::get('values.id') )
		->update(array('cantidad' => Input::get('values.cantidad')));

		Existencia::where('producto_id', Input::get('values.producto_id'))
		->where('tienda_id', Auth::user()->tienda_id)
		->update(array('existencia' => $nueva_existencia));

		return $this->returnDetail();
	}

	public function returnDetail()
	{
		$detalle = $this->getSalesDetail();
		$detalle = json_encode($detalle);

		return Response::json(array(
			'success' => true,
			'table'   => View::make('ventas.detalle_body', compact('detalle'))->render()
        ));
	}

	public function VentasPorMetodoDePago()
	{
		$fecha = "'".Input::get('fecha')."'";

        if (Input::get('fecha') == 'current_date') 
            $fecha = 'current_date';

		$table = 'ventas';

		$columns = array(
			"ventas.id",
        	"ventas.total as total",
        	"DATE_FORMAT(ventas.created_at, '%Y-%m-%d') as fecha",  
            "CONCAT_WS(' ',users.nombre,users.apellido) as usuario", 
            "CONCAT_WS(' ',clientes.nombre,clientes.apellido) as cliente",
            "pagos_ventas.monto as pago"
		);

		$Search_columns = array("users.nombre","users.apellido","venta.created_at");

		$Join  = "JOIN pagos_ventas ON (pagos_ventas.venta_id = ventas.id) ";
		$Join .= "JOIN metodo_pago ON (pagos_ventas.metodo_pago_id = metodo_pago.id) ";
		$Join .= "JOIN users ON (users.id = ventas.user_id) ";
		$Join .= "JOIN clientes ON (clientes.id = ventas.cliente_id)";

		$where  = " ventas.tienda_id = ".Auth::user()->tienda_id;
		$where .= " AND ventas.completed =  1 ";
		$where .= " AND DATE_FORMAT(ventas.created_at, '%Y-%m-%d')= DATE_FORMAT(".$fecha." , '%Y-%m-%d')";
		$where .= " AND metodo_pago.id = ".Input::get('metodo_pago_id');

		$ventas = SST::get($table, $columns, $Search_columns, $Join, $where );

		$metodo_pago = MetodoPago::find(Input::get('metodo_pago_id'));

        return Response::json(array(
			'success' => true,
			'table' => View::make('ventas.VentasPorMetodoDePago', compact('ventas','metodo_pago'))->render()
        ));
	}

}

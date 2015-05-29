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
		if (Session::token() == Input::get('_token'))
		{
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
			->where('tienda_id', Auth::user()->tienda_id)
			->update(array('existencia' => $nueva_existencia));

			return $this->table_detail();
		}

		return 'Token invalido';
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
		$delete = DetalleVenta::destroy(Input::get('id'));

		if ($delete)
		{
            $q = Existencia::where('producto_id', Input::get('producto_id'))
            ->where('tienda_id', Auth::user()->tienda_id)->first();
            $q->existencia = $q->existencia + Input::get('cantidad');
            $q->save();

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
        ->where('venta_id', Input::get('id'))
        ->join('productos', 'detalle_ventas.producto_id', '=', 'productos.id')
        ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
        ->get();

		$deuda = 0;

		return Response::json(array(
			'success' => true,
			'table'   => View::make('ventas.detalle_body', compact('detalle', 'deuda'))->render()
        ));
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


    public function check_inventory()
    {
	    $query = Existencia::where('producto_id', Input::get('producto_id'))->where('tienda_id', Auth::user()->tienda_id)->first();

	    if ( $query == null || $query->existencia < Input::get('cantidad') ) {
	    	return false;
	    }

	    $nueva_existencia = $query->existencia - Input::get('cantidad');

	    return $nueva_existencia;
    }


	public function ModalSalesPayments()
	{

		if (Input::has('_token'))
		{
			if($this->check_if_payment_already_exists() == true) 
				return "Seleccione otro metodo de pago o modifique el que ya existe";

			$pv = new PagosVenta;

			if (!$pv->_create())
			{
				return $pv->errors();
			}

			return $this->ViewPayments();
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

		return Response::json(array(
			'success' => true, 
			'detalle' => View::make('ventas.payments', compact('pv', 'TotalVenta', 'resta_abonar'))->render()
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
        $credit = PagosVenta::where('venta_id', 50)
        ->where('metodo_pago_id', 2)
        ->first(array(DB::raw('monto')));

        if ($credit == null) {
            $saldo = 0;
        }
        else {
            $saldo = $credit->monto;
        }

		$venta = Venta::where('id', Input::get('id'))->update(array('completed' => 1, 'saldo' => $saldo));
		
		if ($venta) {
			return Response::json(array( 'success' => true ));
		}

		return 'Huvo un error intentelo de nuevo';
	}


	public function OpenTableSalesDay()
	{
		return View::make('ventas.SalesDay');
	}


	public function showSalesDetail()
	{
    	$detalle = DB::table('detalle_ventas')
        ->select(array('detalle_ventas.id', 'venta_id', 'producto_id', 'cantidad', 'precio', DB::raw('CONCAT(productos.descripcion, " ", marcas.nombre) AS descripcion, cantidad * precio AS total') ))
        ->where('venta_id', Input::get('id'))
        ->join('productos', 'detalle_ventas.producto_id', '=', 'productos.id')
        ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
        ->get();

		$deuda = 0;

		return Response::json(array(
			'success' => true,
			'table'   => View::make('ventas.DT_detalle_venta', compact('detalle', 'deuda'))->render()
        ));
	}

}

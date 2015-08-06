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

		$venta = Venta::find(Input::get('venta_id'));
		$venta->completed = 1;
		$venta->saldo = $saldo;
		$venta->total = $total->total;
		
		if ($venta->save()) {
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

		if(!Auth::user()->hasRole("Admin") && !Auth::user()->hasRole("Owner"))
		{
			if ($venta->completed != 0) 
				return json_encode('La venta no se puede abrir porque ya fue finalizada');
		}

		$venta->update(array('completed' => 0, 'saldo' => 0 , 'kardex' => 0));

		$kardex = Kardex::where('kardex_transaccion_id',2)->where('transaccion_id',Input::get('venta_id'));
		$kardex->delete();

		
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

	function imprimirFactura()
	{
		$venta_id = Input::get('venta_id');

		$venta = Venta::with('cliente', 'detalle_venta')->find($venta_id);
    	if(count($venta->detalle_venta)>0)
    	{
        	return View::make('ventas.DemoFactura', compact('venta'))->render();
    	}
    	else
        	return 'Ingrese productos ala factura para poder inprimir';
	}

	function ImprimirFacturaVenta()
	{
		$venta_id = Input::get('venta_id');

		$venta = Venta::with('cliente', 'detalle_venta')->find($venta_id);

    	if( count($venta->detalle_venta) > 0 )
        	return View::make('ventas.ImprimirFactura', compact('venta'))->render();

    	else
        	return 'Ingrese productos ala factura para poder inprimir';
	}

	function ImprimirFacturaVenta_dt($code,$id)
	{
		$venta_id = $id;

		$venta = Venta::with('cliente', 'detalle_venta')->find($venta_id);
    	if(count($venta->detalle_venta)>0)
        	return View::make('ventas.ImprimirFactura', compact('venta'))->render();

    	else
        	return 'Ingrese productos ala factura para poder inprimir';
	}

	function ImprimirGarantiaVenta_dt($code,$id)
	{
		$venta_id = $id;

		$venta = Venta::with('cliente', 'detalle_venta')->find($venta_id);
    	if(count($venta->detalle_venta)>0)
        	return View::make('ventas.ImprimirGarantia', compact('venta'))->render();

    	else
        	return 'Ingrese productos ala factura para poder inprimir';
	}

	function ImprimirGarantiaVenta()
	{
		$venta_id = Input::get('venta_id');
		$venta = Venta::with('cliente', 'detalle_venta')->find($venta_id);

    	if(count($venta->detalle_venta)>0)
        	return View::make('ventas.ImprimirGarantia', compact('venta'))->render();

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

		return Response::json( array(
			'success' => true,
			'table'   => View::make('ventas.detalle_body', compact('detalle'))->render()
        ));
	}

	public function getVentasPedientesDePago()
	{
		$saldo_total = Venta::where('tienda_id','=',Auth::user()->tienda_id)
		->where('ventas.completed', '=', 1)
        ->where('saldo','>', 0 )->first(array(DB::Raw('sum(saldo) as total')));

        $saldo_vencido = DB::table('ventas')
        ->select(DB::raw('sum(saldo) as total'))->where('saldo','>',0)
        ->where('ventas.completed', '=', 1)
        ->where(DB::raw('DATEDIFF(current_date,created_at)'),'>=',30)
        ->where('tienda_id','=',Auth::user()->tienda_id)->first();
         $tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

		$infoSaldosTotales = "Saldo total &nbsp;".f_num::get($saldo_total->total)."{$tab}Saldo vencido &nbsp;".f_num::get($saldo_vencido->total);
		$tienda_id = Auth::user()->tienda_id;

		$ventas = DB::table('clientes')
        	->select(DB::raw("
        		clientes.id as id,
        		CONCAT_WS(' ',clientes.nombre,clientes.apellido)  as cliente,
        		clientes.direccion as direccion,
        		sum(ventas.total) as total,
        		sum(ventas.saldo) as saldo_total,
        		(select sum(saldo) from ventas where 
        			tienda_id = {$tienda_id} AND completed = 1 AND
        			DATEDIFF(current_date, created_at) >= 30 
        			AND cliente_id = clientes.id) as saldo_vencido
        		"))
	        ->join('ventas', 'ventas.cliente_id', '=', 'clientes.id')
	        ->where('ventas.saldo', '>', 0)
	        ->where('ventas.completed', '=', 1)
	        ->where('ventas.tienda_id', '=', Auth::user()->tienda_id)
	        ->groupBy('cliente_id')
	        ->get();

		return Response::json(array(
			'success' => true,
			'table' => View::make('ventas.getVentasPedientesDePago', compact('ventas'))->render(),
			'infoSaldosTotales' => $infoSaldosTotales
        ));

	}
	public function getVentasPendientesPorCliente()
	{	
		$table = 'ventas';

        $columns = array(
            "ventas.id as id_compra",
            "ventas.created_at as fecha_ingreso",  
            "CONCAT_WS(' ',users.nombre,users.apellido) as usuario", 
            "ventas.total as total", 
            "ventas.saldo as saldo",
            "DATEDIFF(current_date,ventas.created_at) as dias"
        );

        $Search_columns = array("users.nombre","users.apellido","venta.created_at","ventas.total" ,"ventas.saldo");

        $Join = "JOIN users ON (users.id = ventas.user_id) ";

        $where  = " ventas.tienda_id = ".Auth::user()->tienda_id;
        $where  = " ventas.saldo > 0 ";
        $where .= " AND ventas.cliente_id = ".Input::get('cliente_id');

        $detalle = SST::get($table, $columns, $Search_columns, $Join, $where );

        return Response::json(array(
            'success' => true,
            'table'   => View::make('ventas.getVentasPendientesPorCliente', compact('detalle'))->render()
        ));

	}
	
	public function getVentaConDetalle()
	{
		$venta = Venta::with('detalle_venta','cliente')->find(Input::get('venta_id'));

		 return Response::json(array(
            'success' => true,
            'table' => View::make('ventas.getVentaConDetalle', compact('venta'))->render()
        ));
	}

	public function getVentasPorHoraPorUsuario()
	{
		$fecha = Input::get('fecha');

		$ventas =  DB::table('users')
            ->select(DB::raw('users.id as id,
            	detalle_ventas.created_at as fecha,
            	CONCAT_WS(" ",users.nombre, users.apellido) as usuario,
                sum(detalle_ventas.cantidad * detalle_ventas.precio) as total,
                sum(detalle_ventas.cantidad * detalle_ventas.ganancias) as utilidad'))
            ->join('ventas','ventas.user_id','=','users.id')
            ->join('detalle_ventas','detalle_ventas.venta_id','=','ventas.id')
            ->where('users.tienda_id','=',Auth::user()->tienda_id)
            ->where('users.status','=',1)
            ->whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m-%d %H')= DATE_FORMAT('{$fecha}', '%Y-%m-%d %H')")
            ->orderBy('total', 'DESC')
            ->groupBy('users.id','users.nombre','users.apellido')
            ->get();

		return Response::json(array(
			'success' => true,
			'table' => View::make('ventas.getVentasPorHoraPorUsuario', compact('ventas'))->render(),
        ));
	}

}

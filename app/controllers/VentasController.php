<?php

class VentasController extends \BaseController {

	public function create()
	{
		if (Input::has('_token'))
		{
			$venta = new Venta;

			$data = Input::all();

			if (!$venta->create_master($data))
				return $venta->errors();

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

            /*if (Auth::user()->hasRole("Admin"))
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
            }*/


			if ($this->check_if_code_exists_in_this_sale() == true)
				return "El codigo ya ha sido ingresado..";

			$nueva_existencia = $this->check_inventory();

			if ($nueva_existencia === false)
				return "La cantidad que esta ingresando es mayor a la existencia..";

			$query = new DetalleVenta;

			if ( !$query->SaleItem())
				return $query->errors();

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
				$this->recalcularPrecioCosto($dv->id, $dv);
				/*$q = Existencia::where('producto_id', $dv->producto_id )
	            ->where('tienda_id', Auth::user()->tienda_id)->first();
	            $q->existencia = $q->existencia + $dv->cantidad;
	            $q->save();*/
			}

			return Response::json(array(
				'success' => true
            ));
		}

		return 'Hubo un error al tratar de eliminar';
	}

	public function RemoveSaleItem()
	{
		$dv = DetalleVenta::find(Input::get('id'));

		$delete = DetalleVenta::destroy(Input::get('id'));

		if ($delete)
		{
			 $this->recalcularPrecioCosto($dv->id, $dv);
			/*$Existencia = Existencia::where('producto_id', $dv->producto_id)
	         ->where('tienda_id', Auth::user()->tienda_id)->first();
	         $Existencia->existencia = $Existencia->existencia + $dv->cantidad;
	         $Existencia->save();
			*/
			return Response::json(array(
				'success' => true
            ));
		}

		return 'Hubo un error al tratar de eliminar';
	}


    public function check_if_code_exists_in_this_sale()
    {
		$query = DB::table('detalle_ventas')->select('id')
	    ->where('venta_id', Input::get("venta_id"))
	    ->where('producto_id', Input::get("producto_id"))
	    ->first();

	    if($query == null)
	        return false;

	    return true;
    }


    public function check_inventory( $producto_id = null, $cantidad = null )
    {
    	if ($producto_id === null)
    		$producto_id = Input::get('producto_id');

    	if ($cantidad === null)
    		$cantidad = Input::get('cantidad');

	    $query = Existencia::where('producto_id', $producto_id )->where('tienda_id', Auth::user()->tienda_id)->first();

	    if ( $query == null || $query->existencia < $cantidad )
	    	return false;

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
	        $resta_abonar = round(floatval($TotalVenta) - floatval($this->getTotalPagado()), 4);

            if ($monto > $resta_abonar)
            {
            	Input::merge(array('monto' => $resta_abonar));
            	$vuelto = floatval($monto) - floatval($resta_abonar);
            	$resta_abonar = 0;
            }
            else
            {
            	$resta_abonar = round(floatval($resta_abonar) - floatval($monto), 4);
            	Input::merge(array('monto' => $monto));
            }

			$pv = new PagosVenta;

			if (!$pv->_create())
				return $pv->errors();

			$factura = DB::table('printer')->select('impresora')
			->where('tienda_id', Auth::user()->tienda_id)->where('nombre', 'factura')->first();

			$garantia = DB::table('printer')->select('impresora')
			->where('tienda_id',Auth::user()->tienda_id)->where('nombre','garantia')->first();

			$venta = Venta::find(Input::get('venta_id'));

			$cliente_id = $venta->cliente_id;

			$pv = PagosVenta::with('metodo_pago')->where('venta_id', Input::get('venta_id'))->get();

			return Response::json(array(
				'success' => true,
				'detalle' => View::make('ventas.payments', compact('pv', 'TotalVenta', 'resta_abonar', 'vuelto', 'factura', 'garantia', 'cliente_id'))->render()
			));

		}

		PagosVenta::where('venta_id', Input::get('venta_id'))->delete();

        if ($this->getTotalVenta() == null )
            return 'No a ingresado ningun producto a la factura...!';

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

	public function pagoConNotasDeCredito()
	{
		$monto = 0;
		foreach (Input::get('notas_creditos')  as $nc) {
			$monto += floatval($nc['monto']);
			$notasCreditos = NotaCredito::find($nc['id_nota']);
			$notasCreditos->venta_id = Input::get('venta_id');
			$notasCreditos->save();
		}

		$vuelto = 0;

		$TotalVenta = $this->getTotalVenta();
		$resta_abonar = $TotalVenta - $this->getTotalPagado();
		$resta_abonar = $resta_abonar - $monto;

		$pv = new PagosVenta;
		$pv->monto = $monto;
		$pv->venta_id = Input::get('venta_id');
		$pv->metodo_pago_id = 6;
		$pv->save();

		$factura = DB::table('printer')->select('impresora')
		->where('tienda_id', Auth::user()->tienda_id)->where('nombre', 'factura')->first();

		$garantia = DB::table('printer')->select('impresora')
		->where('tienda_id',Auth::user()->tienda_id)->where('nombre','garantia')->first();

		$venta = Venta::find(Input::get('venta_id'));

		$cliente_id = $venta->cliente_id;

		$pv = PagosVenta::with('metodo_pago')->where('venta_id', Input::get('venta_id'))->get();

		return Response::json(array(
			'success' => true,
			'detalle' => View::make('ventas.payments', compact('pv', 'TotalVenta', 'resta_abonar', 'vuelto', 'factura', 'garantia', 'cliente_id'))->render()
		));
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
        $resta_abonar = floatval($TotalVenta) - floatval($this->getTotalPagado());
        $vuelto = 0;

        $factura = DB::table('printer')->select('impresora')
		->where('tienda_id', Auth::user()->tienda_id)->where('nombre', 'factura')->first();

		$garantia = DB::table('printer')->select('impresora')
		->where('tienda_id',Auth::user()->tienda_id)->where('nombre','garantia')->first();

		$venta = Venta::find(Input::get('venta_id'));
		$cliente_id = $venta->cliente_id;

		return Response::json(array(
			'success' => true,
			'detalle' => View::make('ventas.payments', compact('pv', 'TotalVenta', 'resta_abonar', 'vuelto', 'factura', 'garantia', 'cliente_id'))->render()
		));
	}


	public function getTotalPagado()
	{
        $pagos = PagosVenta::where('venta_id', Input::get('venta_id'))
        ->first(array(DB::raw('sum(monto) as total')));

        if ($pagos == null)
        	return 0;

        return $pagos->total;
	}


	public function RemoveSalePayment()
	{
		$destroy = PagosVenta::destroy(Input::get('id'));

		if ($destroy)
			return $this->ViewPayments();

		return 'error';
	}

	public function enviarVentaACaja()
	{
		$venta = Venta::find(Input::get('venta_id'));
		$total = DetalleVenta::where('venta_id','=',Input::get('venta_id'))->first(array(DB::raw('sum(cantidad * precio) as total')));


		if ($venta->completed == 1)
			return 'esta venta ya fue finalizada..';

			$venta->completed = 2;
			$venta->total = $total->total;

		if ($venta->save())
			return Response::json(array( 'success' => true ));

		return 'Hubo un error intentelo de nuevo';
	}

	public function FinalizeSale()
	{
        $credit = PagosVenta::where('venta_id', Input::get('venta_id'))
        ->where('metodo_pago_id', 2)
        ->first(array(DB::raw('monto')));

        if ($credit == null)
            $saldo = 0;
        else
            $saldo = $credit->monto;

		$notasCredito = PagosVenta::where('venta_id', Input::get('venta_id'))
        ->where('metodo_pago_id', 6)
        ->first(array(DB::raw('monto')));

		if (@$notasCredito->monto != "") {
            $notasDeCredito = NotaCredito::whereVentaId(Input::get('venta_id'))->get();
			foreach ($notasDeCredito as $nc) {
				$nota = NotaCredito::find($nc->id);
				$nota->estado = 1;
				$nota->save();
			}
        }

        $total = DetalleVenta::where('venta_id','=',Input::get('venta_id'))->first(array(DB::raw('sum(cantidad * precio) as total')));
		$caja = Caja::whereUserId(Auth::user()->id)->first();

		$venta = Venta::find(Input::get('venta_id'));
		$venta->completed = 1;
		$venta->saldo = $saldo;

		if (Auth::user()->tienda->cajas)
			$venta->caja_id = $caja->id;

		$venta->total = $total->total;

		if ($venta->save())
			return Response::json(array( 'success' => true ));

		return 'Hubo un error intentelo de nuevo';
	}


	public function showSalesDetail()
	{
		$detalle = $this->getSalesDetail();
		$pagos = PagosVenta::whereVentaId(Input::get('venta_id'))->with('metodo_pago')->get();

		return Response::json(array(
			'success' => true,
			'table'   => View::make('ventas.DT_detalle_venta', compact('detalle', 'pagos'))->render()
        ));
	}

	public function getCreditSales()
	{
		$ventas = DB::table('ventas')
        ->select(DB::raw("ventas.id,
        	ventas.total,
        	DATE_FORMAT(ventas.created_at, '%Y-%m-%d') as fecha,
            CONCAT_WS(' ',users.nombre,users.apellido) as usuario,
            clientes.nombre as cliente,
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

	function getModalImprimirVenta()
	{
		$venta_id = Input::get('venta_id');

		$factura = DB::table('printer')->select('impresora')
		->where('tienda_id', Auth::user()->tienda_id)->where('nombre', 'factura')->first();

		$garantia = DB::table('printer')->select('impresora')
		->where('tienda_id',Auth::user()->tienda_id)->where('nombre','garantia')->first();

		return Response::json(array(
			'success' => true,
			'form'    => View::make('ventas.ModalImprimirVenta', compact('venta_id', 'factura', 'garantia'))->render()
        ));
	}


	function clear($string )
	{
	    $string = trim($string);
	    $string = str_replace( array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $string );
	    $string = str_replace( array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $string );
	    $string = str_replace( array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $string );
	    $string = str_replace( array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $string );
	    $string = str_replace( array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $string );
	    $string = str_replace( array('ñ', 'Ñ', 'ç', 'Ç'), array('n', 'N', 'c', 'C',), $string );

	   return $string;
	}


	function imprimirFactura()
	{
		$venta_id = Input::get('venta_id');
		$venta = Venta::with('cliente', 'detalle_venta')->find($venta_id);

    	if(count($venta->detalle_venta)>0)
        	return View::make('ventas.DemoFactura', compact('venta'))->render();
    	else
        	return 'Ingrese productos ala factura para poder inprimir';
	}

	function ImprimirGarantia()
	{
		$venta = Venta::with('cliente', 'detalle_venta')->find(Input::get('id'));
		$tienda = Tienda::find(Auth::user()->tienda_id);

    	if(count($venta->detalle_venta)>0){
    		$pdf = PDF::loadView('ventas.ImprimirGarantia',  array('venta' => $venta, 'tienda' => $tienda))
    		->save("pdf/".Input::get('id').Auth::user()->id.'v.pdf')->setPaper('letter');

            return Response::json(array(
                'success' => true,
                'pdf'   => Input::get('id').Auth::user()->id.'v'
            ));
    	}

    	else
        	return 'Ingrese productos ala factura para poder inprimir';
	}

	function imprimirFacturaBond()
	{
		$venta = Venta::with('cliente', 'detalle_venta')->find(Input::get('id'));

    	if(count($venta->detalle_venta)>0){
			$pdf = PDF::loadView('ventas.imprimirFacturaPdf',  array('venta' => $venta))
			->setPaper('letter')
			->save("pdf/".Input::get('id').Auth::user()->id.'vf.pdf')->setPaper('letter');

            return Response::json(array(
                'success' => true,
                'pdf'   => Input::get('id').Auth::user()->id.'vf'
            ));
    	}

    	else
        	return 'Ingrese productos ala factura para poder inprimir';
	}


	function ImprimirGarantiaPdf()
	{
		$venta = Venta::with('cliente', 'detalle_venta')->find(Input::get('id'));
		$tienda = Tienda::find(Auth::user()->tienda_id);

		$metodo_pago = Input::get('metodo_pago'); // tarjeta o efectivo
		$pos = Input::get('pos'); // visa o credomatic
		$paymentOptions = Input::get('paymentOptions'); // contado o cuotas
		$recargo = Input::get('recargo');
		$porsentaje = 0;

		if ($metodo_pago == 'tarjeta')
		{
			if ($pos == 'visanet')
			{
				switch ($paymentOptions)
				{
				    case "3":  $porsentaje = 0.0736;
				        break;
				    case "6":  $porsentaje = 0.0861;
				        break;
				    case "10": $porsentaje = 0.0886;
				        break;
				    case "12": $porsentaje = 0.0961;
				        break;
				    case "18": $porsentaje = 0.1361;
				        break;
				    default:   $porsentaje = 0.0411;
				}

			} else {
				switch ($paymentOptions)
				{
				    case "3":  $porsentaje = 0.0761;
				        break;
				    case "6":  $porsentaje = 0.0861;
				        break;
				    case "10": $porsentaje = 0.0886;
				        break;
				    case "12": $porsentaje = 0.0961;
				        break;
				    case "18": $porsentaje = 0.1361;
				        break;
				    default:   $porsentaje = 0.0611;
				}
			}
		}

    	if(count($venta->detalle_venta) > 0){
			$pdf = PDF::loadView('ventas.ImprimirGarantia',  array(
				'venta' => $venta,
				'tienda' => $tienda,
				'porsentaje' => $porsentaje,
				'recargo' => $recargo
			))->setPaper('letter');

			return $pdf->stream();
    	}

    	else
        	return 'Ingrese productos ala factura para poder inprimir';
	}

	function imprimirFacturaBondPdf()
	{
		$venta = Venta::with('cliente', 'detalle_venta')->find(Input::get('id'));
		$metodo_pago = Input::get('metodo_pago'); // tarjeta o efectivo
		$pos = Input::get('pos'); // visa o credomatic
		$paymentOptions = Input::get('paymentOptions'); // contado o cuotas
		$recargo = Input::get('recargo');
		$porsentaje = 0;

		if ($metodo_pago == 'tarjeta')
		{
			if ($pos == 'visanet')
			{
				switch ($paymentOptions)
				{
				    case "3":  $porsentaje = 0.0736;
				        break;
				    case "6":  $porsentaje = 0.0861;
				        break;
				    case "10": $porsentaje = 0.0886;
				        break;
				    case "12": $porsentaje = 0.0961;
				        break;
				    case "18": $porsentaje = 0.1361;
				        break;
				    default:   $porsentaje = 0.0411;
				}

			} else {
				switch ($paymentOptions)
				{
				    case "3":  $porsentaje = 0.0761;
				        break;
				    case "6":  $porsentaje = 0.0861;
				        break;
				    case "10": $porsentaje = 0.0886;
				        break;
				    case "12": $porsentaje = 0.0961;
				        break;
				    case "18": $porsentaje = 0.1361;
				        break;
				    default:   $porsentaje = 0.0611;
				}
			}
		}


		$pdf = PDF::loadView('ventas.imprimirFacturaPdf',  array(
			'venta' => $venta,
			'porsentaje' => $porsentaje,
			'recargo' => $recargo
		))->setPaper('letter');

		return $pdf->stream();
	}

	// function ImprimirFacturaVenta()
	// {
	// 	$venta_id = Input::get('venta_id');

	// 	$venta = Venta::with('cliente', 'detalle_venta')->find($venta_id);

 //    	if( count($venta->detalle_venta) > 0 )
 //        	return View::make('ventas.ImprimirFactura', compact('venta'))->render();

 //    	else
 //        	return 'Ingrese productos ala factura para poder inprimir';
	// }


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

 	public function recalcularPrecioCosto($detalle_venta_id, $detalleVenta = null)
	{
		if($detalleVenta == null)
			$detalleVenta = DetalleVenta::find($detalle_venta_id);

		$precioCostoDetalleVenta = ($detalleVenta->precio - $detalleVenta->ganancias);

		$producto = Producto::find($detalleVenta->producto_id);

		$totalDetalle = $precioCostoDetalleVenta * $detalleVenta->cantidad;
		$totalInventario = $producto->existencia * $producto->p_costo;

		$existenciaNueva = $detalleVenta->cantidad + $producto->existencia;
		$totalInventarioNuevo = $totalDetalle + $totalInventario;

		$precioCostoNuevo = $totalInventarioNuevo / $existenciaNueva;

		$producto->p_costo = $precioCostoNuevo;
		$producto->save();

		$existenciaTienda = Existencia::whereProductoId($detalleVenta->producto_id)
		->whereTiendaId(Auth::user()->tienda_id)->first();

		$existenciaTienda->existencia += $detalleVenta->cantidad;

		$existenciaTienda->save();
	}

	public function UpdateDetalle()
	{
		if ( Input::get('field') == 'precio' ) {
			$this->recalcularPrecioCosto(Input::get('values.id'));

			$precio = str_replace(',', '', Input::get('values.precio'));
			$precio = preg_replace('/\s{2,}/', ' ', $precio);

	        $query = Producto::find(Input::get('values.producto_id'));
	        $ganancias = $precio - ( $query->p_costo );
			$detalleVenta = DetalleVenta::find( Input::get('values.id') );
			$detalleVenta->precio = Input::get('values.precio');
			$detalleVenta->ganancias = $ganancias;

			$existencia= Existencia::whereProductoId($query->id)
			->whereTiendaId(Auth::user()->tienda_id)->first();
			$existencia->existencia -= $detalleVenta->cantidad;
			$existencia->save();
			$detalleVenta->save();

			return $this->returnDetail();
		}

		if ( Input::get('values.cantidad') < 1 )
			return 'La cantidad deve ser mayor a 0';

		$serarchCantidad = DetalleVenta::find(Input::get('values.id'));

		$cantidad =  (Input::get('values.cantidad') - $serarchCantidad->cantidad);
		$nueva_existencia = $this->check_inventory( Input::get('values.producto_id'), $cantidad );

		if ($nueva_existencia === false)
			return "La cantidad que esta ingresando es mayor a la existencia..";

		$this->recalcularPrecioCosto(Input::get('values.id'));
		$nueva_existencia = $this->check_inventory( Input::get('values.producto_id'), Input::get('values.cantidad') );

		$detalleVenta = DetalleVenta::find(Input::get('values.id'));
		$producto = Producto::find(Input::get('values.producto_id'));

		$ganancias = $detalleVenta->precio - ($producto->p_costo);
		$detalleVenta->ganancias = $ganancias;
		$detalleVenta->cantidad = Input::get('values.cantidad');
		$detalleVenta->save();

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

	public function ingresarSeriesDetalleVenta()
	{
		if (Input::get('guardar') == true) {
			Input::merge(array('serials' => str_replace("'", '', Input::get('serials'))));
			$detalle_venta = DetalleVenta::find(Input::get('detalle_venta_id'));
			$detalle_venta->serials = Input::get('serials') ;
			$detalle_venta->save();

			return Response::json(array('success' => true));
		}

		$detalle_venta = DetalleVenta::find(Input::get('detalle_venta_id'));
		$serials = explode(',', $detalle_venta->serials );

		if (trim($detalle_venta->serials) == null )
			$serials = [];

		return Response::json(array(
			'success' => true,
			'view'   => View::make('ventas.ingresarSeriesDetalleVenta', compact('serials'))->render()
        ));
	}

	public function getVentasPedientesDePago()
	{
		$saldo_total = Venta::whereTiendaId(Auth::user()->tienda_id)->whereCompleted(1)
        ->where('saldo','>', 0 )->first(array(DB::Raw('sum(saldo) as total')));

        $saldo_vencido = DB::table('ventas')
        ->select(DB::raw('sum(ventas.saldo) as total'))
        ->join('clientes', 'cliente_id', '=', 'clientes.id')
        ->where('saldo','>',0)
        ->whereCompleted(1)
        ->where(DB::raw('DATEDIFF(current_date, ventas.created_at)'),'>=','30')
        ->whereTiendaId(Auth::user()->tienda_id)->first();

         $tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

		$infoSaldosTotales = "Saldo total &nbsp;".f_num::get($saldo_total->total)."{$tab}Saldo vencido &nbsp;".f_num::get($saldo_vencido->total);
		$tienda_id = Auth::user()->tienda_id;

		$ventas = DB::table('clientes')
        	->select(DB::raw("
        		MIN(ventas.created_at) as fecha,
        		clientes.id as cliente_id,
        		clientes.nombre as cliente,
        		clientes.direccion as direccion,
        		clientes.telefono as telefono,
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
	        ->orderBy('ventas.created_at','asc')
	        ->groupBy('cliente_id')
	        ->get();

		return Response::json(array(
			'success' => true,
			'table' => View::make('ventas.getVentasPedientesDePago', compact('ventas'))->render(),
			'infoSaldosTotales' => $infoSaldosTotales
        ));

	}

	public function getSumaDeVentasPorCliente()
	{
		$clientes = DB::table('ventas')
        ->select(
            DB::raw("sum(ventas.total) as total"),
            "clientes.nombre as cliente",
            "clientes.direccion as direccion")
        ->join('clientes', 'clientes.id', '=', 'ventas.cliente_id')
        ->whereTiendaId(Auth::user()->tienda_id)
        ->orderBy('total', 'DESC')
        ->groupBy('cliente_id')
        ->take(100)
        ->get();

        return Response::json(array(
            'success' => true,
            'table' => View::make('ventas.sumaDeVentasPorCliente', compact('clientes'))->render(),
        ));

	}

	public function getVentasPedientesPorUsuario()
	{
		$tienda_id = Auth::user()->tienda_id;

		$ventas = DB::table('users')
        	->select(DB::raw("
        		MIN(ventas.created_at) as fecha,
        		users.id as user_id,
        		CONCAT_WS(' ',users.nombre,users.apellido) as usuario,
        		tiendas.direccion as tienda,
        		sum(ventas.total) as total,
        		sum(ventas.saldo) as saldo_total,
        		(select sum(saldo) from ventas where
        			tienda_id = {$tienda_id} AND completed = 1 AND
        			DATEDIFF(current_date, created_at) >= 30
        			AND user_id = users.id) as saldo_vencido
        		"))
	        ->join('ventas', 'ventas.user_id', '=', 'users.id')
	        ->join('clientes', 'clientes.id', '=', 'ventas.cliente_id')
	        ->join('tiendas', 'tiendas.id', '=', 'users.tienda_id')
	        ->where('ventas.saldo', '>', 0)
	        ->where('ventas.completed', '=', 1)
	        ->where('ventas.tienda_id', '=', Auth::user()->tienda_id)
	        ->orderBy('ventas.created_at','asc')
	        ->groupBy('user_id')
	        ->get();

		return Response::json(array(
			'success' => true,
			'table' => View::make('ventas.VentasPedientesPorUsuario', compact('ventas'))->render()
        ));
	}

	public function getDetalleVentasPendientesPorUsuario()
	{
		if (Input::has('dt'))
		{
			$table = 'ventas';

	        $columns = array(
	            "ventas.created_at as fecha_ingreso",
	            "clientes.nombre as cliente",
	            "ventas.total as total",
	            "ventas.saldo as saldo",
	            "DATEDIFF(current_date,ventas.created_at) as dias"
	        );

	        $Search_columns = array("clientes.nombre","ventas.created_at","ventas.total" ,"ventas.saldo");

	        $Join = "JOIN clientes ON (clientes.id = ventas.cliente_id) ";

	        $where  = " ventas.tienda_id = ".Auth::user()->tienda_id;
	        $where  = " ventas.saldo > 0 ";
	        $where .= " AND ventas.user_id = ".Input::get('user_id');

			return TableSearch::get($table, $columns, $Search_columns, $Join, $where );
		}

        return Response::json(array(
            'success' => true,
            'table'   => View::make('ventas.getVentasPendientesPorUsuario')->render()
        ));

	}

	public function getVentasPendientesPorCliente()
	{
		if (Input::has('dt'))
		{
			$table = 'ventas';

			$columns = array(
				"ventas.created_at as fecha",
				"CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
				"total",
				"saldo",
				"DATEDIFF(current_date,ventas.created_at) as dias"
			);

			$Search_columns = array("users.nombre","users.apellido","ventas.total",'ventas.created_at');
			$where  = " ventas.tienda_id = ".Auth::user()->tienda_id;
			$where .= " AND ventas.saldo > 0 AND ventas.cliente_id = ".Input::get('cliente_id');
			$Join = " JOIN users ON (users.id = ventas.user_id) ";

			return TableSearch::get($table, $columns, $Search_columns, $Join, $where );

		}

        return Response::json(array(
            'success' => true,
            'table'   => View::make('ventas.getVentasPendientesPorCliente')->render()
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

	public function getDetalleVentasPorHoraUsuario()
	{
		$fecha = Input::get('fecha');

		$ventas =  Venta::with('cliente')
            ->whereTiendaId(Auth::user()->tienda_id)
            ->whereUserId(Input::get('user_id'))
            ->whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m-%d %H') = DATE_FORMAT('{$fecha}', '%Y-%m-%d %H')")
            ->get();

        return Response::json(array(
            'success' => true,
            'table' => View::make('ventas.detalleVentasPorHoraUsuario', compact('ventas'))->render(),
        ));
	}

	public function getVentasPorHoraPorUsuario()
	{
		$fecha = Input::get('fecha');

		$ventas =  DB::table('users')
            ->select(DB::raw('users.id as id,
            	detalle_ventas.created_at as fecha,
            	CONCAT_WS(" ", users.nombre, users.apellido) as usuario,
                sum(detalle_ventas.cantidad * detalle_ventas.precio) as total,
                sum(detalle_ventas.cantidad * detalle_ventas.ganancias) as utilidad'))
            ->join('ventas', 'ventas.user_id', '=', 'users.id')
            ->join('detalle_ventas', 'detalle_ventas.venta_id', '=', 'ventas.id')
            ->where('users.tienda_id', '=',Auth::user()->tienda_id)
            ->whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m-%d %H') = DATE_FORMAT('{$fecha}', '%Y-%m-%d %H')")
            ->orderBy('total', 'DESC')
            ->groupBy('users.id', 'users.nombre', 'users.apellido')
            ->get();

        $cliente = "Usuario";

		return Response::json(array(
			'success' => true,
			'table' => View::make('ventas.getVentasPorHoraPorUsuario', compact('ventas', 'cliente', 'fecha'))->render(),
        ));
	}

	public function getActualizarPagosVentaFinalizada()
	{
		$venta = Venta::find(Input::get('venta_id'));
		$metodo_pago = MetodoPago::select('id','descripcion')->where('id', '<=', 5)->get();

		return Response::json(array(
			'success' => true,
			'view' => View::make('ventas.ActualizarPagosVentaFinalizada', compact('venta', 'metodo_pago'))->render()
		));
	}

	public function actualizarPagosVentaFinalizada()
	{
		PagosVenta::whereVentaId(Input::get('venta.id'))->delete();
		$credito = 0 ;

		foreach (Input::get('pagos') as $dp) {
			$pagos = new PagosVenta;
			$pagos->venta_id = Input::get('venta.id');
			$pagos->monto = $dp['monto'];
			$pagos->metodo_pago_id = $dp['metodo_pago_id'];
			$pagos->save();
			if($dp['metodo_pago_id'] == 2)
				$credito =  $dp['monto'];
		}

		DB::table('ventas')->where('id', Input::get('venta.id'))->update(array('saldo' => $credito));

		return Response::json(array(
			'success' => true
		));
	}

	public function printTest()
	{
		return View::make('ventas.printTest');
	}

}

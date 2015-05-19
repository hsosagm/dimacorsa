<?php

class CompraController extends \BaseController {

	public function create()
	{
		if (Input::has('_token'))
		{
			$compra = new Compra;

			if (!$compra->create_master())
			{
				return $compra->errors();
			}

			$id = $compra->get_id();
			
			$compra = Compra::find($id);
			$proveedor = Proveedor::find($compra->proveedor_id);
			$contacto = ProveedorContacto::where('proveedor_id','=',$proveedor->id)->first();
			$saldo = $this->TotalCreditoProveedor($proveedor->id);
			
			return Response::json(array(
				'success' => true, 
				'detalle' => View::make('compras.detalle',compact("id"))->render(),
				'info_head' => View::make('compras.info_compra',compact('compra','proveedor','contacto','saldo'))->render()
				));
		}

		return View::make('compras.create');
	} 

	public function OpenModalPurchaseInfo()
	{

		if (Input::has('_token'))
		{
			$id = Input::get('id');
	    	$compra = Compra::find(Input::get('id'));

			if ( $compra->update_master() )
			{
				$compra = Compra::find($id);
				$proveedor = Proveedor::find($compra->proveedor_id);
				$contacto = ProveedorContacto::where('proveedor_id','=',$proveedor->id)->first();
				$saldo = $this->TotalCreditoProveedor($proveedor->id);

		       return Response::json(array(
				'success' => true, 
				'info_head' => View::make('compras.info_compra',compact('compra','proveedor','contacto','saldo'))->render()
				));
			}
			else
			{
			    return $compra->errors();
			}
    	}

    	$compra = Compra::find(Input::get('id'));
    	$proveedor = Proveedor::find($compra->proveedor_id);

        return View::make('compras.edit_info',compact('compra','proveedor'))->render();
	}

	public function DeletePurchaseDetailsItem()
	{
		DetalleCompra::destroy(Input::get('id'));

		return 'success';
	}

	public function DeletePurchaseInitial()
	{
		$detalle_abono = ProveedorAbonosDetalle::where('compra_id','=',Input::get('id'))->get();

		foreach ($detalle_abono as $key => $dato) 
		{
			$abono = ProveedorAbonos::find($dato->prov_abono_id);

			$abono->delete();
		}

		$compra = Compra::find(Input::get('id'));

		$compra->delete();

		return 'success';
	}

	public function detalle()
	{
		if (Input::has('_token'))
		{
			$codigo = DetalleCompra::where('compra_id','=',Input::get("compra_id"))
			->where('producto_id','=',Input::get("producto_id"))->get();

			if($codigo != "[]")
			{
				return "El codigo ya ha sido ingresado..";
			}

			$query = new DetalleCompra;
			
			if (!$query->_create())
			{
				return $query->errors();
			}

			$detalle = $this->TablePurchaseDetails();

			return Response::json(array(
				'success' => true,
				'table'   => View::make('compras.detalle_body', compact("detalle"))->render()
				));
		}

		return false;
	}

	//para eliminar compra ya finalizada y restablecer los precios costo
	function DeletePurchase()
	{
		return ProcesarCompra::delete(Input::get('compra_id'));
	}

	function DeletePurchaseShipping()
	{
		$detalle = Flete::destroy(Input::get('id'));

		return 'success';
	}

	public function FinishInitialPurchase()
	{
		ProcesarCompra::set(Input::get('compra_id'));

		return 'success';
	}

	public function OpenModalPurchaseItemSerials()
	{
		$data = explode(",", Input::get('serial'));;

		return View::make('compras.serial', compact('data'));
	}

	public function OpenModalPurchasePayment()
	{
		$detalle_compra = DetalleCompra::where('compra_id','=', Input::get('compra_id'))->get();

		if (count($detalle_compra) <= 0 )
			return 'no a ingresado productos a la factura...!';

		$det_pagos = $this->TableDetailsPayments(Input::get('compra_id'));
		$total_abono  = $this->TotalPurchasePayment(Input::get('compra_id'));
		$total_compra = $this->TotalPurchase(Input::get('compra_id'));
		$flete = Flete::where('compra_id',"=",Input::get('compra_id'))->first();

		$desabilitar = ''; $value_submit ='Ingresar Abono'; 
		$funcion_submit = ''; $tipo = 'submit';

		if(($total_compra - $total_abono )<= 0)
		{
			$desabilitar = 'disabled';
			$value_submit = 'Finalizar Compra';
			$funcion_submit = 'FinishInitialPurchase();';
			$tipo = 'button';
		}

		return Response::json(array(
			'success' => true, 
			'detalle' => View::make('compras.pagos',compact('flete','det_pagos','total_abono','total_compra','desabilitar','value_submit','funcion_submit','tipo'))
			->render()
			));
	}

	public function SavePurchasePayment()
	{	
		$values = trim(Input::get('monto'));
		$values = preg_replace('/\s{2,}/', ' ', $values);
		$total_restante = $this->TotalPurchase(Input::get('compra_id')) - $this->TotalPurchasePayment(Input::get('compra_id'));

		if ($this->SeachPaymentMethod(Input::get('compra_id'),Input::get('metodo_pago_id')) != '[]') 
			return 'no puede ingresar dos pagos con el mismo metodo..!';

		if($total_restante < $values)
			return 'El moto ingresado no puede ser mayor al monto Restante..!';

		if ($values == "" )
			return 'el monto es obligatorio';

		$metodoPago = MetodoPago::find(Input::get('metodo_pago_id'));
		$monto = $values;

		if($metodoPago->descripcion == 'Credito')
		{
			$compra = Compra::find( Input::get('compra_id'));
			$compra->saldo = $compra->saldo + $monto;
			$compra->save();
			$monto = 0.00;
		}

		if($metodoPago->descripcion == 'Flete')
		{
			if (Flete::where('compra_id','=',Input::get('compra_id'))->get() != '[]') 
				return 'el Flete ya ha sido ingresado..!';
		
			$this->SavePurchaseShipping($monto);

			return Response::json( array('success' => true ));
		}

		$this->SavePurchasePaymentItem($monto);

		return Response::json( array('success' => true ));
	}

	public function SavePurchaseShipping($monto)
	{
		$flete = new Flete;
		$flete->compra_id = Input::get('compra_id');
		$flete->monto = $monto;
		$flete->nota = Input::get('nota');
		$flete->save();
	}

	public function SavePurchasePaymentItem($monto)
	{
		$abono = ProveedorAbonos::create(array(
			'user_id' => Auth::user()->id ,
			'metodo_pago_id' => Input::get('metodo_pago_id'),
			'proveedor_id' => Input::get('proveedor_id'),
			'monto' => $monto
			));

		$prov_abono_id = $abono->id;

		$detalle = new ProveedorAbonosDetalle;
		$detalle->prov_abono_id = $prov_abono_id;
		$detalle->compra_id = Input::get('compra_id');
		$detalle->monto = Input::get('monto');
		$detalle->nota = Input::get('nota');
		$detalle->save();
	}

	public function DeletePurchasePaymentItem()
	{
		$detalle = ProveedorAbonosDetalle::find(Input::get('id'));
		$abono = ProveedorAbonos::destroy($detalle->prov_abono_id);

		return Response::json( array(
			'success' => true,
			'detalle' => $this->TableDetailsPayments($detalle->compra_id)
			));
	}

	public function SaveEditPurchaseItemDetails()
	{
		$datos = array( Input::get('tipo_dato') => Input::get('dato'));
		$validaciones = array( Input::get('tipo_dato') => array('required','numeric','min:1'));
		$validator = Validator::make($datos, $validaciones);

		if ( $validator->fails() )
		{
			return $validator->messages()->first();
		}

		$procesar = ProcesarCompra::EditarDetalleCompra(Input::get('detalle_id'),Input::get('tipo_dato'),Input::get('dato'));
		$detalle = $this->TablePurchaseDetails();

		return Response::json(array(
			'success' => $procesar,
			'table'   => View::make('compras.detalle_body', compact("detalle"))->render()
			));
	}

	public function SeachPaymentMethod($compra_id , $metodo_pago)
	{
		$query = ProveedorAbonosDetalle::join('prov_abonos','prov_abonos.id','=','prov_abonos_detalle.prov_abono_id')
		->where('compra_id','=', $compra_id)
		->where('metodo_pago_id','=', $metodo_pago)
		->get();

		return $query;
	}

	public function TotalPurchase($compra_id)
	{
		$total = DetalleCompra::select(DB::Raw('sum(cantidad * precio) as total'))
		->where('compra_id','=', $compra_id)->first();

		return $total->total;
	}

	public function TotalPurchasePayment($compra_id)
	{
		$total = ProveedorAbonosDetalle::select(DB::Raw('sum(monto) as total'))
		->where('compra_id','=', $compra_id)->first();

		return $total->total;
	}

	public function TotalCreditoProveedor($proveedor_id)
    {
        $total = Compra::select(DB::Raw('sum(saldo) as total'))
        ->where('proveedor_id','=', $proveedor_id)
        ->where('saldo','>', 0 )->first();

        return $total->total;
    }

	public function TablePurchaseDetails()
	{
		$query = DB::table('detalle_compras')
		->select(array('detalle_compras.id as id','compra_id', 'producto_id', 'cantidad', 'precio', DB::raw('CONCAT(productos.descripcion, " ", marcas.nombre) AS descripcion, cantidad * precio AS total') ))
		->where('compra_id', Input::get("compra_id"))
		->join('productos', 'detalle_compras.producto_id', '=', 'productos.id')
		->join('marcas', 'productos.marca_id', '=', 'marcas.id')
		->get();

		return $query;		
	}

	function TableDetailsPayments($compra_id)
	{
		$pagos = ProveedorAbonosDetalle::select('prov_abonos_detalle.id as id','prov_abonos_detalle.monto as monto','metodo_pago.descripcion as metodo')
		->where('compra_id','=', $compra_id)
		->join('prov_abonos', 'prov_abonos_detalle.prov_abono_id', '=', 'prov_abonos.id')
		->join('metodo_pago', 'prov_abonos.metodo_pago_id', '=', 'metodo_pago.id')->get();

		return $pagos;
	}
	
}	

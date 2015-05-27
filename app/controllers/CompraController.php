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

	public function ConsultPurchase()
	{
		return View::make('compras.ConsultPurchase');
	}

	public function OpenTablePurchaseDay()
	{
		return View::make('compras.PurchaseDay');
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
		$credito = PagosCompra::join('metodo_pago','pagos_compras.metodo_pago_id','=','metodo_pago.id')
		->where('descripcion','=','Credito')->where('compra_id','=',Input::get('compra_id'))->first();

		$total_compra = $this->TotalPurchase();

		ProcesarCompra::set(Input::get('compra_id'),"nota",$credito->monto, $total_compra);

		return 'success';
	}

	public function OpenModalPurchaseItemSerials()
	{
		$data = explode(",", Input::get('serial'));;

		return View::make('compras.serial', compact('data'));
	}

	public function ModalPurchasePayment()
	{

		if (Input::has('_token'))
		{
			if ($this->SeachPaymentMethod() != null ) 
				return 'no puede ingresar dos pagos con el mismo metodo..!';

			if(($this->TotalPurchase() - $this->TotalPurchasePayment()) < Input::get("monto"))
				return 'El moto ingresado no puede ser mayor al monto Restante..!';

			$pagos = new PagosCompra;

			if (!$pagos->_create()) 
			{
				$pagos->errors();
			}

			return	$this->PurchasePaymentDetail();
		}

		$detalle_compra = DetalleCompra::where('compra_id','=', Input::get('compra_id'))
		->first(array(DB::Raw('sum(cantidad * precio) as total')));

		if ($detalle_compra->total == null)
			return 'no a ingresado productos a la factura...!';

		$pagos = PagosCompra::where('compra_id','=',Input::get('compra_id'));
		$pagos->delete();

		$total_compra = number_format($detalle_compra->total, 2, '.', '');

		return Response::json(array(
			'success' => true, 
			'detalle' => View::make('compras.payment',compact('total_compra'))
			->render()
			));
	}

	public function PurchasePaymentDetail()
	{	
		$total_pagos = number_format($this->TotalPurchasePayment(), 2, '.', '');
		$total_compra = number_format($this->TotalPurchase(), 2, '.', '');
		$det_pagos    = $this->TableDetailsPayments();

		return Response::json( array(
			'success' => true,
		    'detalle' => View::make('compras.payment',compact('total_pagos','total_compra','det_pagos'))->render() 
		  ));
		
	}

	//funcion para eliminar un detalle de pago
	public function DeletePurchasePaymentItem()
	{
		$detalle = PagosCompra::destroy(Input::get('id'));

		return $this->PurchasePaymentDetail();
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

	//funcion para verificar si ya se ingreso un pago con ese metodo
	public function SeachPaymentMethod()
	{
		$query = PagosCompra::where('compra_id','=', Input::get('compra_id'))
		->where('metodo_pago_id','=', Input::get('metodo_pago_id'))
		->first();

		return $query;
	}

	public function TotalPurchase()
	{
		$total = DetalleCompra::select(DB::Raw('sum(cantidad * precio) as total'))
		->where('compra_id','=', Input::get('compra_id'))->first();

		return $total->total;
	}

	public function TotalPurchasePayment()
	{
		$total = PagosCompra::select(DB::Raw('sum(monto) as total'))
		->where('compra_id','=', Input::get('compra_id'))->first();

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

	function TableDetailsPayments()
	{
		$pagos = PagosCompra::where('compra_id','=', Input::get('compra_id'))->get();
		return $pagos;
	}
	
}	

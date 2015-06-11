<?php

public function OpenModalPurchasePayment()
	{
		$detalle_compra = DetalleCompra::where('compra_id','=', Input::get('compra_id'))
		->first(array(DB::Raw('sum(cantidad * precio) as total')));

		if ($detalle_compra->total == null)
			return 'no a ingresado productos a la factura...!';
		
		$flete = Flete::where('compra_id',"=",Input::get('compra_id'))->first();
		$pagos_compra_id = DetallePagosCompra::where('compra_id','=',Input::get('compra_id'))->first();
		$compra = Compra::find(Input::get('compra_id'));
		$det_pagos    = $this->TableDetailsPayments(Input::get('compra_id'));
		$total_abono  = $this->TotalPurchasePayment(Input::get('compra_id'))+$compra->saldo;
		$total_compra = $detalle_compra->total;
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
			'detalle' => View::make('compras.pagos',compact('flete','det_pagos','total_abono','total_compra','desabilitar','value_submit','funcion_submit','tipo','pagos_compra_id','compra'))
			->render()
			));
	}


	ublic function SavePurchasePayment()
	{	
		$values = trim(Input::get('monto'));
		$values = preg_replace('/\s{2,}/', ' ', $values);
		$total_restante = $this->TotalPurchase(Input::get('compra_id')) - $this->TotalPurchasePayment(Input::get('compra_id'));

		if ($this->SeachPaymentMethod(Input::get('compra_id'),Input::get('metodo_pago_id')) != null ) 
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
		}

		if($metodoPago->descripcion == 'Flete')
		{
			if (Flete::where('compra_id','=',Input::get('compra_id'))->first() != null) 
				return 'el Flete ya ha sido ingresado..!';
		
			$this->SavePurchaseShipping($monto);

			return Response::json( array('success' => true ));
		}
		if(Input::get('pagos_compra_id')>0)
		{
			$pagos_compra_id = Input::get('pagos_compra_id');
		}

		else
		{
			$pagos_compra_id = $this->SavePurchasePaymentInitial();
		}

		$this->SavePurchasePaymentItem($monto , $pagos_compra_id);

		return Response::json( array('success' => true ));
	}

	/*
	                @if(@$flete != '')
                <tr> 
                    <td width="65%"> Flete </td>
                    <td width="30%" align="right"> {{@$flete->monto}} </td>
                    <td width="10%">
                        <i class="fa fa-times pointer btn-link theme-c" href="admin/compras/DeletePurchaseShipping" id="{{@$flete->id}}" onClick="DeleteDetalle(this);"></i>
                    </td>
                </tr> 
                @endif
	*/
<?php

class PurchasePaymentsController extends \BaseController {

	public function delete()
	{
		$detalle = DetalleAbonosCompra::where('abonos_compra_id','=',Input::get('id'))->get();

        foreach ($detalle as $key => $dt) 
        {
            $this->ReturnBalancePurchase($dt->compra_id , $dt->monto);
        }

        AbonosCompra::destroy(Input::get('id'));

        return 'success';
	}

	public function formPayment()
	{
		$saldo_vencido = $this->OverdueBalance();
		$saldo_total   = $this->FullBalance();

		$users = User::paginate(10);

		return Response::json(array(
			'success' => true,
			'form' => View::make('compras.payments.formPayments', compact('saldo_total', 'saldo_vencido', 'users'))->render()
		));
	}

	public function formPayments()
	{
		if (Input::has('_token'))
		{
            $compras = Compra::where('proveedor_id', Input::get('proveedor_id'))
            ->where('saldo', '>', 0)
            ->where('tienda_id', '=', Auth::user()->tienda_id)
            ->orderBy('created_at', 'ASC')
            ->get();

            if (!count($compras) ) {
                return Response::json('El saldo de este proveedor se encuentra en 0.00');
            }

			$abonosCompra = new AbonosCompra;

			if (!$abonosCompra->create_master())
			{
				return $abonosCompra->errors();
			}

			$abonos_compra_id = $abonosCompra->get_id();

            $monto = Input::get('monto');

			foreach ($compras as $compra) 
			{
				$detalleAbono = new DetalleAbonosCompra;
			    $detalleAbono->abonos_compra_id = $abonos_compra_id;
			    $detalleAbono->compra_id = $compra->id;

				if ($monto > $compra->saldo)
				{
				    $monto = $monto - $compra->saldo;
				    $detalleAbono->monto = $compra->saldo;
				    $compra->saldo = 0;
				    $detalleAbono->save();
				    $compra->save();
				}
				else
				{
					$detalleAbono->monto = $monto;
					$compra->saldo = $compra->saldo - $monto;
					$detalleAbono->save();
					$compra->save();

			        $detalle = $this->BalanceDetails($abonos_compra_id);
			        $comprobante = DB::table('printer')->select('impresora')
					->where('tienda_id',Auth::user()->tienda_id)->where('nombre','comprobante')->first();
			        return Response::json(array(
			            'success' => true,
			            'detalle' => View::make('compras.payments.paymentsDetails', compact("detalle", 'abonos_compra_id', 'comprobante'))->render()
			        ));
				}
			}
			    $detalle = $this->BalanceDetails($abonos_compra_id);
			     $comprobante = DB::table('printer')->select('impresora')
					->where('tienda_id',Auth::user()->tienda_id)->where('nombre','comprobante')->first();
		        return Response::json(array(
		            'success' => true,
		            'detalle' => View::make('compras.payments.paymentsDetails', compact("detalle", 'abonos_compra_id', 'comprobante'))->render()
		        ));
		}

		$proveedor_id = Input::get('proveedor_id');

        $data =  $this->TotalCredito();
        $saldo_vencido = $data['saldo_vencido'];
        $saldo_total = $data['saldo_total'];
        
        return Response::json(array(
            'success' => true,
            'form' => View::make('compras.payments.formPayments', compact('saldo_total', 'saldo_vencido', 'proveedor_id'))->render()
        ));
	}


	public function formPaymentsPagination()
	{
		$table = 'compras';

		$columns = array(
			"compras.id", 
			"compras.created_at as fecha", 
			"CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
			"CONCAT_WS(' ',proveedores.nombre) as proveedor",
			"numero_documento",
			"saldo",
			"total"
		);

		$Search_columns = array("users.nombre","users.apellido","numero_documento");

		$Join = "JOIN users ON (users.id = compras.user_id) JOIN proveedores ON (proveedores.id = compras.proveedor_id)";

		$where  = " proveedor_id = ". Input::get('proveedor_id') ." AND saldo > 0 ";
		$where .= " AND users.tienda_id = ".Auth::user()->tienda_id;
		$where .= " AND compras.completed = 1";

		$compras = SST::get($table, $columns, $Search_columns, $Join, $where );

		return Response::json(array(
			'success' => true,
			'table' => View::make('compras.payments.formPaymentsSST', compact('compras'))->render()
		));
	}

	public function OverdueBalance()
	{
		$query = DB::table('compras')
		->select(DB::raw('sum(saldo) as total'))
		->where('saldo','>',0)
		->where('completed','=',1)
		->where(DB::raw('DATEDIFF(current_date,fecha_documento)'),'>=',30)
		->where('tienda_id','=',Auth::user()->tienda_id)
		->where('proveedor_id','=',Input::get('proveedor_id'))->first();

		return $query->total;
	}

    //funcion para obtener el saldo total
	public function FullBalance()
	{
		$query = DB::table('compras')
		->select(DB::raw('sum(saldo) as total'))
		->where('completed','=',1)
		->where('saldo','>',0)
		->where('tienda_id','=',Auth::user()->tienda_id)
		->where('proveedor_id','=',Input::get('proveedor_id'))->first();

		return $query->total;
	}

	 //funcion para obtener el detalle de los pagos
    public function BalanceDetails($id_pago)
    {
        $query = DB::table('detalle_abonos_compra')
        ->select('compra_id','total','detalle_abonos_compra.monto',
        	'saldo',DB::raw('(saldo+detalle_abonos_compra.monto) as saldo_anterior'),
        	 DB::raw('metodo_pago.descripcion as metodo_pago'))
        ->join('compras','compras.id','=','detalle_abonos_compra.compra_id')
        ->join('abonos_compras','detalle_abonos_compra.abonos_compra_id','=','abonos_compras.id')
        ->join('metodo_pago','metodo_pago.id','=','abonos_compras.metodo_pago_id')
        ->where('abonos_compra_id','=',$id_pago)->get();

        return $query;
    }


    //funcion para eliminar el abono 
    public function eliminarAbono()
    {
        $detalle = DetalleAbonosCompra::where('abonos_compra_id','=',Input::get('abonos_compra_id'))->get();

        foreach ($detalle as $key => $dt) 
        {
            $this->ReturnBalancePurchase($dt->compra_id , $dt->monto);
        }
        AbonosCompra::destroy(Input::get('abonos_compra_id'));

        return 'success';
    }

    function ReturnBalancePurchase($compra_id , $monto)
    {
		$update = Compra::find($compra_id);
		$update->saldo = $update->saldo + $monto ;
		$update->save();
    }


    /* Seccion de Abonos Por Compra */

    public function abonosComprasPorSeleccion()
    {

		$ids_compra = explode(',', Input::get('array_ids_compras'));

    	if (empty(Input::get('array_ids_compras'))) 
    	{
    		return 'Seleccione almenos una compra para realizar esata accion';
    	}

    	$data = array('proveedor_id' => Input::get('proveedor_id'),
    				'metodo_pago_id' => Input::get('metodo_pago_id'),
					'monto' => Input::get('monto'),
					'observaciones' => Input::get('observaciones')  );

    	$abono = new AbonosCompra;

		if (!$abono->create_master($data)) 
		{   
			return $abono->errors();
		}

		$abonos_compra_id = $abono->get_id();
		$total = 0;

    	for ($i=0; $i < count($ids_compra) ; $i++) 
    	{ 
    		$compra = Compra::find($ids_compra[$i]);

            if (!$compra) {
            	return false;
            }

    		$total = $total + $compra->saldo;

			$data_detalle = array('compra_id' => $compra->id,
				'abonos_compra_id' => $abonos_compra_id,
				'monto' => $compra->saldo );

			$detalle = new DetalleAbonosCompra;

			if (!$detalle->_create($data_detalle)) 
			{
				return $detalle->errors();
			}
   				
   			$compra->saldo = 0.00 ;
			$compra->save();
    	}

    	$abono = AbonosCompra::find($abonos_compra_id);
    	$abono->monto = $total;
    	$abono->save();

    	$detalle = $this->BalanceDetails($abonos_compra_id);
    	 $comprobante = DB::table('printer')->select('impresora')
					->where('tienda_id',Auth::user()->tienda_id)->where('nombre','comprobante')->first();

    	return Response::json(array(
			'success' => true ,
			'detalle' => View::make('compras.payments.paymentsDetailsBySelection',compact("detalle",'abonos_compra_id','comprobante'))->render()
		));
    }
    public function TotalCredito()
    {
        $saldo_total = Compra::where('proveedor_id','=', Input::get('proveedor_id'))
        ->where('tienda_id','=',Auth::user()->tienda_id)
        ->where('saldo','>', 0 )->first(array(DB::Raw('sum(saldo) as total')));

        $saldo_vencido = DB::table('compras')
        ->select(DB::raw('sum(saldo) as total'))
        ->where('saldo','>',0)
        ->where(DB::raw('DATEDIFF(current_date,fecha_documento)'),'>=',30)
        ->where('tienda_id','=',Auth::user()->tienda_id)
        ->where('proveedor_id','=',Input::get('proveedor_id'))->first();

        return array('saldo_total' => $saldo_total->total , 'saldo_vencido' => $saldo_vencido->total );
    } 
 
}
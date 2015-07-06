<?php

class PurchasePaymentsController extends \BaseController {

	public function formPayments()
	{
		$saldo_vencido = $this->OverdueBalance();
		$saldo_total   = $this->FullBalance();

		$users = User::paginate(10);

		return Response::json(array(
			'success' => true,
			'form' => View::make('compras.payments.formPayments', compact('saldo_total', 'saldo_vencido', 'users'))->render()
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

		$where = " proveedor_id = ". Input::get('proveedor_id') ." AND saldo > 0 ";
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

      //funcion para pagar el saldo vencido
	public function OverdueBalancePay()
	{   
		$total_vencido = number_format($this->OverdueBalance(),2,'.','');

		if ($total_vencido <= 0) 
		{
			return 'El saldo vencido ya esta cancelado';	
		}

		$data = Input::all();
		$data['total'] = $total_vencido;

		$abono = new AbonosCompra;

		if (!$abono->create_master($data)) 
		{   
			return $abono->errors();
		}
		$abono_id = $abono->get_id();

		$compras = DB::table('compras')
		->where('completed','=',1)
		->where('saldo','>',0)
		->where(DB::raw('DATEDIFF(current_date,fecha_documento)'),'>=',30)
		->where('proveedor_id','=',Input::get('proveedor_id'))
		->where('tienda_id','=',Auth::user()->tienda_id)->get();

		foreach ($compras as $key => $dt) 
		{   
			$data_detalle = array('compra_id' => $dt->id,
				'abonos_compra_id' => $abono_id,
				'monto' => $dt->saldo );

			$detalle = new DetalleAbonosCompra;

			if (!$detalle->_create($data_detalle)) 
			{
				return $detalle->errors();
			}
		}

		DB::table('compras')
		->where('completed','=',1)
		->where('saldo','>',0)
		->where(DB::raw('DATEDIFF(current_date,fecha_documento)'),'>=',30)
		->where('proveedor_id','=',Input::get('proveedor_id'))
		->where('tienda_id','=',Auth::user()->tienda_id)
		->update(array('saldo'=>0));

		$detalle = $this->BalanceDetails($abono_id);

		return Response::json(array(
			'success' => true ,
			'detalle' => View::make('compras.payments.paymentsDetails',compact("detalle",'abono_id'))->render()
			));
	}

    //funcion para pagar todo el saldo
	public function FullBalancePay()
	{
		$total_saldo = number_format($this->FullBalance(),2,'.','');

		if ($total_saldo <= 0) 
		{
			return 'El saldo vencido ya esta cancelado';	
		}

		$data = Input::all();
		$data['total'] = $total_saldo;

		$abono = new AbonosCompra;

		if (!$abono->create_master($data)) 
		{   
			return $abono->errors();
		}
		$abono_id = $abono->get_id();

		$compras = DB::table('compras')
		->where('completed','=',1)
		->where('saldo','>',0)
		->where('proveedor_id','=',Input::get('proveedor_id'))
		->where('tienda_id','=',Auth::user()->tienda_id)
		->get();

		foreach ($compras as $key => $dt) 
		{   
			$data_detalle = array('compra_id' => $dt->id,
				'abonos_compra_id' => $abono_id,
				'monto' => $dt->saldo );

			$detalle = new DetalleAbonosCompra;

			if (!$detalle->_create($data_detalle)) 
			{
				return $detalle->errors();
			}
		}

		DB::table('compras')
		->where('completed','=',1)
		->where('saldo','>',0)
		->where('proveedor_id','=',Input::get('proveedor_id'))
		->where('tienda_id','=',Auth::user()->tienda_id)
		->update(array('saldo'=>0));

		$detalle = $this->BalanceDetails($abono_id);

		return Response::json(array(
			'success' => true ,
			'detalle' => View::make('compras.payments.paymentsDetails',compact("detalle",'abono_id'))->render()
			));

	}

	function PartialBalancePay()
	{
		$total_saldo = number_format($this->FullBalance(),2,'.','');

		$abono = new AbonosCompra;

		if (!$abono->create_master()) 
		{   
			return $abono->errors();
		}

		$abono_id = $abono->get_id();

		$monto = number_format(Input::get('total'),2,'.','');

		$compras = DB::table('compras')
		->where('completed','=',1)
		->where('saldo','>',0)
		->where('proveedor_id','=',Input::get('proveedor_id'))
		->where('tienda_id','=',Auth::user()->tienda_id)
		->orderBy('fecha_documento')->get();

		foreach ($compras as $key => $dt) 
		{
			if($dt->saldo <= $monto && $monto != 0 && $monto > 0)
			{
				$update = Compra::find($dt->id);
				$update->saldo = 0.00 ;
				$update->save();
				$monto = $monto - $dt->saldo;

				$data_detalle = array('compra_id' => $dt->id,
					'abonos_compra_id' => $abono_id,
					'monto' => $dt->saldo );

				$detalle = new DetalleAbonosCompra;

				if (!$detalle->_create($data_detalle)) 
				{
					return $detalle->errors();
				}
			}

			else if($dt->saldo > $monto && $monto != 0 && $monto > 0)
			{   
				$update = Compra::find($dt->id);
				$update->saldo = $dt->saldo - $monto;
				$update->save();

				$data_detalle = array('compra_id' => $dt->id,
					'abonos_compra_id' => $abono_id,
					'monto' => $monto );

				$detalle = new DetalleAbonosCompra;

				if (!$detalle->_create($data_detalle)) 
				{
					return $detalle->errors();
				}

				$monto = 0 ;
			}
		}

		$detalle = $this->BalanceDetails($abono_id);

		return Response::json(array(
			'success' => true ,
			'detalle' => View::make('compras.payments.paymentsDetails',compact("detalle",'abono_id'))->render()
			));
	}

	 //funcion para obtener el detalle de los pagos
    public function BalanceDetails($id_pago)
    {
        $query = DB::table('detalle_abonos_compra')
        ->select('compra_id','total','monto','saldo',DB::raw('(saldo+monto) as saldo_anterior'))
        ->join('compras','compras.id','=','detalle_abonos_compra.compra_id')
        ->where('abonos_compra_id','=',$id_pago)->get();

        return $query;
    }


    //funcion para eliminar el abono 
    public function DeleteBalancePay()
    {
        $detalle = DetalleAbonosCompra::where('abonos_compra_id','=',Input::get('id'))->get();

        foreach ($detalle as $key => $dt) 
        {
            $this->ReturnBalancePurchase($dt->compra_id , $dt->monto);
        }

        AbonosCompra::destroy(Input::get('id'));

        return 'success';
    }

    function ReturnBalancePurchase($compra_id , $monto)
    {
		$update = Compra::find($compra_id);
		$update->saldo = $update->saldo + $monto ;
		$update->save();
    }


    /* Seccion de Abonos Por Compra */

    public function SelectedPayPurchases()
    {
		$ids_compra = explode(',', Input::get('array_ids_compras'));

    	if (empty(Input::get('array_ids_compras'))) 
    	{
    		return 'Seleccione almenos una compra para realizar esata accion';
    	}

    	$data = array('proveedor_id' => Input::get('proveedor_id'),
    				'metodo_pago_id' => Input::get('metodo_pago_id'),
					'total' => 0.00 );

    	$abono = new AbonosCompra;

		if (!$abono->create_master($data)) 
		{   
			return $abono->errors();
		}

		$abono_id = $abono->get_id();
		$total = 0;

    	for ($i=0; $i < count($ids_compra) ; $i++) 
    	{ 
    		$compra = Compra::find($ids_compra[$i]);

    		$total = $total + $compra->saldo;

			$data_detalle = array('compra_id' => $compra->id,
				'abonos_compra_id' => $abono_id,
				'monto' => $compra->saldo );

			$detalle = new DetalleAbonosCompra;

			if (!$detalle->_create($data_detalle)) 
			{
				return $detalle->errors();
			}
   				
   			$compra->saldo = 0.00 ;
			$compra->save();
    	}

    	$abono = AbonosCompra::find($abono_id);
    	$abono->total = $total;
    	$abono->save();

    	$detalle = $this->BalanceDetails($abono_id);

    	return Response::json(array(
			'success' => true ,
			'detalle' => View::make('compras.payments.paymentsDetails',compact("detalle",'abono_id'))->render()
			));
    }
 
}
<?php

class SalesPaymentsController extends \BaseController {

	public function formPayments()
	{
		if (Session::token() == Input::get('_token'))
		{
			// return json_encode(Input::all());

		    $monto = Crypt::decrypt(Input::get('monto'));

		    Input::merge(array('monto' => $monto));

		    return json_encode(Input::all());

			$abonosVenta = new AbonosVenta;

			if (!$abonosVenta->create_master())
			{
				return $abonosVenta->errors();
			}

			$abonosVenta_id = $abonosVenta->get_id();

			return Response::json(array(
				'success' => true,
				'detalle' => View::make('ventas.detalle', compact('venta_id'))->render()
            ));
		}

		$cliente_id = Input::get('cliente_id');

        $query = DB::table('ventas')
        ->select(DB::raw("ventas.id, ventas.created_at as fecha, saldo"))
        ->where('saldo', '>', 0)
        ->where('cliente_id', $cliente_id)
        ->get();

        $saldo_total = 0;
        $saldo_vencido = 0;

        foreach ($query as $q) {
        	$saldo_total   = $saldo_total + $q->saldo;
            $fecha_entrada = date('Ymd', strtotime($q->fecha));
            $fecha_vencida = date('Ymd',strtotime("-30 days"));

            if ($fecha_entrada < $fecha_vencida) {
            	$saldo_vencido = $saldo_vencido + $q->saldo;
            }
        }

        $saldo_total = f_num::get($saldo_total);

        return Response::json(array(
            'success' => true,
            'form' => View::make('ventas.payments.formPayments', compact('saldo_total', 'saldo_vencido', 'cliente_id'))->render()
        ));
	}

	public function formPaymentsPagination()
	{
		$table = 'ventas';

		$columns = array(
			"ventas.id", 
			"ventas.created_at as fecha", 
			"CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
			"CONCAT_WS(' ',clientes.nombre,clientes.apellido) as cliente",
			"numero_documento",
			"saldo",
			"total"
			);

		$Search_columns = array("users.nombre","users.apellido","numero_documento");

		$Join = "JOIN users ON (users.id = ventas.user_id) JOIN clientes ON (clientes.id = ventas.cliente_id)";

		$where = " cliente_id = ". Input::get('cliente_id') ." AND saldo > 0";

		$ventas = SST::get($table, $columns, $Search_columns, $Join, $where );

        return Response::json(array(
            'success' => true,
            'table' => View::make('ventas.payments.formPaymentsSST', compact('ventas'))->render()
        ));
	}


    /* Seccion de Abonos Por Venta */

    public function SelectedPaySales()
    {
        $ids_venta = explode(',', Input::get('array_ids_ventas'));

        if (empty(Input::get('array_ids_ventas'))) 
        {
            return 'Seleccione almenos una compra para realizar esata accion';
        }

        $data = array('cliente_id' => Input::get('cliente_id'),
                    'metodo_pago_id' => Input::get('metodo_pago_id'),
                    'monto' => 0.00 );

        $abono = new AbonosVenta;

        if (!$abono->create_master($data)) 
        {   
            return $abono->errors();
        }

        $abono_id = $abono->get_id();
        $total = 0;

        for ($i=0; $i < count($ids_venta) ; $i++) 
        { 
            $venta = Venta::find($ids_venta[$i]);

            $total = $total + $venta->saldo;

            $data_detalle = array('venta_id' => $venta->id,
                'abonos_ventas_id' => $abono_id,
                'monto' => $venta->saldo );

            $detalle = new DetalleAbonosVenta;

            if (!$detalle->_create($data_detalle)) 
            {
                return $detalle->errors();
            }
                
            $venta->saldo = 0.00 ;
            $venta->save();
        }

        $abono = AbonosVenta::find($abono_id);
        $abono->monto = $total;
        $abono->save();

        $detalle = $this->BalanceDetails($abono_id);

        return Response::json(array(
            'success' => true ,
            'detalle' => View::make('ventas.payments.paymentsDetails',compact("detalle",'abono_id'))->render()
            ));
    }

    function BalanceDetails($id_pago)
    {
        $query = DB::table('detalle_abonos_ventas')
        ->select('venta_id','total','monto','saldo',DB::raw('(saldo+monto) as saldo_anterior'))
        ->join('ventas','ventas.id','=','detalle_abonos_ventas.venta_id')
        ->where('abonos_ventas_id','=',$id_pago)->get();

        return $query;
    }

     //funcion para eliminar el abono 
    public function DeleteBalancePay()
    {
        $detalle = DetalleAbonosVenta::where('abonos_ventas_id','=',Input::get('id'))->get();

        foreach ($detalle as $key => $dt) 
        {
            $this->ReturnBalanceSales($dt->venta_id , $dt->monto);
        }

        AbonosVenta::destroy(Input::get('id'));

        return 'success';
    }

    function ReturnBalanceSales($venta_id , $monto)
    {
        $update = Venta::find($venta_id);
        $update->saldo = $update->saldo + $monto ;
        $update->save();
    }
}
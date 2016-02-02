<?php

class SalesPaymentsController extends \BaseController {

	public function formPayments()
	{
		if (Session::token() == Input::get('_token'))
		{
            $ventas = Venta::where('cliente_id', Input::get('cliente_id'))
            ->where('saldo', '>', 0)
            ->orderBy('created_at', 'ASC')
            ->get();

            if (!count($ventas) ) {
                return Response::json('El saldo de este cliente se encuentra en 0.00');
            }

			$abonosVenta = new AbonosVenta;
            $caja = Caja::whereUserId(Auth::user()->id)->first();

            $data = Input::all();
            $data['caja_id'] = $caja->id;

			if (!$abonosVenta->create_master($data))
			{
				return $abonosVenta->errors();
			}

			$abonos_ventas_id = $abonosVenta->get_id();

            $monto = Input::get('monto');

			foreach ($ventas as $venta)
			{
				$detalleAbono = new DetalleAbonosVenta;
			    $detalleAbono->abonos_ventas_id = $abonos_ventas_id;
			    $detalleAbono->venta_id = $venta->id;

				if ($monto > $venta->saldo)
				{
				    $monto = $monto - $venta->saldo;
				    $detalleAbono->monto = $venta->saldo;
                    DB::table('ventas')->whereId($venta->id)->update(array('saldo' => 0));
				    $detalleAbono->save();
				}
				else
				{
					$detalleAbono->monto = $monto;
                    DB::table('ventas')->whereId($venta->id)->update( array('saldo' => ($venta->saldo - $monto)) );
					$detalleAbono->save();

			        $detalle = $this->BalanceDetails($abonos_ventas_id);
                    $comprobante = DB::table('printer')->select('impresora')
                    ->where('tienda_id',Auth::user()->tienda_id)->where('nombre','comprobante')->first();

			        return Response::json(array(
			            'success' => true,
			            'detalle' => View::make('ventas.payments.paymentsDetails', compact("detalle", 'abonos_ventas_id', 'comprobante'))->render()
			        ));
				}
			}
			
            $detalle = $this->BalanceDetails($abonos_ventas_id);

            $comprobante = DB::table('printer')->select('impresora')
            ->where('tienda_id',Auth::user()->tienda_id)->where('nombre','comprobante')->first();

		    return Response::json(array(
		       'success' => true,
		       'detalle' => View::make('ventas.payments.paymentsDetails', compact("detalle", 'abonos_ventas_id', 'comprobante'))->render()
		    ));
		}

		$cliente_id = Input::get('cliente_id');

        $query = DB::table('ventas')
        ->select(DB::raw("ventas.id, ventas.created_at as fecha, saldo"))
        ->where('saldo', '>', 0)
        ->where('cliente_id', $cliente_id)
        ->get();

        $dias_credito = Cliente::find($cliente_id)->dias_credito;
 
        $saldo_total = 0;
        $saldo_vencido = 0;

        foreach ($query as $q) {
        	$saldo_total   = $saldo_total + $q->saldo;
            $fecha_entrada = date('Ymd', strtotime($q->fecha));
            $fecha_vencida = date('Ymd',strtotime("-{$dias_credito} days"));

            if ($fecha_entrada < $fecha_vencida) {
            	$saldo_vencido = $saldo_vencido + $q->saldo;
            }
        }

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
			"clientes.nombre as cliente",
			"saldo",
			"total"
		);


		$Search_columns = array("users.nombre","users.apellido","ventas.id");

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
            return 'Seleccione almenos una venta para realizar esata accion';
        }

        $data = array('cliente_id' => Input::get('cliente_id'),
                    'metodo_pago_id' => Input::get('metodo_pago_id'),
                    'monto' => Input::get('monto') );

        $abono = new AbonosVenta;
        $caja = Caja::whereUserId(Auth::user()->id)->first();

        $data['caja_id'] = $caja->id;

        if (!$abono->create_master($data))
        {
            return $abono->errors();
        }

        $abonos_ventas_id = $abono->get_id();
        $total = 0;

        for ($i=0; $i < count($ids_venta) ; $i++)
        {
            $venta = Venta::find($ids_venta[$i]);

            if (!$venta) {
            	return false;
            }

            $total = $total + $venta->saldo;

            $data_detalle = array('venta_id' => $venta->id,
                'abonos_ventas_id' => $abonos_ventas_id,
                'monto' => $venta->saldo );

            $detalle = new DetalleAbonosVenta;

            if (!$detalle->_create($data_detalle))
            {
                return $detalle->errors();
            }

            DB::table('ventas')->whereId($venta->id)->update(array('saldo'=>0.00));
        }

        $abono = AbonosVenta::find($abonos_ventas_id);
        $abono->monto = $total;
        $abono->save();
        $m_pago = $abono->metodo_pago->descripcion;

        $detalle = $this->BalanceDetails($abonos_ventas_id);
        $comprobante = DB::table('printer')->select('impresora')
        ->where('tienda_id',Auth::user()->tienda_id)->where('nombre','comprobante')->first();

        return Response::json(array(
            'success' => true,
            'detalle' => View::make('ventas.payments.paymentsDetailsBySelection', compact("detalle", 'abonos_ventas_id', 'm_pago', 'comprobante'))->render()
        ));
    }

    function BalanceDetails($abonos_ventas_id)
    {
        $query = DB::table('detalle_abonos_ventas')
        ->select('venta_id', 'total', 'monto', 'saldo', DB::raw('(saldo+monto) as saldo_anterior'))
        ->join('ventas','ventas.id', '=', 'detalle_abonos_ventas.venta_id')
        ->where('abonos_ventas_id', '=', $abonos_ventas_id)->get();

        return $query;
    }
 
     //funcion para eliminar el abono
    public function eliminarAbonoVenta()
    {
        $detalle = DetalleAbonosVenta::where('abonos_ventas_id','=',Input::get('abonos_ventas_id'))->get();

        foreach ($detalle as $dt)
        {
            $venta = Venta::find($dt->venta_id);
            DB::table('ventas')->whereId($venta->id)->update( array('saldo'=>($venta->saldo + $dt->monto)) );   
        }

        AbonosVenta::destroy(Input::get('abonos_ventas_id'));

        return 'success';
    }

    function imprimirAbonoVenta()
    {
        $detalle = $this->BalanceDetails(Input::get('id'));

        $abonos_venta = AbonosVenta::with('cliente','user','metodoPago')->find(Input::get('id'));

        $saldo = Venta::where('cliente_id', '=' , $abonos_venta->cliente_id)->first(array(DB::raw('sum(saldo) as total')));

        $pdf = PDF::loadView('ventas.payments.ImprimirAbonoVenta',  array(
            'detalle' => $detalle, 'abonos_venta' => $abonos_venta, 'saldo' => $saldo))
        ->save("pdf/".Input::get('id').Auth::user()->id.'ac.pdf')->setPaper('letter');

        return Response::json(array(
            'success' => true,
            'pdf'   => Input::get('id').Auth::user()->id.'ac'
        ));
    }

	function imprimirAbonoVentaPdf()
    {
        $detalle = $this->BalanceDetails(Input::get('id'));

        $abonos_venta = AbonosVenta::with('cliente','user','metodoPago')->find(Input::get('id'));

        $saldo = Venta::where('cliente_id', '=' , $abonos_venta->cliente_id)->first(array(DB::raw('sum(saldo) as total')));

        $pdf = PDF::loadView('ventas.payments.ImprimirAbonoVenta', array('detalle' => $detalle, 'abonos_venta' => $abonos_venta, 'saldo' => $saldo))->setPaper('letter');

        return $pdf->stream();
    }

    public function getDetalleAbono()
    {
         $detalle = DB::table('detalle_abonos_ventas')
        ->select('venta_id','total','monto',DB::raw('detalle_abonos_ventas.created_at as fecha'))
        ->join('ventas','ventas.id','=','detalle_abonos_ventas.venta_id')
        ->where('abonos_ventas_id','=', Input::get('abono_id'))
        ->get();

        $deuda = 0;

        return Response::json(array(
            'success' => true,
            'table'   => View::make('ventas.payments.DT_detalle_abono', compact('detalle', 'deuda'))->render()
        ));
    }

}

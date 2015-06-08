<?php

class SalesPaymentsController extends \BaseController {

	public function formPayments()
	{
        $query = DB::table('ventas')
        ->select(DB::raw("ventas.id, ventas.created_at as fecha, saldo"))
        ->where('saldo', '>', 0)
        ->where('cliente_id', Input::get('cliente_id'))
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
        $saldo_vencido = f_num::get($saldo_vencido);

        $users = User::paginate(10);

        return Response::json(array(
            'success' => true,
            'form' => View::make('ventas.payments.formPayments', compact('saldo_total', 'saldo_vencido', 'users'))->render()
        ));
	}

	public function formPaymentsPagination()
	{
		$table = 'ventas';

		$columns = array(
			"ventas.created_at as fecha", 
			"CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
			"CONCAT_WS(' ',clientes.nombre,clientes.apellido) as cliente",
			"numero_documento",
			"saldo",
			"total"
			);

		$Search_columns = array("users.nombre","users.apellido","numero_documento");

		$Join = "JOIN users ON (users.id = ventas.user_id) JOIN clientes ON (clientes.id = ventas.cliente_id)";

		$where = '';

		$ventas = SST::get($table, $columns, $Search_columns, $Join, $where );

        return Response::json(array(
            'success' => true,
            'form' => View::make('ventas.payments.formPaymentsPagination', compact('ventas'))->render()
        ));
	}

}
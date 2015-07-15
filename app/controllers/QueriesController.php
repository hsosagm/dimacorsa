<?php 

class QueriesController extends \BaseController {

	public function getMasterQueries()
	{
		return Response::json(array(
			'success' => true,
			'view'    => View::make('queries.masterQueries')->render()
        ));
	}

	public function getVentasPorFecha()
	{
		return Response::json(array(
			'success' => true,
			'view'    => View::make('queries.ventasPorFecha')->render()
        ));
	}

	public function DtVentasPorFecha()
	{
        $table = 'ventas';

        $columns = array(
            "CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
            "ventas.created_at as fecha", 
            "ventas.id as idventa",
            "total",
            "saldo"
            );

        $Search_columns = array("users.nombre","users.apellido","ventas.id");

        $Join = "JOIN users ON (users.id = ventas.user_id)";

        $where = "ventas.cliente_id = ". Input::get('cliente_id');

        echo TableSearch::get($table, $columns, $Search_columns, $Join, $where );  
	}

}
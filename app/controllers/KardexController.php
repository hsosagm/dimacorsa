<?php

class KardexController extends \BaseController {

	public function getKardex()
	{
		$table = 'kardex';

        $columns = array(
            "kardex.created_at as fecha",
            "CONCAT_WS(' ',users.nombre,users.apellido) as usuario", 
            "kardex_transaccion.nombre as nombre", 
            "evento",
            "cantidad",
            "existencia",
            "costo",
            "costo_promedio"
        );

        $Search_columns = array("evento" , "cantidad" , 'existencia' ,'costo');

        $Join = "JOIN users ON (users.id = kardex.user_id) ";
        $Join .= "JOIN kardex_transaccion ON (kardex_transaccion.id = kardex_transaccion_id) ";

        $where  = " kardex.tienda_id =".Auth::user()->tienda_id;
        $where .= " AND kardex.producto_id =".Input::get('producto_id');

        $kardex = SST::get($table, $columns, $Search_columns, $Join, $where );

        return Response::json(array(
            'success' => true,
            'table'   => View::make('kardex.getKardex', compact('kardex'))->render()
        ));
	}
}
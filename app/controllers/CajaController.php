<?php

class CajaController extends \BaseController {

	public function create()
    {
        if (Input::has('_token'))
        {
            $caja = new Caja;

            if (!$caja->create())
            {
                return $caja->errors(); 
            }

            return 'success';
        }

        return View::make('cajas.create');
    }

	public function getConsultarCajas()
	{
		return View::make('cajas.consultarCajas');
	}

	public function DtConsultarCajas()
	{
		$table = 'cajas';

		$columns = array(
			"tiendas.nombre as tienda",
			"cajas.nombre as caja",
			"(select CONCAT_WS(' ',users.nombre,users.apellido) from users where cajas.id = caja_id) as usuario"
			);

		$Search_columns = array("cajas.nombre","tiendas.nombre");

		$Join = "JOIN tiendas ON (tiendas.id = cajas.tienda_id)";

		$where = "cajas.tienda_id =".Auth::user()->tienda_id;

		echo TableSearch::get($table, $columns, $Search_columns, $Join, $where );
	}
}
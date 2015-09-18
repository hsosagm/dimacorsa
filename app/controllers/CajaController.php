<?php

class CajaController extends \BaseController {

	public function create()
    {
        if (Input::has('_token'))
        {
            $cantidad_cajas = Caja::count();
            $tienda = Tienda::find(Auth::user()->tienda_id);

            if ($cantidad_cajas >= $tienda->limite_cajas) 
                return "no puede crear mas cajas porque exede la cantidad de cajas pagadas...!";

            $caja = new Caja;

            if (!$caja->_create())
            {
                return $caja->errors(); 
            }

            return 'success';
        }

        return View::make('cajas.create');
    }

    public function asignar()
    {
        if (Input::has('_token'))
        {
            $user = User::find(Auth::user()->id);
            $user->caja_id = Input::get('caja_id');
            $user->save();

            $caja = Caja::find(Input::get('caja_id'));

            return 'success';
        }

        return View::make('cajas.asignar');
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
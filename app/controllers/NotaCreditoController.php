<?php

class NotaCreditoController extends \BaseController {

	public function create()
    {
        if (Input::has('_token'))
        {
            Input::merge(array('monto' => str_replace(',', '', Input::get('monto'))));

            $notaCredito = new NotaCredito;

			if (!$notaCredito->create_master())
			{
				return $notaCredito->errors(); 
			}

			return 'success';
        }

        return View::make('notas_creditos.create');
    }

}
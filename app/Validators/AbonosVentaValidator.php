<?php namespace App\Validators;

use ValidatorAssistant, Input;

class AbonosVentaValidator extends ValidatorAssistant {

    protected $rules = array(
        'user_id'   	 =>  'required|integer|min:1',
        'tienda_id'		 =>  'required|integer|min:1',
        'cliente_id'	 =>  'required|integer|min:1',
        'metodo_pago_id' =>  'required|integer|min:1',
        'monto' 		 =>  'required|numeric',
    );
}

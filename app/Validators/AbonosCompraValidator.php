<?php namespace App\Validators;

use ValidatorAssistant;

class AbonosCompraValidator extends ValidatorAssistant {

    protected $rules = array(
        'user_id'   	 =>  'required|integer|min:1',
        'tienda_id'		 =>  'required|integer|min:1',
        'proveedor_id'	 =>  'required|integer|min:1',
        'metodo_pago_id' =>  'required|integer|min:1',
        'monto' 		 =>  'required|numeric|min:1',
    );
}

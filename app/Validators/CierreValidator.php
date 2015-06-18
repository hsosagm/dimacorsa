<?php namespace App\Validators;

use ValidatorAssistant;

class CierreValidator extends ValidatorAssistant {

    protected $rules = array(
        'efectivo' 	=>  'required|numeric',
        'cheque' 	=>  'required|numeric',
        'tarjeta' 	=>  'required|numeric',
        'deposito' 	=>  'required|numeric',
        'user_id'   =>  'required|integer|min:1',
        'tienda_id'	=>  'required|integer|min:1',
    );
}

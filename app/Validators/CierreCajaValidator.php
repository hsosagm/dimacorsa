<?php namespace App\Validators;

use ValidatorAssistant;

class CierreCajaValidator extends ValidatorAssistant {

    protected $rules = array(
        'fecha_inicial' =>  'required',
        'fecha_final'   =>  'required',
        'user_id'       =>  'required|integer|min:1',
        'tienda_id'     =>  'required|integer|min:1',
        'caja_id'	    =>  'required|integer|min:1',
    );
}

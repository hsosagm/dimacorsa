<?php namespace App\Validators;

use ValidatorAssistant;

class CierreCajaValidator extends ValidatorAssistant {

    protected $rules = array(
        'efectivo' 	    =>  'required|numeric',
        'cheque' 	    =>  'required|numeric',
        'tarjeta' 	    =>  'required|numeric',
        'deposito' 	    =>  'required|numeric',
        'efectivo_esp'  =>  'required|numeric',
        'cheque_esp' 	=>  'required|numeric',
        'tarjeta_esp'   =>  'required|numeric',
        'deposito_esp'  =>  'required|numeric',
        'fecha_inicial' =>  'required',
        'fecha_final'   =>  'required',
        'deposito_esp'  =>  'required|numeric',
        'user_id'       =>  'required|integer|min:1',
        'tienda_id'     =>  'required|integer|min:1',
        'caja_id'	    =>  'required|integer|min:1',
    );
}

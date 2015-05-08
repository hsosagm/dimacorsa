<?php namespace App\Validators;

use ValidatorAssistant, Input;

class CompraValidator extends ValidatorAssistant {

    protected $rules = array(
        'user_id'   =>  'required|integer|min:1',
        'proveedor_id'   =>  'required|integer|min:1',
        'tienda_id' =>  'required|integer|min:1',
        'numero_documento' =>  'required|unique:compras',
        'fecha_documento' =>  'required|date_format:Y/m/d',
    );
}

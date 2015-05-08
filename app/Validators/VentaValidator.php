<?php namespace App\Validators;

use ValidatorAssistant, Input;

class VentaValidator extends ValidatorAssistant {

    protected $rules = array(
        'cliente_id'       => 'required|integer|min:1',
        'numero_documento' => 'required|min:3|unique:ventas',
        'user_id'          => 'required|integer|min:1',
        'tienda_id'        => 'required|integer|min:1',
    );
}

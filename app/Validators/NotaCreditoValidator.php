<?php namespace App\Validators;

use ValidatorAssistant;

class NotaCreditoValidator extends ValidatorAssistant {

    protected $rules = array(
        'cliente_id'       => 'required|integer|min:1',
        'user_id'          => 'required|integer|min:1',
        'tienda_id'        => 'required|integer|min:1',
        'caja_id'          => 'required|integer|min:1',
        'estado'           => 'required|integer|min:0|max:1',
        'tipo'             => 'required',
    );
}

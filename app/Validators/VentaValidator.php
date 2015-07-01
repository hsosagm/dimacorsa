<?php namespace App\Validators;

use ValidatorAssistant;

class VentaValidator extends ValidatorAssistant {

    protected $rules = array(
        'cliente_id'       => 'required|integer|min:1',
        'user_id'          => 'required|integer|min:1',
        'tienda_id'        => 'required|integer|min:1',
    );
}

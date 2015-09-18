<?php namespace App\Validators;

use ValidatorAssistant;

class CajaValidator extends ValidatorAssistant {

    protected $rules = array(
        'tienda_id'       => 'required|integer|min:1',
        'nombre'          => 'required|min:4',
    );
}

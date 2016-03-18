<?php namespace App\Validators;

use ValidatorAssistant;

class KitValidator extends ValidatorAssistant {

    protected $rules = array(
        'user_id'     => 'required|integer|min:1',
        'tienda_id'   => 'required|integer|min:1',
        'producto_id' => 'required|integer|min:1',
        'cantidad'    => 'required|integer|min:1',
    );
}

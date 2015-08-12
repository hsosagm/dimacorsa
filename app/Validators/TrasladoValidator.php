<?php namespace App\Validators;

use ValidatorAssistant, Input;

class TrasladoValidator extends ValidatorAssistant {

    protected $rules = array(
        'user_id'   =>  'required|integer|min:1',
        'tienda_id'   =>  'required|integer|min:1',
        'tienda_id_destino' =>  'required|integer|min:1',
    );
}

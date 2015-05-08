<?php namespace App\Validators;

use ValidatorAssistant, Input;

class SoporteValidator extends ValidatorAssistant {

    protected $rules = array(
        'user_id'   =>  'required|integer|min:1',
        'tienda_id' =>  'required|integer|min:1',
    );
}

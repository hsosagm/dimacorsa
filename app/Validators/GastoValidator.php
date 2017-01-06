<?php namespace App\Validators;

use ValidatorAssistant;

class GastoValidator extends ValidatorAssistant {

    protected $rules = array(
        'categoria_id' =>  'required',
        'subcategoria_id' =>  'required',
        'user_id'   =>  'required|integer|min:1',
        'tienda_id' =>  'required|integer|min:1',
    );
}

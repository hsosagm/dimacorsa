<?php namespace App\Validators;

use ValidatorAssistant;

class DetalleTrasladoValidator extends ValidatorAssistant {

    protected $rules = array(
        'traslado_id'     =>  'required|integer|min:1',
        'producto_id'     =>  'required|integer|min:1',
        'cantidad'        =>  'required',
        'cantidad'        =>  'required',
    );
}

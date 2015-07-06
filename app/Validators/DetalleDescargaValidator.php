<?php namespace App\Validators;

use ValidatorAssistant;

class DetalleDescargaValidator extends ValidatorAssistant {

    protected $rules = array(
        'descarga_id'     =>  'required|integer|min:1',
        'producto_id'     =>  'required|integer|min:1',
        'cantidad'        =>  'required|numeric',
    );
}

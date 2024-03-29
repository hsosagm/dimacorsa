<?php namespace App\Validators;

use ValidatorAssistant;

class DevolucionDetalleValidator extends ValidatorAssistant {

    protected $rules = array(
        'devolucion_id' =>  'required|integer|min:1',
        'producto_id'   =>  'required|integer|min:1',
        'cantidad'      =>  'required|integer|min:1',
        'precio'        =>  'required|numeric',
    );
}
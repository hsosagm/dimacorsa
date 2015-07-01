<?php namespace App\Validators;

use ValidatorAssistant;

class DetalleVentaValidator extends ValidatorAssistant {

    protected $rules = array(
        'venta_id'    =>  'required|integer|min:1',
        'producto_id' =>  'required|integer|min:1',
        'cantidad'    =>  'required|integer|min:1',
        'precio'      =>  'required|numeric',
        'ganancias'   =>  'numeric',
    );
}
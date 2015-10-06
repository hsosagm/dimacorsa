<?php namespace App\Validators;

use ValidatorAssistant;

class DetalleCotizacionValidator extends ValidatorAssistant {

    protected $rules = array(
        'cotizacion_id' =>  'required|integer|min:1',
        'producto_id' 	=>  'required|integer',
        'cantidad'    	=>  'required|integer|min:1',
        'precio'      	=>  'required|numeric',
        'descripcion'  	=>  'required|min:5',
    );
}

<?php namespace App\Validators;

use ValidatorAssistant;

class DetalleAdelantoValidator extends ValidatorAssistant {

    protected $rules = array(
        'adelanto_id'     =>  'required|integer|min:1',
        'metodo_pago_id' =>  'required|integer|min:1',
        'descripcion'    =>  'required|min:5',
        'monto'          =>  'required|numeric',
    );
}

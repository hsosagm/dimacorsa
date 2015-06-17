<?php namespace App\Validators;

use ValidatorAssistant, Input;

class DetalleSoporteValidator extends ValidatorAssistant {

    protected $rules = array(
        'soporte_id'     =>  'required|integer|min:1',
        'metodo_pago_id' =>  'required|integer|min:1',
        'descripcion'    =>  'required|min:5',
        'monto'          =>  'required|numeric',
    );
}

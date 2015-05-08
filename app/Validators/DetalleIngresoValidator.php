<?php namespace App\Validators;

use ValidatorAssistant, Input;

class DetalleEgresoValidator extends ValidatorAssistant {

    protected $rules = array(
        'egreso_id'     =>  'required|integer|min:1',
        'metodo_pago_id' =>  'required|integer|min:1',
        'descripcion'    =>  'required|min:10',
        'monto'          =>  'required|numeric',
    );
}

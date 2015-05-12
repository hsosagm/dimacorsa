<?php namespace App\Validators;

use ValidatorAssistant, Input;

class DetalleCompraValidator extends ValidatorAssistant {

    protected $rules = array(
        'compra_id'   =>  'required|integer|min:1',
        'producto_id'   =>  'required|integer|min:1',
        'cantidad' =>  'required|numeric|min:1',
        'precio' =>  'required|numeric',
    );
}
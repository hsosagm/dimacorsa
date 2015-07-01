<?php namespace App\Validators;

use ValidatorAssistant;

class DetalleAbonosCompraValidator extends ValidatorAssistant
{
    protected $rules = array(
        'abonos_compra_id'  =>  'required|min:1',
        'compra_id'         =>  'required|min:1',
        'monto'  		    =>  'required|min:1',
    );
}

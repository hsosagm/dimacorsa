<?php namespace App\Validators;

use ValidatorAssistant, Input;

class PagosCompraValidator extends ValidatorAssistant
{
    protected $rules = array(
        'compra_id'     =>  'required|min:1',
        'monto'  		=>  'required|numeric|min:1',
        'metodo_pago_id'=>  'required|min:1',
    );
}

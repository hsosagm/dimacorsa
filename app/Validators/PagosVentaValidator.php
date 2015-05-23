<?php namespace App\Validators;

use ValidatorAssistant, Input;

class PagosVentaValidator extends ValidatorAssistant {

    protected $rules = array(
        'venta_id'       => 'required|integer|min:1',
        'monto'          => 'required|numeric|min:1',
        'metodo_pago_id' => 'required|integer|min:1',
    );
}

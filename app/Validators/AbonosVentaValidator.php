<?php namespace App\Validators;

use ValidatorAssistant, Input;

class AbonosVentaValidator extends ValidatorAssistant {

    protected $rules = array(
        'cliente_id'      => 'required|integer|min:1',
        'metodo_pago_id'  => 'required|integer|min:1',
        'monto'           => 'required|numeric',
        'user_id'         => 'required|integer|min:1',
        'tienda_id'       => 'required|integer|min:1',
    );
}

<?php namespace App\Validators;

use ValidatorAssistant;

class DevolucionNotaCreditoValidator extends ValidatorAssistant {
// devolucion_nota_credito [nota_credito_id, venta_id, metodo_pago_id, monto, descuento_sobre_saldo]
    protected $rules = array(
        'nota_credito_id'        => 'required|integer|min:1',
        'venta_id'               => 'required|integer|min:1',
        'metodo_pago_id'         => 'required|integer|min:1',
        'monto'                  => 'required|numeric|min:0',
        'descuento_sobre_saldo'  => 'required|numeric|min:0',
    );
}

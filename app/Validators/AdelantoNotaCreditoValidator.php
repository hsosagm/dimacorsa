<?php namespace App\Validators;

use ValidatorAssistant;

class AdelantoNotaCreditoValidator extends ValidatorAssistant {

    protected $rules = array(
        'nota_credito_id'   => 'required|integer|min:1',
        'monto'             => 'required|numeric',
    );
}

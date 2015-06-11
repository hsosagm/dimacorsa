<?php namespace App\Validators;

use ValidatorAssistant, Input;

class DetalleAbonosCompraValidator extends ValidatorAssistant
{
    protected $rules = array(
        'compra_id'		 		 =>  'required|integer|min:1',
    	'abonos_compra_id'   	 =>  'required|integer|min:1',
        'monto'  		    	 =>  'required|numeric|min:1',
    );
}

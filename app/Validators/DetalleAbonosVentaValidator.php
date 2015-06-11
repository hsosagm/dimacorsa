<?php namespace App\Validators;

use ValidatorAssistant, Input;

class DetalleAbonosVentaValidator extends ValidatorAssistant
{
    protected $rules = array(
        'venta_id'		 		 =>  'required|integer|min:1',
    	'abonos_ventas_id'   	 =>  'required|integer|min:1',
        'monto'  		    	 =>  'required|numeric|min:1',
    );
}

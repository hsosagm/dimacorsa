<?php namespace App\Validators;

use ValidatorAssistant, Input;

class CompraValidator extends ValidatorAssistant {

    protected $rules = array(
        'user_id'   =>  'required|integer|min:1',
        'proveedor_id'   =>  'required|integer|min:1',
        'tienda_id' =>  'required|integer|min:1',
        'numero_documento' =>  'required|min:3|unique:compras,numero_documento,{id}',
        'fecha_documento' =>  'required|date_format:Y/m/d',
    );

    protected function before()
    {
    	if (Input::has('id'))
    	{
            $this->bind('id', Input::get('id'));
    	}

    }
}

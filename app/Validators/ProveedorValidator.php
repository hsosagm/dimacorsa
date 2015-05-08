<?php namespace App\Validators;

use ValidatorAssistant, Input;

class ProveedorValidator extends ValidatorAssistant
{
    protected $rules = array(
        'nombre'              =>  'required|min:3|unique:proveedores,nombre, {id}',
        'direccion'           =>  'required|min:5|',
        'telefono'            =>  'required|integer|min:8',
    );

    protected function before()
    {
    	if (Input::has('id'))
    	{
            $this->bind('id', Input::get('id'));
    	}
    }
}

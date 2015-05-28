<?php namespace App\Validators;

use ValidatorAssistant, Input;

class ClienteContactoValidator extends ValidatorAssistant
{
    protected $rules = array(
        'nombre'              =>  'required|min:3',
        'apellido'            =>  'required|min:3|',
        'direccion'           =>  'required|min:5',
        'telefono1'           =>  'required|integer|min:8',
    );

    protected function before()
    {
    	if (Input::has('id'))
    	{
            $this->bind('id', Input::get('id'));
    	}
    }
}
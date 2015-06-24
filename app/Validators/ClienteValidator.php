<?php namespace App\Validators;

use ValidatorAssistant, Input;

class ClienteValidator extends ValidatorAssistant
{
    protected $rules = array(
        'nombre'    =>  'required|alpha_spaces|min:3',
        'apellido'  =>  'required|alpha_spaces|min:3|',
        'direccion' =>  'required|min:5|',
        'telefono'  =>  'integer|min:8',
        'nit'       =>  'required|min:3',
        'email'     =>  'email|unique:clientes,email, {id}'
    );

    protected function before()
    {
    	if (Input::has('id'))
    	{
            $this->bind('id', Input::get('id'));
    	}
    }
}

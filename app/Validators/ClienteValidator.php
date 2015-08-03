<?php namespace App\Validators;

use ValidatorAssistant, Input;

class ClienteValidator extends ValidatorAssistant
{
    protected $rules = array(
        'nombre'    =>  'required|min:3',
        'apellido'  =>  'required|min:3|',
        'direccion' =>  'required|min:5|',
        'telefono'  =>  'integer|min:8',
        'nit'       =>  'min:3',
        'email'     =>  ''
    );

    protected function before()
    {
        if (Input::has('email')) 
        {
            $this->addRule('email', 'email|unique:clientes,email, {id}');
        }

    	if (Input::has('id'))
    	{
            $this->bind('id', Input::get('id'));
    	}

    }
}

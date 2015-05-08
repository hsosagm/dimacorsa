<?php namespace App\Validators;

use ValidatorAssistant, Input;

class UserValidator extends ValidatorAssistant
{
    protected $rules = array(
        'username' =>  'required|min:3|max:12|unique:users,username, {id}',
        'nombre'   =>  'required|alpha_spaces|min:3',
        'apellido' =>  'required|alpha_spaces|min:3',
        'email'    =>  'required|email|unique:users,email, {id}'
    );

    protected function before()
    {
    	if (Input::has('id'))
    	{
            $this->bind('id', Input::get('id'));

            if (Input::has('password'))
            {
            	$this->addRule('password', 'min:5');
            }
    	}

    	else
    	{
    		$this->addRule('tienda_id', 'required|integer');
    		$this->addRule('password', 'required|min:5');
    	}
    }
}

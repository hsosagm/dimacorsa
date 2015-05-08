<?php namespace App\Validators;

use ValidatorAssistant, Input;

class MarcaValidator extends ValidatorAssistant
{
    protected $rules = array(
        'nombre'    =>  'required|min:3|unique:marcas,nombre, {id}',
    );

    protected function before()
    {
    	if (Input::has('id'))
    	{
            $this->bind('id', Input::get('id'));
    	}
    }
}
<?php namespace App\Validators;

use ValidatorAssistant, Input;

class CategoriaValidator extends ValidatorAssistant
{
    protected $rules = array(
        'nombre'    =>  'required|min:3|unique:categorias,nombre, {id}',
    );

    protected function before()
    {
    	if (Input::has('id'))
    	{
            $this->bind('id', Input::get('id'));
    	}
    }
}
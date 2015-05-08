<?php namespace App\Validators;

use ValidatorAssistant, Input;

class SubCategoriaValidator extends ValidatorAssistant
{
    protected $rules = array(
        'nombre'        =>  'required|min:3|unique:sub_categorias,nombre, {id}',
    );

    protected function before()
    {
    	if (Input::has('id'))
    	{
            $this->bind('id', Input::get('id'));
    	}
    }
}
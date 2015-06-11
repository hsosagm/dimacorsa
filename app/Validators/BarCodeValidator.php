<?php namespace App\Validators;

use ValidatorAssistant, Input;

class BarCodeValidator extends ValidatorAssistant {

    protected $rules = array(
        'tipo'      =>  'required|min:3|max:20',
        'ancho'  	=>  'required|numeric|min:1',
        'alto'      =>  'required|numeric|min:1',
        'letra'     =>  'required|numeric|min:1',
        'codigo'    =>  'required|min:3',
    );
}

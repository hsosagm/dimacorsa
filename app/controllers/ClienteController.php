<?php

class ClienteController extends \BaseController {

    public function search()
    {
        return Autocomplete::get('clientes', array('id', 'nombre', 'apellido'));
    }

}

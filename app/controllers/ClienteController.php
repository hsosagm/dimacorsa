<?php

class ClienteController extends \BaseController {

    public function search()
    {
        return Autocomplete::get('clientes', array('id', 'nombre', 'apellido'));
    }

    public function index()
    {
        return View::make('cliente.index');
    }

     public function create()
    {
        if (Input::has('_token'))
        {
            $cliente = new Cliente;

            if (!$cliente->_create())
            {
                return $cliente->errors();
            }

            $cliente_id = $cliente->get_id();

            $cliente = Cliente::find($cliente_id);

            $contactos = ClienteContacto::where('cliente_id','=',$cliente_id)->get();

            return Response::json(array(
                'success' => true, 
                'form' => View::make('cliente.edit',compact('cliente' , 'contactos'))->render()
                ));
        }

        return View::make('cliente.create');
    }

    public function info()
    {
    	$cliente =  Cliente::find(Input::get('id'));

        $contactos = ClienteContacto::where('cliente_id','=',Input::get('id'))->get();

        return View::make('cliente.info',compact('cliente' , 'contactos'));
    }

    public function contacto_create()
    {
        
        $cliente_id = Input::get('cliente_id');
        $contacto = new ClienteContacto;

        if (!$contacto->_create())
        {
            return $contacto->errors();
        }

        $lista = View::make('cliente.contactos_list',compact('cliente_id'))->render();
        
        return Response::json(array(
            'success' => true, 
            'lista' => $lista
            ));

    }

    public function contacto_update()
    {
        if (Input::has('_token'))
        {
            $contacto = ClienteContacto::find(Input::get('id'));

            if (!$contacto->_update())
            {
                return $contacto->errors();
            }

            $cliente_id = $contacto->cliente_id;
            $lista = View::make('cliente.contactos_list',compact('cliente_id'))->render();

            return Response::json(array(
                'success' => true,
                 'lista' => $lista
                 )); 
        }

        $contacto = ClienteContacto::find(Input::get('id'));

       return View::make('cliente.contacto_edit',compact('contacto'));

    }

    public function contacto_nuevo()
    {
        return View::make('cliente.contacto_nuevo');
    }

    public function edit()
    {
         if (Input::has('_token'))
        {
            $cliente = Cliente::find(Input::get('id'));

            if (!$cliente->_update())
            {
                return $cliente->errors();
            }

            return 'success'; 
        }

        $cliente = Cliente::find(Input::get('id'));

        $contactos = ClienteContacto::where('cliente_id','=',Input::get('id'))->get();

        return View::make('cliente.edit',compact('cliente' , 'contactos'));

    }

    public function contacto_info()
    {
        $contacto = ClienteContacto::find(Input::get('id'));

        return View::make('cliente.contacto_info',compact('contacto'));
    }
}

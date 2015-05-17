<?php

class ProveedorController extends BaseController {

    public function search()
    {
        return Autocomplete::get('proveedores', array('id', 'nombre','direccion','direccion'),'direccion');
    }
 
    public function create()
    {
        if (Input::has('_token'))
        {
            $proveedor = new Proveedor;

            if (!$proveedor->_create())
            {
                return $proveedor->errors();
            }

            $proveedor_id = DB::getPdo()->lastInsertId();

            return Response::json(array(
                'success' => true, 
                'contacto' => View::make('proveedor.contactos',compact("proveedor_id"))->render()
                ));
        }

        return View::make('proveedor.create');
    }

    public function help()
    {
    	$proveedor = Proveedor::find(Input::get('id'));

        $contactos = ProveedorContacto::where('proveedor_id','=',Input::get('id'))->get();

        return View::make('proveedor.help',compact('proveedor' , 'contactos'));
    }
    
    public function index()
    {
        return View::make('proveedor.index');
    }

    public function contacto_create()
    {
        
        $proveedor_id = Input::get('proveedor_id');
        $contacto = new ProveedorContacto;

        if (!$contacto->_create())
        {
            return $contacto->errors();
        }

         $lista =  Form::select('contacto_id', ProveedorContacto::where('proveedor_id','=', $proveedor_id)->lists('nombre', 'id') , "", array('class' => 'form-control'));
        return Response::json(array(
            'success' => true, 
            'lista' => $lista
            ));

    }

    public function contacto_update()
    {
        if (Input::has('_token'))
        {
            $contacto = ProveedorContacto::find(Input::get('id'));

            if (!$contacto->_update())
            {
                return $contacto->errors();
            }

           $lista =  Form::select('contacto_id', ProveedorContacto::where('proveedor_id','=', $contacto->proveedor_id)->lists('nombre', 'id') , "", array('class' => 'form-control'));

            return Response::json(array(
                'success' => true,
                 'lista' => $lista
                 )); 
        }

        $contacto = ProveedorContacto::find(Input::get('id'));

       return View::make('proveedor.contactos_edit',compact('contacto'));

    }

    public function list_contactos()
    {
        $contacto = ProveedorContacto::where('proveedor_id','=',Input::get('proveedor_id'))->get();

        $data = '<ul>';

        foreach ($contacto as $key => $ct) 
        {
            $data .= '<li><a id="contacto_view" contacto_id="'.$ct->id.'"class="btn-link theme-c">';

            $data .= $ct->nombre.' '.$ct->apellido.'</a> </li>' ; 
        }

        $data .= '</ul>';     

        return $data; 
    }

    public function contacto_nuevo()
    {
        return View::make('proveedor.contactos_nuevo');
    }

    public function edit()
    {
         if (Input::has('_token'))
        {
            $proveedor = Proveedor::find(Input::get('id'));

            if (!$proveedor->_update())
            {
                return $proveedor->errors();
            }

            return 'success'; 
        }

        $proveedor = Proveedor::find(Input::get('id'));

        $contactos = ProveedorContacto::where('proveedor_id','=',Input::get('id'))->get();

        return View::make('proveedor.edit',compact('proveedor' , 'contactos'));

    }

    public function contacto_info()
    {
        $contacto = ProveedorContacto::find(Input::get('id'));

        return View::make('proveedor.contacto_info',compact('contacto'));
    }

    public function TotalCredito()
    {
        $total = Compra::select(DB::Raw('sum(saldo) as total'))
        ->where('proveedor_id','=', Input::get('proveedor_id'))
        ->where('saldo','>', 0 )->first();

        return $total->total;
    }

}

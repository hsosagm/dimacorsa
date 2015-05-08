<?php

class TiendaController extends BaseController {

    public function index()
    {
        $tiendas = Tienda::with('users')->get();

        return View::make('tienda.index', compact('tiendas'));
    }


    public function create()
    {
        $values = Input::all();
        
    	$tienda = new Tienda;
        
        if ($tienda->validate($values))
        {
            Tienda::create($values);
            echo 'success';
        }
        else
        {
            $errors = $tienda->errors();
            echo $errors->first();
        }
    }

}

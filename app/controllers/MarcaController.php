<?php

class MarcaController extends BaseController {

	public function create()
    {
    	if (Session::token() == Input::get('_token'))
        {
            $marcas = new Marca;

            if ($marcas->_create())
            {
            	$id = $marcas->get_id();

            	$lista = View::make('marca.list')->render();

            	$select = Form::select('marca_id',Marca::lists('nombre', 'id'), $id , array('class'=>'form-control'));

                return array('success' => true ,'lista' => $lista ,'model' => 'marcas' ,'select' => $select );
            }
            
            return $marcas->errors();
    	}

        return View::make('marca.create');
    }

    public function edit()
    {
        
        if (Session::token() == Input::get('_token'))
        {
            $marca = Marca::find(Input::get('id'));

            if (!$marca->_update())
            {
                return $marca->errors();
            }

            $lista = View::make('marca.list')->render();

            $select = Form::select('marca_id',Marca::lists('nombre', 'id'),Input::get('id'), array('class'=>'form-control'));

            return array('success' => true ,'lista' => $lista ,'model' => 'marcas' ,'select' => $select );
        }

        $marca = Marca::find(Input::get('marca_id'));

        return View::make('marca.edit',compact("marca"));
    }
}

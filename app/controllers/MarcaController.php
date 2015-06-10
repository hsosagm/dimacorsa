<?php

class MarcaController extends BaseController {

	public function create()
    {
    	if (Session::token() == Input::get('_token'))
        {
            $marcas = new Marca;

            if ($marcas->_create())
            {
            	$id = DB::getPdo()->lastInsertId();

            	$lista = HTML::ul(Marca::lists('nombre'));

            	$select = Form::select('marca_id',Marca::lists('nombre', 'id'), $id , array('class'=>'form-control'));

                return array('success' => true ,'lista' => $lista ,'model' => 'marcas' ,'select' => $select );
            }
            
            return $marcas->errors();
    	}

        return View::make('marca.create');
    }
}

<?php

class SubCategoriaController extends \BaseController {

	public function create()
    {
    	if (Session::token() == Input::get('_token'))
        {
            $sub_categorias = new SubCategoria;

            if ($sub_categorias->_create())
            {
                $id = DB::getPdo()->lastInsertId();

            	$lista = HTML::ul(SubCategoria::where('categoria_id','=',Input::get('categoria_id'))->lists('nombre'));

            	$select = Form::select('categoria_id', SubCategoria::where('categoria_id','=',Input::get('categoria_id'))->lists('nombre', 'id') , $id , array('class' => 'form-control'));

                return array('success' => true ,'lista' => $lista ,'model' => 'sub_categorias' ,'select' => $select );
            }
            
            return $sub_categorias->errors();
    	}

        return View::make('sub_categoria.create');
    }

    public function filter_select()
    {
    	$select = Form::select('categoria_id', SubCategoria::where('categoria_id','=',Input::get('categoria_id'))
    		->lists('nombre', 'id') , '' , array('class' => 'form-control'));

        $lista = HTML::ul(SubCategoria::where('categoria_id','=',Input::get('categoria_id'))->lists('nombre'));

    	return array('select' => $select , 'lista' => $lista);
    }

}

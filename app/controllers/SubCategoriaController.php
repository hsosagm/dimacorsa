<?php

class SubCategoriaController extends \BaseController {

	public function create()
    {
    	if (Session::token() == Input::get('_token'))
        {
            $sub_categorias = new SubCategoria;

            if ($sub_categorias->_create())
            {
                $id = $sub_categorias->get_id();

            	$lista = View::make('sub_categoria.list')->render();

            	$select = Form::select('sub_categoria_id', SubCategoria::where('categoria_id','=',Input::get('categoria_id'))->lists('nombre', 'id') , $id , array('class' => 'form-control'));

                return array('success' => true ,'lista' => $lista ,'model' => 'sub_categorias' ,'select' => $select );
            }
            
            return $sub_categorias->errors();
    	}

        return View::make('sub_categoria.create');
    }

    public function edit()
    {
        
        if (Session::token() == Input::get('_token'))
        {
            $sub_categoria = SubCategoria::find(Input::get('id'));

            if (!$sub_categoria->_update())
            {
                return $sub_categoria->errors();
            }

            $lista = View::make('sub_categoria.list')->render();

            $select = Form::select('sub_categoria_id', SubCategoria::where('categoria_id','=',Input::get('categoria_id'))->lists('nombre', 'id') , Input::get('id') , array('class' => 'form-control'));

            return array('success' => true ,'lista' => $lista ,'model' => 'marcas' ,'select' => $select );
        }

        $sub_categoria = SubCategoria::find(Input::get('sub_categoria_id'));

        return View::make('sub_categoria.edit',compact("sub_categoria"));
    }


    public function filter_select()
    {
    	$select = Form::select('categoria_id', SubCategoria::where('categoria_id','=',Input::get('categoria_id'))
    		->lists('nombre', 'id') , '' , array('class' => 'form-control'));

        $lista = View::make('sub_categoria.list')->render();

    	return array('select' => $select , 'lista' => $lista);
    }

}

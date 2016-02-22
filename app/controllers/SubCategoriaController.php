<?php

class SubCategoriaController extends \BaseController {

    public function buscar($cat)
    {
        $fk = " categoria_id = {$cat} ";
        return AutocompleteCategoria::get('sub_categorias', array('id', 'nombre'),$fk);
    }

	public function create()
    {
    	if (Input::has('_token'))
        {
            $sub_categorias = new SubCategoria;

            if ($sub_categorias->_create())
            {
                $id = $sub_categorias->get_id();

            	$lista = View::make('sub_categoria.list')->render();
                $subCategoria = SubCategoria::find($id);

            	return array(
                    'success' => true ,
                    'lista' => $lista ,
                    'model' => 'SubCategoria' ,
                    'nombre' => $subCategoria->nombre ,
                    'input' => 'sub_categoria_id' ,
                    'id' => $id
                );
            }
            
            return $sub_categorias->errors();
    	}

        return View::make('sub_categoria.create');
    }

    public function edit()
    {
        
        if (Input::has('_token'))
        {
            $sub_categoria = SubCategoria::find(Input::get('id'));

            if (!$sub_categoria->_update())
                return $sub_categoria->errors();

            $lista = View::make('sub_categoria.list')->render();
            $subCategoria = SubCategoria::find(Input::get('id'));
            
            return array(
                'success' => true ,
                'lista' => $lista ,
                'model' => 'SubCategoria' ,
                'nombre' => $subCategoria->nombre ,
                'input' => 'sub_categoria_id' ,
                'id' => Input::get('id')
            );
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

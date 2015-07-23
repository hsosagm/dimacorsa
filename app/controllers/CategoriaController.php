<?php

class CategoriaController extends \BaseController {

    public function buscar()
    {
        return AutocompleteCategoria::get('categorias', array('id', 'nombre'));
    }

	public function create()
    {
    	if (Input::has('_token'))
        {
            $categorias = new Categoria;

            if ($categorias->_create())
            {
                $id = $categorias->get_id();
            	$lista = View::make('categoria.list')->render();
                $this->create_unasigned($id);
                $categoria = Categoria::find($id);

            	return array(
                    'success' => true ,
                    'lista' => $lista ,
                    'model' => 'Categoria' ,
                    'nombre' => $categoria->nombre ,
                    'input' => 'categoria_id' ,
                    'id' => $id 
                );
            }
            
            return $categorias->errors();
    	}

        return View::make('categoria.create');
    }

     public function edit()
    {
        
        if (Input::has('_token'))
        {
            $categoria = Categoria::find(Input::get('id'));

            if (!$categoria->_update())
            {
                return $categoria->errors();
            }

            $lista = View::make('categoria.list')->render();
            $categoria = Categoria::find(Input::get('id'));

            return array(
                    'success' => true ,
                    'lista' => $lista ,
                    'model' => 'Categoria' ,
                    'nombre' => $categoria->nombre ,
                    'input' => 'categoria_id' ,
                    'id' => Input::get('id')
                );
        }

        $categoria = Categoria::find(Input::get('categoria_id'));

        return View::make('categoria.edit',compact("categoria"));
    }

    /*
        funcion para crear la sub categoria unsigned para la creacion de una categoria
    */
    public function create_unasigned ($categoria_id)
    {
        $sub_categoria = new SubCategoria;

        $sub_categoria->nombre = 'Unasigned';

        $sub_categoria->categoria_id = $categoria_id;

        $sub_categoria->save();
    }
}

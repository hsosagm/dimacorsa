<?php

class CategoriaController extends \BaseController {

	public function create()
    {
    	if (Input::has('_token'))
        {
            $categorias = new Categoria;

            if ($categorias->_create())
            {
                $id = DB::getPdo()->lastInsertId();

            	$lista = HTML::ul(Categoria::lists('nombre'));

                $this->create_unasigned( $id );

            	$select = Form::select('categoria_id',Categoria::lists('nombre', 'id'),$id, array('class'=>'form-control'));

                return array('success' => true ,'lista' => $lista ,'model' => 'categorias' ,'select' => $select );
            }
            
            return $categorias->errors();
    	}

        return View::make('categoria.create');
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

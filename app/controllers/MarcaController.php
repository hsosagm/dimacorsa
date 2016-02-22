<?php

class MarcaController extends BaseController {

    public function buscar()
    {
        return AutocompleteCategoria::get('marcas', array('id', 'nombre'));
    }

	public function create()
    {
    	if (Input::has('_token'))
        {
            $marcas = new Marca;

            if ($marcas->_create())
            {
            	$id = $marcas->get_id();
                $marca = Marca::find($id);
            	$lista = View::make('marca.list')->render();

                return array(
                    'success' => true ,
                    'lista' => $lista ,
                    'model' => 'Marca' ,
                    'nombre' => $marca->nombre ,
                    'input' => 'marca_id' ,
                    'id' => $id
                );
            }

            return $marcas->errors();
    	}

        return View::make('marca.create');
    }

    public function edit()
    {
        if (Input::has('_token'))
        {
            $marca = Marca::find(Input::get('id'));

            if (!$marca->_update())
                return $marca->errors();

            $lista = View::make('marca.list')->render();
            $marca = Marca::find(Input::get('id'));

            return array(
                'success' => true ,
                'lista' => $lista ,
                'model' => 'Marca' ,
                'nombre' => $marca->nombre ,
                'input' => 'marca_id' ,
                'id' => Input::get('id')
            );
        }

        $marca = Marca::find(Input::get('marca_id'));
        return View::make('marca.edit',compact("marca"));
    }
}

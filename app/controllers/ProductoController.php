<?php

class ProductoController extends Controller {

	public function create()
    {
    	if (Input::has('_token'))
        {
            $producto = new Producto;

            if ($producto->_create())
            {
                return 'success';
            }
            else
            {
                return $producto->errors();
            }
    	}

        return View::make('producto.create');
    }


    public function edit()
    {
    	if (Input::has('_token'))
        {
	    	$producto = Producto::find(Input::get('id'));

			if ( $producto->_update() )
			{
		        return 'success';
			}
			else
			{
			    return $producto->errors();
			}
    	}
    	
        $producto = Producto::find(Input::get('id'));

        $message = "Producto actualizado";

        return View::make('producto.edit', compact('producto', 'message','inactivo'));
    }


    public function delete()
    {
    	$delete = Producto::destroy(Input::get('id'));

    	if ($delete)
    	{
    		return 'success';
    	}

    	return 'error';
    }

    public function find()
    {
        $query = Producto::where('codigo', '=',Input::get('codigo'))->first();
        $Existencia = Existencia::where('producto_id','=',$query->id)->first();

        if($Existencia != '')
        {
            $Existencia = $Existencia->existencia;
        }
        else
        {
            $Existencia = 0;
        }
            $precio_c = $query->p_costo / 100;
            
            return array(
                'success'           => true,
                'descripcion'       => $query->descripcion,
                'p_costo'           => 'Precio Costo: '.$precio_c,
                'p_publico'         => 'Precio Publico: '.$query->p_publico,
                'existencia_total'  => 'Existencia: '.$query->existencia,
                'existencia'        => 'Existencia: '.$Existencia,
                'id'                =>  $query->id
            );
    }

    public function user_inventario()
    {
        return View::make("producto.user_inventario");       
    }

    public function view_existencias()
    {
        $Query = Existencia::select(
            'existencias.existencia as existencia',
            'tiendas.nombre as tienda',
            'tiendas.direccion as direccion')
        ->join('productos', 'existencias.producto_id', '=', 'productos.id')
        ->join('tiendas', 'tiendas.id', '=', 'existencias.tienda_id')
        ->where('existencias.producto_id','=',Input::get('id'))->get();

        $info = Producto::find(Input::get('id'));

        return View::make("producto.existencia",compact('Query','info'));  
    }
}

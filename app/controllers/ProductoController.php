<?php

class ProductoController extends Controller {


	public function create()
    {
    	if (Session::token() == Input::get('_token'))
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
    	if (Session::token() == Input::get('_token'))
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
        $values = trim(Input::get('codigo'));
        $values = preg_replace('/\s{2,}/', ' ', $values);

        if ($values == '') 
        {
            return 'El campo del codigo se encuentra vacio...!';
        }

        $query = Producto::where('codigo', '=',Input::get('codigo'))->first();

        if($query == '')
        {
            return 'el codigo que buscas no existe..!';
        }

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

     public function inventario_dt()
    {
        return View::make('producto.inventario_dt');
    }

    public function index()
    {
        $table = 'productos';

        $columns = array("codigo","nombre","descripcion","p_costo","p_publico");

        $Searchable = array("codigo","nombre","descripcion");
        
        $Join = 'JOIN marcas ON productos.marca_id = marcas.id';

        echo TableSearch::get($table, $columns, $Searchable, $Join);
    }

    public function md_search()
    {
        return View::make('producto.md-search');
    }

    public function md_search_dt()
    {
        $table = 'productos';

        $columns = array("codigo","nombre","descripcion","existencia","p_publico");

        $Searchable = array("codigo","nombre","descripcion");
        
        $Join = 'JOIN marcas ON productos.marca_id = marcas.id';

        echo TableSearch::get($table, $columns, $Searchable, $Join);
    } 

    public function user_inventario()
    {
        return View::make('producto.user_inventario');
    }

    public function user_inventario_dt()
    {
        $table = 'productos';

        $columns = array(
            "codigo",
            "nombre",
            "descripcion",
            "p_publico",
            "existencias.existencia as existencia");

        $Searchable = array("codigo","nombre","descripcion");
        
        $Join = 'JOIN marcas ON productos.marca_id = marcas.id  Join  existencias ON productos.id = existencias.producto_id ';
        $where = "tienda_id = ".Auth::user()->tienda_id.' AND productos.existencia > 0';

        echo TableSearch::get($table, $columns, $Searchable, $Join ,$where );
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

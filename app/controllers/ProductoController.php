 <?php

class ProductoController extends Controller {


	public function create()
    {
    	if (Input::has('_token'))
        {
            $producto = new Producto;

            if ($producto->_create())
                return 'success';
            else
                return $producto->errors();
    	}

        return View::make('producto.create');
    }


    public function edit()
    {
    	if (Input::has('_token'))
        {
            Input::merge(array('p_publico' => str_replace(',', '', Input::get('p_publico'))));
	    	$producto = Producto::find(Input::get('id'));

			if ( $producto->_update() )
		        return 'success';
			else
			    return $producto->errors();
    	}

        $producto = Producto::find(Input::get('id'));

        $message = "Producto actualizado";

        return View::make('producto.edit', compact('producto', 'message','inactivo'));
    }

    public function edit_dt()
    {
        $producto = Producto::find(Input::get('id'));

        return View::make('producto.edit_dt', compact('producto'));
    }

    public function delete()
    {
    	$delete = Producto::destroy(Input::get('id'));

    	if ($delete)
    		return 'success';

    	return 'error';
    }

    public function find()
    {
        $values = trim(Input::get('codigo'));
        $values = preg_replace('/\s{2,}/', ' ', $values);

        if ($values == '')
            return 'El campo del codigo se encuentra vacio...!';

        $query = Producto::where('codigo', '=',Input::get('codigo'))->first();

        if($query == '')
            return 'el codigo que buscas no existe..!';

        $Existencia = Existencia::where('producto_id','=',$query->id)
        ->where('tienda_id','=',Auth::user()->tienda_id)->first();

        if($Existencia != '')
            $Existencia = $Existencia->existencia;
        else
            $Existencia = 0;

        $precio_c = $query->p_costo;
        $marca = Marca::find($query->marca_id);

        return array(
            'success'           => true,
            'descripcion'       =>  "[ ".$marca->nombre." ] ".$query->descripcion,
            'p_costo'           => 'Precio Costo: '.f_num::get5($precio_c),
            'p_costo_descarga'  =>  f_num::get5($precio_c),
            'p_publico'         => 'Precio Publico: '.round($query->p_publico, 2),
            'p_publico_venta'   =>  round($query->p_publico, 2),
            'existencia_total'  => 'Existencia: '.$query->existencia,
            'existencia'        => 'Existencia: '.$Existencia,
            'id'                =>  $query->id
        );
    }

    public function getInventario()
    {
        $codigoBarra = DB::table('printer')->select('impresora')->where('tienda_id',Auth::user()->tienda_id)
        ->where('nombre','codigoBarra')->first();

        return Response::json(array(
            'success'=> true,
            'view' => View::make('producto.getInventario', compact('codigoBarra'))->render()
        ));
    }

    public function index()
    {
        $table = 'productos';

        $columns = array(
            "codigo",
            "nombre",
            "descripcion",
            "ROUND(p_costo, 5) as p_costo",
            "p_publico",
            "existencias.existencia as existencia",
            "productos.existencia as existencia_total"
		);

        $Searchable = array("codigo","nombre","descripcion");

        $Join = 'JOIN marcas ON productos.marca_id = marcas.id  Join  existencias ON productos.id = existencias.producto_id ';
        $where = "tienda_id = ".Auth::user()->tienda_id;
        // $where = "existencias.existencia > 0 AND existencias.tienda_id = ".Auth::user()->tienda_id;

        echo TableSearch::get($table, $columns, $Searchable, $Join ,$where );
    }

    public function md_search()
    {
        return View::make('producto.md-search');
    }

    public function md_search_dt()
    {
       $table = 'productos';

        $columns = array(
            "codigo",
            "nombre",
            "descripcion",
            "p_publico",
            "existencias.existencia as existencia",
            "productos.existencia as existencia_total");

        $Searchable = array("codigo","nombre","descripcion");

        $Join = 'JOIN marcas ON productos.marca_id = marcas.id  JOIN  existencias ON productos.id = existencias.producto_id ';
        $where = "tienda_id = ".Auth::user()->tienda_id;

        echo TableSearch::get($table, $columns, $Searchable, $Join ,$where );
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

        $Join = 'JOIN marcas ON productos.marca_id = marcas.id  JOIN  existencias ON productos.id = existencias.producto_id ';
        $where = "tienda_id = ".Auth::user()->tienda_id;

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

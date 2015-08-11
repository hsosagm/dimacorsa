<?php 

class TrasladoController extends \BaseController {

	public function buscarTienda()
	{
		return Autocomplete::get('tiendas', array('id', 'nombre','direccion','direccion'),'direccion');
	}

	public function create()
    {
    	if (Input::has('_token'))
        {
            $traslado = new Traslado;

           if (!$traslado->create_master())
			{
				return $traslado->errors(); 
			}

			$id = $traslado->get_id();
			
			$traslado = Traslado::find($id);

			$destino = Tienda::find($traslado->tienda_id_destino);
			
			return Response::json(array(
				'success' => true, 
				'detalle' => View::make('traslado.detalle',compact("id"))->render(),
				'info_head' => View::make('traslado.info_head', compact("traslado","destino"))->render()
			));
            
    	}

        return View::make('traslado.create');
    }

    public function detalle() 
    {
    	if (Input::has('_token'))
        {   
            $consultar = DetalleTraslado::where('traslado_id','=',Input::get('traslado_id'))
            ->where('producto_id','=',Input::get('producto_id'))->get();

            if (count($consultar))
                return 'el producto ya fue ingresado ..!';

            $existencia = Existencia::where('producto_id','=',Input::get('producto_id'))
            ->where('tienda_id','=',Auth::user()->tienda_id)->first();

            if ($existencia->existencia < Input::get('cantidad')) 
                return 'No puede trasladar mas de la Existencia';

            $producto = Producto::find(Input::get('producto_id'));

            $data = Input::all();
            $data['precio'] =( $producto->p_costo / 100);

            $detalle_traslado = new DetalleTraslado;

            if ($detalle_traslado->_create($data))
            {
                $id = $detalle_traslado->get_id();

                $detalle = DetalleTraslado::find($id);

                $existencia = Existencia::where('producto_id' , '=' , $detalle->producto_id)
                ->where('tienda_id' , '=' , Auth::user()->tienda_id )->first();

                $existencia->existencia = $existencia->existencia - $detalle->cantidad ;

                $existencia->save();

                $detalle = $this->consulta_detalle_traslado();

                return Response::json(array('success' => true, 
                    'table' => View::make('traslado.detalle_body',compact('detalle'))->render() 
                ));
            }

            return $detalle_traslado->errors();
        }
    }

    public function eliminar_detalle()
    {
        $detalle = DetalleTraslado::find(Input::get('id'));

        $existencia = Existencia::where('producto_id' , '=' , $detalle->producto_id)
        ->where('tienda_id' , '=' , Auth::user()->tienda_id )->first();

        $existencia->existencia = $existencia->existencia + $detalle->cantidad ;

        $existencia->save();

        if ($detalle->delete())
            return 'success';

        return 'Huvo un error al tratar de eliminar';
    }

    public function eliminarTraslado()
    {   
        $detalle = DetalleTraslado::where('traslado_id' , '=' , Input::get('traslado_id'))->get();

        foreach ($detalle as $dt) 
        {
            $existencia = Existencia::where('producto_id' , '=' , $dt->producto_id)
            ->where('tienda_id' , '=' , Auth::user()->tienda_id )->first();

            $existencia->existencia = $existencia->existencia + $dt->cantidad ;

            $existencia->save();  
        }

        Descarga::destroy(Input::get('traslado_id'));
        return 'success';
    }

    public function finalizarTraslado()
    {
        $detalle = DetalleTraslado::select(DB::raw('sum(cantidad*precio) as total'))
        ->where('traslado_id', '=', Input::get('traslado_id'))->first();
        $traslado = Traslado::find(Input::get('traslado_id'));
        $traslado->status = 1;
        $traslado->total = $detalle->total;
        $traslado->save();

        return 'success';
    }

    public function consulta_detalle_traslado () 
    {
        $query = DB::table('detalle_traslados')
        ->select(array('detalle_traslados.id as id','traslado_id', 'producto_id', 'cantidad', 'precio', DB::raw('CONCAT(productos.descripcion, " ", marcas.nombre) AS descripcion, (cantidad * precio) AS total') ))
        ->where('traslado_id', Input::get("traslado_id"))
        ->join('productos', 'detalle_traslados.producto_id', '=', 'productos.id')
        ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
        ->get();

        return $query;      
    }

    public function getTrasladosEnviados()
    {
        return View::make('traslado.getTrasladosEnviados')->render();
    }

    public function getTrasladosRecibidos()
    {
        return View::make('traslado.getTrasladosRecibidos')->render();
    }

    public function getTrasladosEnviados_dt()
    {
        $table = 'traslados';

        $columns = array(
            "traslados.created_at as fecha",
            "CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
            "CONCAT_WS(' ',tiendas.nombre,tiendas.direccion) as tienda",
            "nota",
            "total",
            "traslados.status as estado");

        $Searchable = array("traslados.created_at","users.nombre","users.apellido","tiendas.nombre","nota","traslados.status");

        $Join  = " JOIN tiendas ON (tiendas.id = tienda_id_destino )";
        $Join .= " JOIN users ON (users.id = traslados.user_id )";
        
        $Where = " traslados.tienda_id = ".Auth::user()->tienda_id;

        echo TableSearch::get($table, $columns, $Searchable, $Join, $Where);
    }

    public function getTrasladosRecibidos_dt()
    {
        $table = 'traslados';

        $columns = array(
            "traslados.created_at as fecha",
            "CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
            "CONCAT_WS(' ',tiendas.nombre,tiendas.direccion) as tienda",
            "nota",
            "total",
            "traslados.recibido as estado");

        $Searchable = array("traslados.created_at","users.nombre","users.apellido","tiendas.nombre","nota","traslados.status");

        $Join  = " JOIN tiendas ON (tiendas.id = tienda_id )";
        $Join .= " JOIN users ON (users.id = traslados.user_id )";
        
        $Where = " traslados.tienda_id_destino = ".Auth::user()->tienda_id;

        echo TableSearch::get($table, $columns, $Searchable, $Join, $Where);
    }

}

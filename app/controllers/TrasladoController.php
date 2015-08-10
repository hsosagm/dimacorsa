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
                return 'No puede descargar mas de la Existencia';

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

            return $detalle_descarga->errors();
        }
    }

    public function consulta_detalle_traslado () 
    {
        $query = DB::table('detalle_traslado')
        ->select(array('detalle_traslado.id as id','descarga_id', 'producto_id', 'cantidad', 'precio', DB::raw('CONCAT(productos.descripcion, " ", marcas.nombre) AS descripcion, (cantidad * precio) AS total') ))
        ->where('descarga_id', Input::get("traslado_id"))
        ->join('productos', 'detalle_traslado.producto_id', '=', 'productos.id')
        ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
        ->get();

        return $query;      
    }
}

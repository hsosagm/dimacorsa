<?php

class DescargaController extends BaseController {

    public function create()
    { 
        if (Input::has('_token'))
        {    
            $consultar = DetalleDescarga::where('descarga_id','=',Input::get('descarga_id'))
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

            $detalle_descarga = new DetalleDescarga;

            if ($detalle_descarga->_create($data))
            {
                $id = $detalle_descarga->get_id();

                $detalle = DetalleDescarga::find($id);

                $existencia = Existencia::where('producto_id' , '=' , $detalle->producto_id)
                ->where('tienda_id' , '=' , Auth::user()->tienda_id )->first();

                $existencia->existencia = $existencia->existencia - $detalle->cantidad ;

                $existencia->save();

                $detalle = $this->consulta_detalle_descargas();

                return Response::json(array('success' => true, 
                    'table' => View::make('descargas.detalle',compact('detalle'))->render() ));
                }

                return $detalle_descarga->errors();
            }

        $descarga = new Descarga;

        if (!$descarga->create_master())
        {
            return $descarga->errors();
        }

        $id = $descarga->get_id();

        return View::make('descargas.create', compact('id'));

    }

    public function descripcion()
    { 
        if (Input::has('_token'))
        {   
            $descarga = Descarga::find(Input::get('descarga_id'));
            $descarga->descripcion = trim(Input::get('descripcion'));

           if( $descarga->save())
                return trim('success');
        }
        
        $descarga = Descarga::find(Input::get('descarga_id'));

        return Response::json(array('success' => true, 
            'data' => View::make('descargas.descripcion',compact('descarga'))->render() 
        ));
    }

    public function delete()
    {   
        $detalle = DetalleDescarga::where('descarga_id' , '=' , Input::get('descarga_id'))->get();

        foreach ($detalle as $dt) 
        {
            $existencia = Existencia::where('producto_id' , '=' , $dt->producto_id)
            ->where('tienda_id' , '=' , Auth::user()->tienda_id )->first();

            $existencia->existencia = $existencia->existencia + $dt->cantidad ;

            $existencia->save();  
        }

        Descarga::destroy(Input::get('descarga_id'));

        return 'success';

    }

    public function eliminar_detalle()
    {
        $detalle = DetalleDescarga::find(Input::get('id'));

        $existencia = Existencia::where('producto_id' , '=' , $detalle->producto_id)
        ->where('tienda_id' , '=' , Auth::user()->tienda_id )->first();

        $existencia->existencia = $existencia->existencia + $detalle->cantidad ;

        $existencia->save();

        if ($detalle->delete())
            return 'success';

        return 'Huvo un error al tratar de eliminar';
    }

    public function consulta_detalle_descargas()
    {
        $query = DB::table('detalle_descargas')
        ->select(array('detalle_descargas.id as id','descarga_id', 'producto_id', 'cantidad', 'precio', DB::raw('CONCAT(productos.descripcion, " ", marcas.nombre) AS descripcion, (cantidad * precio) AS total') ))
        ->where('descarga_id', Input::get("descarga_id"))
        ->join('productos', 'detalle_descargas.producto_id', '=', 'productos.id')
        ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
        ->get();

        return $query;      
    }

    public function ImprimirDescarga($id)
    {
        $descarga_id = Crypt::decrypt($id);

        $descarga = Descarga::with('detalle_descarga')->find($descarga_id);
        if(count($descarga->detalle_descarga)>0)
        {
            return View::make('descargas.imprimir', compact('descarga'))->render();
        }
        else
            return 'Ingrese productos ala Descarga para poder inprimir';
    }

    public function ImprimirDescarga_dt($cod , $id)
    {
        $descarga_id = ($id);

        $descarga = Descarga::with('detalle_descarga')->find($descarga_id);
        if(count($descarga->detalle_descarga)>0)
        {
            return View::make('descargas.imprimir', compact('descarga'))->render();
        }
        else
            return 'Ingrese productos ala Descarga para poder inprimir';
    }

    public function showgDownloadsDetail()
    {
        $detalle = $this->getDownloadsDetail();

        return Response::json(array(
            'success' => true,
            'table'   => View::make('descargas.DT_detalle_descarga', compact('detalle'))->render()
        ));
    }

    public function getDownloadsDetail()
    {
        $detalle = DB::table('detalle_descargas')
        ->select(array(
            'detalle_descargas.id',
            'descarga_id', 'producto_id',
            'cantidad', 
            'precio', 
            DB::raw('CONCAT(productos.descripcion, " ", marcas.nombre) AS descripcion, (cantidad * precio) AS total') ))
        ->where('descarga_id', Input::get('descarga_id'))
        ->join('productos', 'detalle_descargas.producto_id', '=', 'productos.id')
        ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
        ->get();

        return $detalle;
    }

    public function  OpenDownload() 
    {
        $descarga_id = Input::get('descarga_id');

        $detalle = $detalle = $this->consulta_detalle_descargas();

        return Response::json(array(
            'success' => true,
            'detalle'   => View::make('descargas.edit', compact('descarga_id','detalle'))->render()
        ));
    }

    public function ingresarSeriesDetalleDescarga()
    {
        if (Input::get('guardar') == true) {
            $detalle_descarga = DetalleDescarga::find(Input::get('detalle_descarga_id'));
            $detalle_descarga->serials = Input::get('serials');
            $detalle_descarga->save();

            return Response::json(array('success' => true));
        }

        $detalle_descarga = DetalleDescarga::find(Input::get('detalle_descarga_id'));
        $serials = explode(',', $detalle_descarga->serials ); 

        if (trim($detalle_descarga->serials) == null ) 
            $serials = [];
        
        return Response::json(array(
            'success' => true,
            'view'   => View::make('descargas.ingresarSeriesDetalleDescarga', compact('serials'))->render()
        ));
    }
} 

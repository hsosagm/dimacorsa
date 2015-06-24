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

            $query = new DetalleDescarga;

            if ($query->_create())
            {

                $id = $query->get_id();

                $detalle = DetalleDescarga::find($id);

                $existencia = Existencia::where('producto_id' , '=' , $detalle->producto_id)
                ->where('tienda_id' , '=' , Auth::user()->tienda_id )->first();

                $existencia->existencia = $existencia->existencia - $detalle->cantidad ;

                $existencia->save();

                $detalle = $this->consulta_detalle_descargas();

                return Response::json(array('success' => true, 
                    'table' => View::make('descargas.detalle',compact('detalle'))->render() ));
            }



            return $query->errors();
        }

        $descarga = new Descarga;

        if (!$descarga->create_master())
        {
            return $descarga->errors();
        }

        $id = $descarga->get_id();

        return View::make('descargas.create', compact('id'));

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

    public function OpenTableDownloadsDay()
    {
        return View::make('descargas.DownloadsDay');
    }

    public function DownloadsDay_dt()
    {

       $table = 'descargas';

        $columns = array(
            "descargas.id as identificador",
            "tiendas.nombre as tienda_nombre",
            "descargas.created_at as fecha",
            "CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
            'Round((select sum(cantidad*precio) from detalle_descargas where descarga_id = descargas.id),2) as total',
            );

        $Searchable = array("users.nombre","users.apellido");

        $Join = "
        JOIN users ON (users.id = descargas.user_id)
        JOIN tiendas ON (tiendas.id = descargas.tienda_id)";

        $where = " DATE_FORMAT(descargas.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d')";

        echo TableSearch::get($table, $columns, $Searchable, $Join, $where );
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
} 
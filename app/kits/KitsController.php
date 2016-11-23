<?php namespace App\kits;

use Input, View, Auth, Response, Producto, Kit, Success, DB, Existencia, KitDetalle, TableSearch;
use Carbon, Traslado, User, f_num;

class KitsController extends \BaseController {

    protected $tienda_id;

    public function __construct()
    {
        $this->tienda_id = Auth::user()->tienda_id;
    }

	public function create()
	{
		if (Input::has('_token'))
		{
            $kit = new Kit;

            if (!$kit->create_master())
                return $kit->errors();

            $kit_id = $kit->get_id();

            return Response::json([
                'success' => true,
                'kit_id'  => $kit_id
            ]);
		}

        $kit_id = json_encode('');
        $kit_cantidad = json_encode('');
        $detalle = json_encode([]);
        $producto = json_encode([]);

        return Response::json(array(
            'success' => true,
            'form' => View::make('kits::create', compact('kit_id', 'kit_cantidad', 'detalle', 'producto'))->render()
        ));
	}


    public function deleteKit()
    {
        if (Kit::destroy(Input::get('id')))
            return Success::true();

        return 'Hubo un error al tratar de eliminar';
    }

    public function table_productos()
    {
        return View::make('kits::table_productos');
    }

	public function crearProducto()
    {
        $producto = new Producto;

        if (!$producto->_create())
            return $producto->errors();

        $codigo = preg_replace('/\s{2,}/', ' ', trim(Input::get('codigo')));

        $producto = Producto::with('marca')->whereCodigo($codigo)->first();

        return array(
            'success' => true,
            'values'  => array(
                'id'          => $producto->id,
                'descripcion' => $producto->descripcion . PHP_EOL . $producto->marca->nombre,
                'precio'      => $producto->p_publico,
                'existencia'  => $producto->existencia,
            )
        );
    }

    public function postKitDetalle()
    {
        if ($this->check_if_code_exists_in_this_kit())
            return "El codigo ya ha sido ingresado..";

        if ($this->check_existencia())
            return "La cantidad que esta ingresando es mayor a la cantidad en existencia..";

        if (KitDetalle::create(Input::all())) {
            return Response::json(array(
                'success' => true,
                'detalle' => $this->getKitDetalle()
            ));
        }

        return "Hubo un error intentelo de nuevo";
    }

    public function check_if_code_exists_in_this_kit()
    {
        $query = DB::table('kit_detalle')->select('id')
        ->where('kit_id', Input::get("kit_id"))
        ->where('producto_id', Input::get("producto_id"))
        ->first();

        if ($query == null)
            return false;

        return true;
    }

    public function check_existencia()
    {
        Input::merge(array('cantidad' => str_replace(',', '', Input::get('cantidad'))));

        $query = Existencia::whereProductoId(Input::get('producto_id'))->whereTiendaId($this->tienda_id)->first();

        if ($query == null || $query->existencia < Input::get('cantidad'))
            return true;

        return false;
    }

    public function getKitDetalle()
    {
        $detalle = DB::table('kit_detalle')
        ->select([
            'kit_detalle.id',
            'kit_id',
            'producto_id',
            'cantidad',
            'precio',
            DB::raw('CONCAT(productos.descripcion, " ", marcas.nombre) AS descripcion, cantidad * productos.p_costo AS total')
        ])
        ->where('kit_id', Input::get('kit_id'))
        ->join('productos', 'kit_detalle.producto_id', '=', 'productos.id')
        ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
        ->get();

        foreach ($detalle as $dt) {
            $dt->precio = (float)($dt->precio);
            $dt->total = (float)($dt->total);
            $dt->cantidad = (int)($dt->cantidad);
        }

        return $detalle;
    }

    public function removeItem()
    {
        if (KitDetalle::destroy(Input::get('id')))
            return Success::true();

        return Success::false();
    }

    public function endKit()
    {
        $detalle = Input::get('detalle');

        foreach ($detalle as $dt)
        {
            $query = Existencia::whereProductoId($dt['producto_id'])
            ->whereTiendaId($this->tienda_id)
            ->first();

            if ($query->existencia < $dt['cantidad'])
            {
                return Response::json(array(
                    'success' => false,
                    'msg' => "La cantidad [". f_num::get($dt['cantidad']) ."] del producto<br/>". $dt['descripcion']."<br/>es mayor a la cantidad en existencia [". $query->existencia . "]..."
                ));
            }
        }

        $this->updateKit();
        $this->updateProducto();
        $this->updateExistencia();
        $this->updateExistenciaFromDetalle($detalle);

        return Success::true();
    }

    public function updateKit()
    {
        $kit = Kit::find(Input::get('kit_id'));
        $kit->completed = 1;
        $kit->precio = Input::get('total') / Input::get('kit_cantidad');
        $kit->producto_id = Input::get('kit_producto_id');
        $kit->cantidad = Input::get('kit_cantidad');
        $kit->save();
    }

    public function updateProducto()
    {
        $producto = Producto::find(Input::get('kit_producto_id'));
        $kit_precio = Input::get('total') / Input::get('kit_cantidad');
        $kit_cantidad = Input::get('kit_cantidad');

        $precioPromedio = (($producto->p_costo * $producto->existencia) + ($kit_precio * $kit_cantidad)) / ($producto->existencia + $kit_cantidad);

        $producto->p_costo = $precioPromedio;
        $producto->save();
    }

    public function updateExistencia()
    {
        $existencia = Existencia::whereProductoId(Input::get('kit_producto_id'))
        ->whereTiendaId($this->tienda_id)->first();

        $existencia->existencia += Input::get('kit_cantidad');
        $existencia->save();
    }

    public function updateExistenciaFromDetalle($detalle)
    {
        foreach ($detalle as $dt)
        {
            $existencia = Existencia::whereProductoId($dt['producto_id'])
            ->whereTiendaId($this->tienda_id)
            ->first();

            $existencia->existencia -= $dt['cantidad'];
            $existencia->save();
        }
    }

    public function historial_kits()
    {
        return View::make('kits::historial_kits')->render();
    }

    public function historial_kits_DT()
    {
        $table = 'kits';

        $columns = [
            "kits.created_at as fecha",
            "CONCAT_WS(' ', users.nombre, users.apellido) as usuario",
            "productos.descripcion as producto",
            "cantidad",
            "precio",
            "observaciones",
            "completed"
        ];

        $Search_columns = [
            "users.nombre",
            "users.apellido",
            "productos.descripcion",
            'kits.created_at'
        ];

        $where = "kits.tienda_id = {$this->tienda_id}";
        $Join = "JOIN users ON (users.id = kits.user_id) JOIN productos ON (productos.id = kits.producto_id)";

        return TableSearch::get($table, $columns, $Search_columns, $Join, $where );
    }

    public function getDetalle()
    {
        $detalle = DB::table('kit_detalle')
        ->select([
            'kit_id',
            'producto_id',
            'cantidad',
            'precio',
            DB::raw('CONCAT(productos.descripcion," ", marcas.nombre) AS descripcion, cantidad * precio AS total')
        ])
        ->where('kit_id', Input::get('kit_id'))
        ->join('productos', 'kit_detalle.producto_id', '=', 'productos.id')
        ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
        ->get();

        return Response::json([
            'success' => true,
            'table'   => View::make('kits::detalle_historial_kits', compact('detalle'))->render()
        ]);
    }

    public function open_kit_no_finalizado()
    {
        $kit = Kit::find(Input::get('kit_id'));

        if ($kit->completed == 1)
            return json_encode('El combo no se puede abrir porque ya fue finalizado');

        $kit_id = $kit->id;
        $kit_cantidad = $kit->cantidad;
        $detalle  = json_encode($this->getKitDetalle());

        $producto = Producto::with('marca')->whereId($kit->producto_id)->first();

        $data = [
            'id'             =>  $producto->id,
            'descripcion'    =>  $producto->descripcion . PHP_EOL . $producto->marca->nombre,
            'precio_costo'   =>  $producto->p_costo,
            'precio_publico' =>  $producto->p_publico,
            'existencia'     =>  $producto->existencia
        ];

        $producto = json_encode($data);

        return Response::json(array(
            'success' => true,
            'form' => View::make('kits::create', compact('kit_id', 'kit_cantidad', 'detalle', 'producto'))->render()
        ));
    }

    public function findProducto()
    {
        $codigo = preg_replace('/\s{2,}/', ' ', trim(Input::get('codigo')));
        $producto = Producto::with('marca')->whereCodigo($codigo)->first();

        if($producto) {
            if (Input::has('kit_id')) {
                if (Input::get('evento') == 'master') {
                    $kit = Kit::find(Input::get('kit_id'));
                    $kit->producto_id = $producto->id;
                    $kit->save();
                }
            }

            return [
                'success' => true,
                'values'  => [
                    'id'             => $producto->id,
                    'descripcion'    => $producto->descripcion . PHP_EOL . $producto->marca->nombre,
                    'precio_publico' => $producto->p_publico,
                    'precio_costo'   => $producto->p_costo,
                    'existencia'     => $producto->existencia
                ]
            ];
        }
    }

    public function updateCantidad()
    {
        if ($this->check_existencia())
            return "La cantidad que esta ingresando es mayor a la cantidad en existencia..";

        if (KitDetalle::find(Input::get('id'))->update(array('cantidad' => Input::get('cantidad'))))
            return Response::json(array('success' => true, 'detalle' => $this->getKitDetalle()));
    }
}

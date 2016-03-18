<?php namespace App\kits;

use Input, View, Auth, Response, Producto, Kit;

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

            return 33;
		}

		return Response::json(array(
			'success' => true,
			'form' => View::make('kits::create')->render()
        ));
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
}
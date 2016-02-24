<?php namespace App\ventas;

use Input, View, Venta, Response, Success, DetalleVenta, Existencia, DB, TableSearch, Auth, Producto, MetodoPago, PagosVenta, Caja;

class VentasController extends \BaseController {

	public function create()
	{
		if (Input::has('_token'))
		{
			$venta = new Venta;

			$data = Input::all();

			if (!$venta->create_master($data))
			{
				return $venta->errors();
			}

			$venta_id = $venta->get_id();

			return Response::json(array(
				'success' => true,
				'detalle' => View::make('ventas::detalle', compact('venta_id'))->render()
            ));
		}

		return View::make('ventas::create');
	}

    public function findProducto()
    {
        $codigo = preg_replace('/\s{2,}/', ' ', trim(Input::get('codigo')));

        if (!$codigo)
            return 'El campo codigo se encuentra vacio...!';

        $producto = Producto::with('marca')->whereCodigo($codigo)->first();

        if(!$producto)
            return 'El codigo que buscas no existe..!';

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

    public function table_productos_para_venta()
    {
        return View::make('ventas::table_productos_para_venta');
    }

    public function table_productos_para_venta_DT()
    {
        $table = 'productos';

        $columns = array(
            "codigo",
            "nombre",
            "descripcion",
            "p_publico",
            "existencias.existencia as existencia",
            "productos.existencia as existencia_total"
        );

        $Searchable = array("codigo", "nombre", "descripcion");
        $Join = 'JOIN marcas ON productos.marca_id = marcas.id JOIN existencias ON productos.id = existencias.producto_id';
        $where = "tienda_id =". Auth::user()->tienda_id;

        echo TableSearch::get($table, $columns, $Searchable, $Join, $where);
    }

    public function postVentaDetalle()
    {
		if ($this->check_if_code_exists_in_this_venta())
			return "El codigo ya ha sido ingresado..";

		if ($this->check_existencia())
			return "La cantidad que esta ingresando es mayor a la cantidad en existencia..";

		Input::merge(array('precio' => str_replace(',', '', Input::get('precio'))));

		$query = new DetalleVenta;

		if ( !$query->SaleItem())
		{
			return $query->errors();
		}

		return Response::json(array(
			'success' => true,
			'detalle' => $this->getVentaDetalle()
        ));
    }

    public function check_if_code_exists_in_this_venta()
    {
		$query = DB::table('detalle_ventas')->select('id')
	    ->where('venta_id', Input::get("venta_id"))
	    ->where('producto_id', Input::get("producto_id"))
	    ->first();

	    if($query == null)
	    	return false;

	    return true;
    }

    public function check_existencia()
    {
    	Input::merge(array('cantidad' => str_replace(',', '', Input::get('cantidad'))));

	    $query = Existencia::whereProductoId(Input::get('producto_id'))->whereTienda_id(Auth::user()->tienda_id)->first();

	    if ($query == null || $query->existencia < Input::get('cantidad'))
	    	return true;

	    return false;
    }

	public function getVentaDetalle()
	{

		$detalle = DB::table('detalle_ventas')
        ->select(array(
        	'detalle_ventas.id',
        	'venta_id',
        	'producto_id',
        	'cantidad',
        	'precio',
        	'serials',
        	DB::raw('CONCAT(productos.descripcion, " ", marcas.nombre) AS descripcion, cantidad * precio AS total') ))
        ->where('venta_id', Input::get('venta_id'))
        ->join('productos', 'detalle_ventas.producto_id', '=', 'productos.id')
        ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
        ->get();

        foreach ($detalle as $dt) {
        	$dt->precio = (float)($dt->precio);
        	$dt->total = (float)($dt->total);
        	$dt->cantidad = (int)($dt->cantidad);
        	if ($dt->serials) {
        		$dt->serials = explode(',', $dt->serials);
        	}
        }

        return $detalle;
	}

	public function getSerialsForm()
	{
		$serials = json_encode(Input::get('serials'));
		$serial_index = Input::get('serial_index'); // Index del producto que se esta modificando para actualizar los seriales

		return Response::json(array(
			'success' => true,
			'view' => View::make('ventas::serialsForm', compact('serials', 'serial_index'))->render()
		));
	}

	public function detalle_venta_serie_add()
	{
		$dd = DetalleVenta::find(Input::get('detalle_venta_id'));

		if ($dd->serials)
			$dd->serials = $dd->serials .','.Input::get('serie');

		else
			$dd->serials = Input::get('serie');

		$dd->save();

		return Success::true();
	}

	public function detalle_venta_serie_delete()
	{
		$dd = DetalleVenta::find(Input::get('detalle_venta_id'));
	    $dd->serials = implode(",", array_diff(explode(",", $dd->serials), array(Input::get('serie'))));
	    $dd->save();

	    return Success::true();
	}

	public function eliminarVenta()
	{
		if (Venta::destroy(Input::get('id')))
			return Success::true();

		return 'Hubo un error al tratar de eliminar';
	}

    public function removeItem()
    {
		if (DetalleVenta::destroy(Input::get('id')))
			return Success::true();

		return 'Hubo un error al tratar de eliminar';
    }

    public function UpdateDetalle()
    {
		if ($this->check_existencia())
			return "La cantidad que esta ingresando es mayor a la cantidad en existencia..";

		$update = DB::table('detalle_ventas')->whereId(Input::get('id'))
            ->update(array(
	        	'cantidad' => Input::get('cantidad'),
	        	'precio'   => Input::get('precio')
            ));

        if ($update) {
        	return Response::json(array(
				'success' => true,
				'detalle' => $this->getVentaDetalle()
        	));
        }
    }

    public function paymentForm()
    {
    	if (Input::has('_token'))
    	{
			$venta = Venta::find(Input::get('venta_id'));
			$venta->completed = 1;
			$venta->saldo = $saldo;
			$venta->caja_id = $caja->id;
			$venta->total = $total->total;
    	}

        $values = DB::table('metodo_pago')->where('id', '<', 6)->select('id', 'descripcion')->get();

        $i=0;
        foreach ($values as $value) {
            $paymentsOptions[$i]['value'] = $value->id;
            $paymentsOptions[$i]['text'] = $value->descripcion;
            $i++;
        }

        $paymentsOptions = json_encode($paymentsOptions);

        return  Response::json(array(
        	'success' => true,
        	'detalle' => View::make('ventas::paymentForm', compact('paymentsOptions'))->render()
        ));
    }

    public function endSale()
    {
    	$insert = DB::table('pagos_ventas')->insert(Input::get('payments'));

    	if (!$insert) return Success::false();

		$caja = Caja::whereUserId(Auth::user()->id)->first();

        $update = DB::table('ventas')->whereId(Input::get('venta_id'))
        ->update(array(
        	'completed' => 1,
        	'saldo'     => Input::get('saldo'),
        	'total'     => Input::get('total'),
        	'caja_id'   => $caja->id
        ));

        if ($update) return Success::true();

        DB::table('pagos_ventas')->whereVentaId(Input::get('venta_id'))->delete();

        return Success::false();
    }

}
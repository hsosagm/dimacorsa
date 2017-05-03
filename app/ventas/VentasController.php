<?php namespace App\ventas;

use Input, View, Venta, Response, Success, DetalleVenta, Existencia, DB, TableSearch, Auth, Producto, MetodoPago, PagosVenta, Caja, Kardex, ClienteController, f_num, Carbon, Convertidor;

class VentasController extends \BaseController {

    protected $tienda_id;

    public function __construct()
    {
        $this->tienda_id = Auth::user()->tienda_id;
    }

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
            $caja = Caja::whereUserId(Auth::user()->id)->first();

			return Response::json(array(
				'success' => true,
				'detalle' => View::make('ventas::detalle', compact('venta_id', 'caja'))->render()
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
        $where = "tienda_id =". $this->tienda_id;

        echo TableSearch::get($table, $columns, $Searchable, $Join, $where);
    }

    public function postVentaDetalle()
    {
        Input::merge(array('precio' => str_replace(',', '', Input::get('precio'))));

        $Existencia = Existencia::whereProductoId(Input::get('producto_id'))->whereTiendaId($this->tienda_id)->first();

        $productoIngresado = DB::table('detalle_ventas')->select('id', 'cantidad')
        ->where('venta_id', Input::get("venta_id"))
        ->where('producto_id', Input::get("producto_id"))
        ->first();

        if ($productoIngresado) {
            Input::merge(array('cantidad' => str_replace(',', '', Input::get('cantidad'))));

            $cantidadSolicitada = Input::get('cantidad') + $productoIngresado->cantidad;

            if ($Existencia == null || $Existencia->existencia < $cantidadSolicitada)
                return "La cantidad que esta ingresando es mayor a la cantidad en existencia..";

            if (DB::table('detalle_ventas')->whereId($productoIngresado->id)->increment('cantidad')) {
                return Response::json(array(
                    'success' => true,
                    'detalle' => $this->getVentaDetalle()
                ));
            }

        } else {
            if ($Existencia == null || $Existencia->existencia < Input::get('cantidad'))
                return "La cantidad que esta ingresando es mayor a la cantidad en existencia..";

            $query = new DetalleVenta;

            if (!$query->SaleItem())
                return $query->errors();

            return Response::json(array(
                'success' => true,
                'detalle' => $this->getVentaDetalle()
            ));
        }

    }

  //   public function check_if_code_exists_in_this_venta()
  //   {
		// $query = DB::table('detalle_ventas')->select('id')
	 //    ->where('venta_id', Input::get("venta_id"))
	 //    ->where('producto_id', Input::get("producto_id"))
	 //    ->first();

	 //    if ($query == null)
	 //    	return false;

	 //    return true;
  //   }

    public function check_existencia()
    {
    	Input::merge(array('cantidad' => str_replace(',', '', Input::get('cantidad'))));

	    $query = Existencia::whereProductoId(Input::get('producto_id'))->whereTiendaId($this->tienda_id)->first();

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
        $notasDeCredito = DB::table('notas_creditos')
            ->select("id", "created_at", "monto", "estado")
            ->whereClienteId(Input::get('cliente_id'))
            ->whereEstado(0)->first();

        ($notasDeCredito)? $countNotasCredito = json_encode(true): $countNotasCredito = json_encode(false);

        $countNotasCredito = DB::table('notas_creditos')
        ->whereClienteId(Input::get('cliente_id'))
        ->whereEstado(0)->count();

        $paymentsOptions = MetodoPago::select('id as value', 'descripcion as text')->where('id', '<', 6)->get();

        return Response::json(array(
        	'success' => true,
        	'detalle' => View::make('ventas::paymentForm', compact('paymentsOptions', 'countNotasCredito'))->render()
        ));
    }

    public function endSale()
    {
        $detalleVenta = Input::get('detalleVenta');

        foreach ($detalleVenta as $dv)
        {
            $query = Existencia::whereProductoId($dv['producto_id'])
            ->whereTiendaId($this->tienda_id)->first();

            if ($query->existencia < $dv['cantidad'])
            {
                return Response::json(array(
                    'success' => false,
                    'msg' => "La cantidad [". f_num::get($dv['cantidad']) ."] del producto<br/>". $dv['descripcion']."<br/>es mayor a la cantidad en existencia [". $query->existencia . "]..."
                ));
            }
        }

        foreach (Input::get('payments') as $payment) {
            $pv = new PagosVenta;
            $pv->monto = $payment['monto'];
            $pv->metodo_pago_id = $payment['metodo_pago_id'];
            $pv->venta_id = $payment['venta_id'];
            $pv->save();
        }

        if (count(Input::get('notasDeCredito'))) {
            foreach ( Input::get('notasDeCredito') as $notas) {
               $updateNotas = DB::table('notas_creditos')
                ->whereId($notas['id'])
                ->update(array(
                    'estado' => 1,
                    'venta_id' => Input::get('venta_id'),
                    'updated_at' => Carbon::now()
                ));
            }
        }

        $caja = Caja::whereUserId(Auth::user()->id)->first();

        $venta = Venta::find(Input::get('venta_id'));
        $venta->completed = 1;
        $venta->saldo = Input::get('saldo');
        $venta->total = Input::get('total');

        if (Auth::user()->tienda->cajas)
            $venta->caja_id = $caja->id;

        foreach ($detalleVenta as $dv)
        {
            $existencia = Existencia::whereProductoId($dv['producto_id'])->whereTiendaId($this->tienda_id)->first();
            $existencia->existencia -= $dv['cantidad'];
            $existencia->save();
        }

        DB::table('detalle_ventas')->whereVentaId(Input::get('venta_id'))
        ->update(array(
            'ganancias' => DB::raw('precio - (select p_costo from productos where id = producto_id)')
        ));

        $venta->save();

        return Success::true();
    }


    public function openSale()
    {
        $venta = Venta::find(Input::get('venta_id'));

        if ($venta->completed == 1)
            return json_encode('La venta no se puede abrir porque ya fue finalizada');

        if ($venta->completed == 2)
            $venta->update(array('completed' => 0, 'saldo' => 0 , 'kardex' => 0));

        $cliente = ClienteController::getInfo($venta->cliente_id);
        $venta_id = Input::get('venta_id');
        $detalle = json_encode($this->getVentaDetalle());
        $caja = Caja::whereUserId(Auth::user()->id)->first();

        return Response::json(array(
            'success' => true,
            'table' => View::make('ventas::unfinishedSale', compact('cliente', 'venta_id', 'detalle', 'caja'))->render()
        ));
    }

    public function notasDeCredito()
    {
        $notasCreditos = DB::table('notas_creditos')
        ->select("id", "created_at", "monto", "estado")
        ->whereClienteId(Input::get('cliente_id'))
        ->whereEstado(0)->get();

        if(!count($notasCreditos))
            return "El cliente no tiene notas de credito para asignarse..!";

        return Response::json(array(
            'success' => true,
            'notasDeCredito' => $notasCreditos
        ));
    }

    public function enviarACaja()
    {
        $venta = Venta::find(Input::get('venta_id'));
        $total = DetalleVenta::whereVentaId(Input::get('venta_id'))
        ->first(array(DB::raw('sum(cantidad * precio) as total')))->total;

        if (!$total)
            return "Ingresa productos a la venta para poder enviarla...";

        if ($venta->completed == 1)
            return 'La venta que intentas enviar ya fue finalizada...';

            $venta->completed = 2;
            $venta->total = $total;

        if (!$venta->save())
            return 'Hubo un error intentelo de nuevo';

        return Success::true();
    }

    function printInvoice()
    {
        $venta = Venta::with('cliente', 'detalle_venta')->find(Input::get('venta_id'));

        if (!count($venta)) {
            return Response::json( array(
                'success' => false,
                'msg' => "No se encontro ninguna venta",
            ));
        }

        if (count($venta->detalle_venta) > 0)
        {
            $i=0;
            $total=0;

            foreach ($venta->detalle_venta as $dt)
            {
                $descripcion = $dt->producto->marca->nombre . " " . $dt->producto->descripcion;
                $len = mb_strlen($descripcion);

                if ($len > 38) {
                    $substr = $len - 38;
                    $descripcion = substr($descripcion, 0, -$substr);
                } else {
                    $descripcion = $descripcion;
                }

                $descripcion = $this->clear($descripcion);

                $total = $total + ($dt->cantidad * $dt->precio);
                $len1 = mb_strlen($dt->cantidad);
                $len2 = mb_strlen($descripcion);

                $precio = f_num::get($dt->precio);
                $totales = f_num::get($dt->cantidad * $dt->precio);

                $len3 = mb_strlen($precio);
                $len4 = mb_strlen($totales);
                $e1 = "    ";
                $e1 = substr($e1, 0, -$len1);
                $e2 = "                                                ";
                $e2 = substr($e2, 0, -$len2);
                $e2 = substr($e2, 0, -$len3);
                $e3 = "           ";
                $e3 = substr($e3, 0, -$len4);

                $detalle[$i]['descripcion'] =  $e1 . $dt->cantidad . " " . $descripcion . $e2 . $precio . $e3 . $totales;
                $i++;
            }

            $convertir = new Convertidor;

            $totalEnLetras = $convertir->ConvertirALetras($total);

            $e4 = "                                                                                                                      ";
            $total_venta = f_num::get($total);
            $len5 = mb_strlen($total_venta);
            $e4 = substr($e4, 0, -$len5);

            return Response::json( array(
                'success' => true,
                'fecha' => date('d-m-Y') . " " . Carbon::now()->toTimeString(),
                'nit' => "  Nit: ".$venta->cliente->nit,
                'cliente' => "  Cliente: ".$venta->cliente->nombre . " " .$venta->cliente->apellido,
                'direccion' => "  Direccion: ". $venta->cliente->direccion,
                'detalle' => $detalle,
                'total_letras' => "                      ".$totalEnLetras,
                'total' => " Total   " . $total_venta,
                'user' =>  " Le atendio:   " . Auth::user()->nombre . " " . Auth::user()->apellido,
            ));
        }
        else {
            return Response::json( array(
                'success' => false,
                'msg' => "Debe ingresar algun producto para poder imprimir"
            ));
        }
    }

    function clear($string)
    {
        $string = trim($string);
        $string = str_replace( array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $string );
        $string = str_replace( array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $string );
        $string = str_replace( array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $string );
        $string = str_replace( array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $string );
        $string = str_replace( array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $string );
        $string = str_replace( array('ñ', 'Ñ', 'ç', 'Ç'), array('n', 'N', 'c', 'C',), $string );

       return $string;
    }

}

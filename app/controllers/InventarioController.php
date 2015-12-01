<?php

class InventarioController extends Controller {

    public function getInventario()
    {
        return View::make('inventario.inventario');
    }

    public function dt_getInventario()
    {
        $table = 'existencias';

        $columns = array(
            "producto_id",
            "codigo",
            "marcas.nombre as marca",
            "descripcion",
            "existencias.existencia as existencia",
            "existencia_real",
            "ajuste",
            "existencias.status as status",
            "(select nombre from users where id = existencias.user_id) as usuario"
        );

        $Searchable = array("producto_id", "codigo", "nombre", "descripcion");
        $Join = 'JOIN productos ON existencias.producto_id = productos.id JOIN marcas ON productos.marca_id = marcas.id';
        $where = "existencias.ajuste < 0 AND existencias.tienda_id = ".Auth::user()->tienda_id; //1
        //$where = "existencias.status > 0 AND existencias.tienda_id = ".Auth::user()->tienda_id; //2
        //$where = "existencias.tienda_id = ".Auth::user()->tienda_id; //3

        echo TableSearch::get($table, $columns, $Searchable, $Join ,$where );
    }

    //UPDATE `existencias` SET `status` = 0 WHERE 1
    //UPDATE `existencias` SET `existencia_real` = null WHERE 1;
    //UPDATE `existencias` SET `ajuste` = null WHERE 1;
    //UPDATE `existencias` SET `user_id` = null WHERE 1;
    public function setExistencia()
    {
    	$existencia = Existencia::where('producto_id', Input::get('id'))
        ->where('tienda_id', Auth::user()->tienda_id)
        ->first();

		if ( $existencia )
		{
            $cantidad_ajuste = Input::get('cantidad') - $existencia->existencia;
            $producto_id = $existencia->producto_id;

            $existencia->ajuste =  Input::get('cantidad') - $existencia->existencia;
            $existencia->existencia_real = Input::get('cantidad');
            $existencia->existencia = Input::get('cantidad');
            $existencia->status = 1;
            $existencia->user_id = Auth::user()->id;
            $existencia->save();

            if ($cantidad_ajuste != 0) {
                $this->setKardex($existencia->id, $producto_id, $cantidad_ajuste);
            }

	        return Response::json(array('success' => true ));
		}
		else
		{
		    return Response::json(array('success' => false, 'msg' => 'Uvo un error intentelo de nuevo'));
		}
    }

    public function getStockMinimo()
    {
        $stockMinimo = Producto::select(
            DB::raw('productos.id as producto_id'),
            DB::raw('productos.descripcion as descripcion'),
            DB::raw('marcas.nombre as marca'),
            DB::raw('categorias.nombre as categoria'),
            DB::raw('productos.stock_minimo as existencia_minima'),
            DB::raw('existencias.existencia as existencia')
        )
        ->whereRaw('existencias.existencia <= stock_minimo')
        ->join('existencias', 'producto_id', '=', 'productos.id')
        ->join('marcas', 'marca_id', '=', 'marcas.id')
        ->join('categorias', 'categoria_id', '=', 'categorias.id')
        ->where('stock_minimo', '!=', 0)
        ->whereTiendaId(Auth::user()->tienda_id)
        ->get();

        return  Response::json(array(
            'success' => true,
            'table' => View::make('producto.stockMinimo', compact('stockMinimo'))->render()
        ));
    }

    public function setKardex($transaccion_id, $producto_id, $cantidad)
    {

        $existencia = Existencia::whereProductoId($producto_id)->first(array(DB::raw('sum(existencia) as total')));
        $producto = Producto::find($producto_id);

        $kardex = new Kardex;
        $kardex->tienda_id = Auth::user()->tienda_id;
        $kardex->user_id = Auth::user()->id;
        $kardex->kardex_accion_id = 2;
        $kardex->producto_id = $producto_id;
        $kardex->kardex_transaccion_id = 6;
        $kardex->transaccion_id = $transaccion_id;

        if($cantidad > 0) {
            $kardex->evento = 'ingreso';
            $kardex->cantidad = $cantidad;
        }
        else {
            $kardex->evento = 'salida';
            $kardex->cantidad = ($cantidad * -1);
        }

        $kardex->existencia = $existencia->total;
        $kardex->costo = ($producto->p_costo/100);
        $kardex->costo_promedio = ($producto->p_costo/100);
        $kardex->save();
    }
}

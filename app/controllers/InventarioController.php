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
        // $where = "existencias.existencia > 0 AND existencias.tienda_id = ".Auth::user()->tienda_id;
        // $where = "existencias.status > 0 AND existencias.tienda_id = ".Auth::user()->tienda_id;
        $where = "existencias.tienda_id = ".Auth::user()->tienda_id;

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
            $existencia->ajuste =  Input::get('cantidad') - $existencia->existencia;
            $existencia->existencia_real = Input::get('cantidad');
            $existencia->existencia = Input::get('cantidad');
            $existencia->status = 1;
            $existencia->user_id = Auth::user()->id;
            $existencia->save();

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

}

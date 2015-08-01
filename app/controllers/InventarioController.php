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
        $where = "existencias.status > 0 AND existencias.tienda_id = ".Auth::user()->tienda_id;

        echo TableSearch::get($table, $columns, $Searchable, $Join ,$where );
    }


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

}

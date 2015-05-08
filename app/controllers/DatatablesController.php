<?php

class DatatablesController extends Controller {

	public function index()
	{
		$table = 'productos';

		$columns = array("codigo","nombre","descripcion","p_costo","p_publico");

		$Searchable = array("codigo","nombre","descripcion");
		
		$Join = 'JOIN marcas ON productos.marca_id = marcas.id';

		echo TableSearch::get($table, $columns, $Searchable, $Join);
	}

	public function md_search()
	{
		$table = 'productos';

		$columns = array("codigo","nombre","descripcion","existencia","p_publico");

		$Searchable = array("codigo","nombre","descripcion");
		
		$Join = 'JOIN marcas ON productos.marca_id = marcas.id';

		echo TableSearch::get($table, $columns, $Searchable, $Join);
	}

	public function users()
	{
		$table = 'users';

		$columns = array("username","nombre","apellido","email","tienda_id","status");

		$Searchable = array("username","nombre","apellido","email","tienda_id","status");

		echo TableSearch::get($table, $columns, $Searchable);
	}


	public function proveedores()
	{
		$table = 'proveedores';

		$columns = array("nombre","direccion","telefono","nit");

		$Searchable = array("nombre","direccion","telefono");

		echo TableSearch::get($table, $columns, $Searchable);
	}

	public function user_inventario()
	{
		$table = 'productos';

		$columns = array("codigo","nombre","descripcion","p_publico");

		$Searchable = array("codigo","nombre","descripcion");
		
		$Join = 'JOIN marcas ON productos.marca_id = marcas.id  Join  existencias ON productos.id = existencias.producto_id ';

		$where = "tienda_id = ".Auth::user()->tienda_id;

		$table_two = "existencias.existencia as existencia";

		echo TableSearch::get($table, $columns, $Searchable, $Join ,$where , $table_two);
	}


	
}

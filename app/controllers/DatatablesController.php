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

	public function clientes()
	{
		$table = 'clientes';

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

		$where = "tienda_id = ".Auth::user()->tienda_id.' AND productos.existencia > 0';

		$table_two = "existencias.existencia as existencia";

		echo TableSearch::get($table, $columns, $Searchable, $Join ,$where , $table_two);
	}

	public function ComprasPendientesDePago()
	{

		$table = 'compras';

		$columns = array("fecha_documento","numero_documento","completed","saldo");

		$Searchable = array("users.nombre","users.apellido","fecha_documento","numero_documento");

		$Join = "JOIN users ON (users.id = compras.user_id) JOIN proveedores ON (proveedores.id = compras.proveedor_id)";

		$where = " proveedor_id = ".Input::get('proveedor_id')." AND saldo > 0";

		$opcion1 = "Ver Detalle";

		$opcion2 = "Abonar";

		$others_columns = array(
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			'proveedores.nombre as proveedor_nombre');
		
		$pos_columns = 1;

		$url = null;

		echo TableSearchMaster::get($table, $columns, $Searchable, $Join, $where,$url , $opcion1 , $opcion2 ,$others_columns , $pos_columns);
	}

	public function Purchase_dt()
	{

		$table = 'compras';

		$columns = array("fecha_documento","numero_documento","completed","saldo");

		$Searchable = array("users.nombre","users.apellido","fecha_documento","numero_documento");

		$Join = "JOIN users ON (users.id = compras.user_id) JOIN proveedores ON (proveedores.id = compras.proveedor_id)";

		$where = " proveedor_id = ".Input::get('proveedor_id');

		$opcion1 = "Ver Detalle";

		$opcion2 = "Ver Factura";

		$others_columns = array(
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			'proveedores.nombre as proveedor_nombre');
		
		$pos_columns = 1;

		$url = null;

		echo TableSearchMaster::get($table, $columns, $Searchable, $Join, $where,$url , $opcion1 , $opcion2 ,$others_columns , $pos_columns);
	}

	function SalesDay_dt(){

		$table = 'ventas';

		$columns = array("numero_documento","completed","saldo");

		$Searchable = array("users.nombre","users.apellido","numero_documento","clientes.nombre","clientes.apellido");

		$Join = "JOIN users ON (users.id = ventas.user_id) JOIN clientes ON (clientes.id = ventas.cliente_id)";

		$where = " DATE_FORMAT(ventas.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d')";

		$opcion1 = "Ver Detalle";

		$opcion2 = 'Ver Factura';

		$others_columns = array(
			"ventas.created_at as fecha",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"CONCAT_WS(' ',clientes.nombre,clientes.apellido) as cliente_nombre");
		
		$pos_columns = 1;

		$url = null;

		echo TableSearchMaster::get($table, $columns, $Searchable, $Join, $where,$url , $opcion1 , $opcion2 ,$others_columns , $pos_columns);	
	}
	 			
	function PurchaseDay_dt(){

		$table = 'compras';

		$columns = array("numero_documento","total","saldo");

		$Searchable = array("users.nombre","users.apellido","numero_documento","proveedores.nombre");

		$Join = "JOIN users ON (users.id = compras.user_id) JOIN proveedores ON (proveedores.id = compras.proveedor_id)";

		$where = " DATE_FORMAT(compras.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d')";

		$opcion1 = "Ver Detalle";

		$opcion2 = 'Ver Factura';

		$others_columns = array(
			"compras.created_at as fecha",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"proveedores.nombre as proveedor_nombre");
		
		$pos_columns = 1;

		$url = 'admin/compras/';

		echo TableSearchMaster::get($table, $columns, $Searchable, $Join, $where, $url, $opcion1 , $opcion2 ,$others_columns , $pos_columns);	
	}
	
	function SupportDay_dt(){

		$table = 'detalle_soporte';

		$columns = array('monto');

		$Searchable = array("users.nombre","users.apellido");

		$Join = "JOIN soporte ON (soporte.id = detalle_soporte.soporte_id) 
				 JOIN users ON (users.id = soporte.user_id)
				 JOIN tiendas ON (tiendas.id = soporte.tienda_id)
				 JOIN metodo_pago ON (metodo_pago.id = detalle_soporte.metodo_pago_id)";

		$where = " DATE_FORMAT(detalle_soporte.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d')";

		$opcion1 = 'Eliminar';

		$opcion2 = null;

		$others_columns = array(
			"tiendas.nombre as tienda_nombre",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"soporte.created_at as fecha",
			"detalle_soporte.descripcion as detalle_descripcion",
			"metodo_pago.descripcion as metodo_descripcion");
		
		$pos_columns = 1;

		$url = null;

		echo TableSearchMaster::get($table, $columns, $Searchable, $Join, $where,$url , $opcion1 , $opcion2 ,$others_columns , $pos_columns);	
	}
	 	
	function ExpensesDay_dt(){

		$table = 'detalle_gastos';

		$columns = array('monto');

		$Searchable = array("users.nombre","users.apellido");

		$Join = "JOIN gastos ON (gastos.id = detalle_gastos.gasto_id) 
				 JOIN users ON (users.id = gastos.user_id)
				 JOIN tiendas ON (tiendas.id = gastos.tienda_id)
				 JOIN metodo_pago ON (metodo_pago.id = detalle_gastos.metodo_pago_id)";

		$where = " DATE_FORMAT(detalle_gastos.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d')";

		$opcion1 = 'Eliminar';

		$opcion2 = null;

		$others_columns = array(
			"tiendas.nombre as tienda_nombre",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"gastos.created_at as fecha",
			"detalle_gastos.descripcion as detalle_descripcion",
			"metodo_pago.descripcion as metodo_descripcion");
		
		$pos_columns = 1;

		$url = null;

		echo TableSearchMaster::get($table, $columns, $Searchable, $Join, $where,$url , $opcion1 , $opcion2 ,$others_columns , $pos_columns);	
	}
	 
	function ExpendituresDay_dt(){

		$table = 'detalle_egresos';

		$columns = array('monto');

		$Searchable = array("users.nombre","users.apellido");

		$Join = "JOIN egresos ON (egresos.id = detalle_egresos.egreso_id) 
				 JOIN users ON (users.id = egresos.user_id)
				 JOIN tiendas ON (tiendas.id = egresos.tienda_id)
				 JOIN metodo_pago ON (metodo_pago.id = detalle_egresos.metodo_pago_id)";

		$where = " DATE_FORMAT(detalle_egresos.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d')";

		$opcion1 = 'Eliminar';

		$opcion2 = null;

		$others_columns = array(
			"tiendas.nombre as tienda_nombre",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"egresos.created_at as fecha",
			"detalle_egresos.descripcion as detalle_descripcion",
			"metodo_pago.descripcion as metodo_descripcion");
		
		$pos_columns = 1;

		$url = null;

		echo TableSearchMaster::get($table, $columns, $Searchable, $Join, $where,$url , $opcion1 , $opcion2 ,$others_columns , $pos_columns);	
	}
	
	function IncomeDay_dt(){

		$table = 'detalle_ingresos';

		$columns = array('monto');

		$Searchable = array("users.nombre","users.apellido");

		$Join = "JOIN ingresos ON (ingresos.id = detalle_ingresos.ingreso_id) 
				 JOIN users ON (users.id = ingresos.user_id)
				 JOIN tiendas ON (tiendas.id = ingresos.tienda_id)
				 JOIN metodo_pago ON (metodo_pago.id = detalle_ingresos.metodo_pago_id)";

		$where = " DATE_FORMAT(detalle_ingresos.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d')";

		$opcion1 = 'Eliminar';

		$opcion2 = null;

		$others_columns = array(
			"tiendas.nombre as tienda_nombre",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"ingresos.created_at as fecha",
			"detalle_ingresos.descripcion as detalle_descripcion",
			"metodo_pago.descripcion as metodo_descripcion");
		
		$pos_columns = 1;

		$url = null;

		echo TableSearchMaster::get($table, $columns, $Searchable, $Join, $where,$url , $opcion1 , $opcion2 ,$others_columns , $pos_columns);	
	}

	function AdvancesDay_dt(){

		$table = 'detalle_adelantos';

		$columns = array('monto');

		$Searchable = array("users.nombre","users.apellido");

		$Join = "JOIN adelantos ON (adelantos.id = detalle_adelantos.adelanto_id) 
				 JOIN users ON (users.id = adelantos.user_id)
				 JOIN tiendas ON (tiendas.id = adelantos.tienda_id)
				 JOIN metodo_pago ON (metodo_pago.id = detalle_adelantos.metodo_pago_id)";

		$where = " DATE_FORMAT(detalle_adelantos.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d')";

		$opcion1 = 'Eliminar';

		$opcion2 = null;

		$others_columns = array(
			"tiendas.nombre as tienda_nombre",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"adelantos.created_at as fecha",
			"detalle_adelantos.descripcion as detalle_descripcion",
			"metodo_pago.descripcion as metodo_descripcion");
		
		$pos_columns = 1;

		$url = null;

		echo TableSearchMaster::get($table, $columns, $Searchable, $Join, $where,$url , $opcion1 , $opcion2 ,$others_columns , $pos_columns);	
	}

}

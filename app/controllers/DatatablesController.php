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

		$columns = array(
			"CONCAT_WS(' ',nombre,apellido) as cliente",
			"direccion","telefono","nit");

		$Searchable = array("nombre","direccion","telefono");

		echo TableSearch::get($table, $columns, $Searchable);
	}

	public function user_inventario()
	{
		$table = 'productos';

		$columns = array(
			"codigo",
			"nombre",
			"descripcion",
			"p_publico",
			"existencias.existencia as existencia");

		$Searchable = array("codigo","nombre","descripcion");
		
		$Join = 'JOIN marcas ON productos.marca_id = marcas.id  Join  existencias ON productos.id = existencias.producto_id ';
		$where = "tienda_id = ".Auth::user()->tienda_id.' AND productos.existencia > 0';

		echo TableSearch::get($table, $columns, $Searchable, $Join ,$where );
	}

	function SalesOfDay(){

		$table = 'ventas';

		$columns = array(
			"ventas.created_at as fecha", 
			"CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
			"CONCAT_WS(' ',clientes.nombre,clientes.apellido) as cliente",
			"numero_documento","completed",
			"saldo"
			);

		$Search_columns = array("users.nombre","users.apellido","numero_documento","clientes.nombre","clientes.apellido");

		$Join = "JOIN users ON (users.id = ventas.user_id) JOIN clientes ON (clientes.id = ventas.cliente_id)";

		$where = " DATE_FORMAT(ventas.created_at, '%Y-%m-%d') = DATE_FORMAT(current_date, '%Y-%m-%d')";

		echo TableSearch::get($table, $columns, $Search_columns, $Join, $where );	
	}

	function PurchaseDay_dt(){

		$table = 'compras';

		$columns = array(
			"compras.created_at as fecha",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"proveedores.nombre as proveedor_nombre",
			"numero_documento",
			"total",
			"saldo",
			"completed");

		$Search_columns = array("users.nombre","users.apellido","numero_documento","proveedores.nombre");

		$Join = "JOIN users ON (users.id = compras.user_id) JOIN proveedores ON (proveedores.id = compras.proveedor_id)";

		$where = " DATE_FORMAT(compras.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d')";

		echo TableSearch::get($table, $columns, $Search_columns, $Join, $where );
	}
	
	function SupportDay_dt(){

		$table = 'detalle_soporte';

		$columns = array(
			"tiendas.nombre as tienda_nombre",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"soporte.created_at as fecha",
			"detalle_soporte.descripcion as detalle_descripcion",
			'monto',
			"metodo_pago.descripcion as metodo_descripcion"
			);

		$Searchable = array("users.nombre","users.apellido");

		$Join = "JOIN soporte ON (soporte.id = detalle_soporte.soporte_id) 
		JOIN users ON (users.id = soporte.user_id)
		JOIN tiendas ON (tiendas.id = soporte.tienda_id)
		JOIN metodo_pago ON (metodo_pago.id = detalle_soporte.metodo_pago_id)";

		$where = " DATE_FORMAT(detalle_soporte.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d')";

		echo TableSearch::get($table, $columns, $Searchable, $Join, $where );
	}

	function ExpensesDay_dt(){

		$table = 'detalle_gastos';

		$columns = array(
			"tiendas.nombre as tienda_nombre",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"gastos.created_at as fecha",
			"detalle_gastos.descripcion as detalle_descripcion",
			"metodo_pago.descripcion as metodo_descripcion",
			'monto');

		$Searchable = array("users.nombre","users.apellido");

		$Join = "JOIN gastos ON (gastos.id = detalle_gastos.gasto_id) 
		JOIN users ON (users.id = gastos.user_id)
		JOIN tiendas ON (tiendas.id = gastos.tienda_id)
		JOIN metodo_pago ON (metodo_pago.id = detalle_gastos.metodo_pago_id)";

		$where = " DATE_FORMAT(detalle_gastos.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d')";

		echo TableSearch::get($table, $columns, $Searchable, $Join, $where );	
	}

	function ExpendituresDay_dt(){

		$table = 'detalle_egresos';

		$columns = array(
			"tiendas.nombre as tienda_nombre",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"egresos.created_at as fecha",
			"detalle_egresos.descripcion as detalle_descripcion",
			"metodo_pago.descripcion as metodo_descripcion",
			'monto');

		$Searchable = array("users.nombre","users.apellido");

		$Join = "JOIN egresos ON (egresos.id = detalle_egresos.egreso_id) 
		JOIN users ON (users.id = egresos.user_id)
		JOIN tiendas ON (tiendas.id = egresos.tienda_id)
		JOIN metodo_pago ON (metodo_pago.id = detalle_egresos.metodo_pago_id)";

		$where = " DATE_FORMAT(detalle_egresos.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d')";

		echo TableSearch::get($table, $columns, $Searchable, $Join, $where );	
	}
	
	function IncomeDay_dt(){

		$table = 'detalle_ingresos';

		$columns = array(
			"tiendas.nombre as tienda_nombre",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"ingresos.created_at as fecha",
			"detalle_ingresos.descripcion as detalle_descripcion",
			"metodo_pago.descripcion as metodo_descripcion",
			'monto');

		$Searchable = array("users.nombre","users.apellido");

		$Join = "JOIN ingresos ON (ingresos.id = detalle_ingresos.ingreso_id) 
		JOIN users ON (users.id = ingresos.user_id)
		JOIN tiendas ON (tiendas.id = ingresos.tienda_id)
		JOIN metodo_pago ON (metodo_pago.id = detalle_ingresos.metodo_pago_id)";

		$where = " DATE_FORMAT(detalle_ingresos.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d')";

		echo TableSearch::get($table, $columns, $Searchable, $Join, $where );	
	}

	function AdvancesDay_dt(){

		$table = 'detalle_adelantos';

		$columns = array(
			"tiendas.nombre as tienda_nombre",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"adelantos.created_at as fecha",
			"detalle_adelantos.descripcion as detalle_descripcion",
			"metodo_pago.descripcion as metodo_descripcion",
			'monto');

		$Searchable = array("users.nombre","users.apellido");

		$Join = "JOIN adelantos ON (adelantos.id = detalle_adelantos.adelanto_id) 
		JOIN users ON (users.id = adelantos.user_id)
		JOIN tiendas ON (tiendas.id = adelantos.tienda_id)
		JOIN metodo_pago ON (metodo_pago.id = detalle_adelantos.metodo_pago_id)";

		$where = " DATE_FORMAT(detalle_adelantos.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d')";


		echo TableSearch::get($table, $columns, $Searchable, $Join, $where );	
	}
//**********************************************************************************************************************
//Consultas del Proveedor
//**********************************************************************************************************************
	public function ComprasPendientesDePago()
	{

		$table = 'compras';

		$columns = array(
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			'proveedores.nombre as proveedor_nombre',
			"fecha_documento",
			"numero_documento",
			"completed",
			"saldo");

		$Search_columns = array("users.nombre","users.apellido","fecha_documento","numero_documento");

		$Join = "JOIN users ON (users.id = compras.user_id) JOIN proveedores ON (proveedores.id = compras.proveedor_id)";

		$where = " proveedor_id = ".Input::get('proveedor_id')." AND saldo > 0";

		echo TableSearch::get($table, $columns, $Search_columns, $Join ,$where);
		
	}


	public function Purchase_dt()
	{

		$table = 'compras';

		$columns = array(
			"fecha_documento",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			'proveedores.nombre as proveedor_nombre',
			"numero_documento",
			"total",
			"saldo");

		$Search_columns = array("users.nombre","users.apellido","fecha_documento","numero_documento");

		$Join = "JOIN users ON (users.id = compras.user_id) JOIN proveedores ON (proveedores.id = compras.proveedor_id)";

		$where = " proveedor_id = ".Input::get('proveedor_id');

		echo TableSearch::get($table, $columns, $Search_columns, $Join, $where );
	}

	public function HistorialDePagos()
	{
		$table = 'pagos_compras';

		$columns = array(

			"CONCAT_WS(' ',tiendas.nombre,tiendas.direccion) as tienda_nombre",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"pagos_compras.created_at as fecha",
			"compras.numero_documento as factura",
			"metodo_pago.descripcion as metodo_descripcion",
			'monto');


		$Searchable = array("users.nombre","users.apellido");

		$Join = "
		JOIN compras ON (compras.id = pagos_compras.compra_id) 
		JOIN users ON (users.id = compras.user_id)
		JOIN tiendas ON (tiendas.id = compras.tienda_id)
		JOIN metodo_pago ON (metodo_pago.id = pagos_compras.metodo_pago_id)";

		$where = " proveedor_id = ".Input::get('proveedor_id');

		echo TableSearch::get($table, $columns, $Searchable, $Join, $where );	
	}

	public function HistorialDeAbonos()
	{
		$table = 'abonos_compras';

		$columns = array(
			"CONCAT_WS(' ',tiendas.nombre,tiendas.direccion) as tienda_nombre",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"abonos_compras.created_at as fecha",
			"metodo_pago.descripcion as metodo_descripcion",
			'total','observaciones');

		$Searchable = array("users.nombre","users.apellido");

		$Join = "
		JOIN users ON (users.id = abonos_compras.user_id)
		JOIN tiendas ON (tiendas.id = abonos_compras.tienda_id)
		JOIN metodo_pago ON (metodo_pago.id = abonos_compras.metodo_pago_id)";

		$where = " total > 0 AND proveedor_id = ".Input::get('proveedor_id');

		echo TableSearch::get($table, $columns, $Searchable, $Join, $where );	
	}

//**********************************************************************************************************************
//Consultas del Usuario
//**********************************************************************************************************************
	public function VentasDelDiaUsuario()
	{
		
		$table = 'ventas';

		$columns = array(
			"ventas.created_at as fecha", 
			"CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
			"CONCAT_WS(' ',clientes.nombre,clientes.apellido) as cliente",
			"numero_documento","completed",
			"saldo"
			);

		$Search_columns = array("users.nombre","users.apellido","numero_documento","clientes.nombre","clientes.apellido");

		$Join = "JOIN users ON (users.id = ventas.user_id) JOIN clientes ON (clientes.id = ventas.cliente_id)";

		$where = " DATE_FORMAT(ventas.created_at, '%Y-%m-%d') = DATE_FORMAT(current_date, '%Y-%m-%d')  AND
		users.id =".Auth::user()->id;

		echo TableSearch::get($table, $columns, $Search_columns, $Join, $where );
	}

	public function SoporteDelDiaUsuario()
	{
		$table = 'detalle_soporte';

		$columns = array(
			"tiendas.nombre as tienda_nombre",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"soporte.created_at as fecha",
			"detalle_soporte.descripcion as detalle_descripcion",
			'monto',
			"metodo_pago.descripcion as metodo_descripcion"
			);

		$Searchable = array("users.nombre","users.apellido");

		$Join = "JOIN soporte ON (soporte.id = detalle_soporte.soporte_id) 
		JOIN users ON (users.id = soporte.user_id)
		JOIN tiendas ON (tiendas.id = soporte.tienda_id)
		JOIN metodo_pago ON (metodo_pago.id = detalle_soporte.metodo_pago_id)";

		$where = " 
		DATE_FORMAT(detalle_soporte.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d') AND
		users.id =".Auth::user()->id;

		echo TableSearch::get($table, $columns, $Searchable, $Join, $where );
	}

	public function IngresosDelDiaUsuario()
	{
		$table = 'detalle_ingresos';

		$columns = array(
			"tiendas.nombre as tienda_nombre",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"ingresos.created_at as fecha",
			"detalle_ingresos.descripcion as detalle_descripcion",
			"metodo_pago.descripcion as metodo_descripcion",
			'monto');

		$Searchable = array("users.nombre","users.apellido");

		$Join = "JOIN ingresos ON (ingresos.id = detalle_ingresos.ingreso_id) 
		JOIN users ON (users.id = ingresos.user_id)
		JOIN tiendas ON (tiendas.id = ingresos.tienda_id)
		JOIN metodo_pago ON (metodo_pago.id = detalle_ingresos.metodo_pago_id)";

		$where = " 
		DATE_FORMAT(detalle_ingresos.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d') AND
		users.id =".Auth::user()->id;

		echo TableSearch::get($table, $columns, $Searchable, $Join, $where );	
		
	}

	public function EgresosDelDiaUsuario()
	{
		$table = 'detalle_egresos';

		$columns = array(
			"tiendas.nombre as tienda_nombre",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"egresos.created_at as fecha",
			"detalle_egresos.descripcion as detalle_descripcion",
			"metodo_pago.descripcion as metodo_descripcion",
			'monto');

		$Searchable = array("users.nombre","users.apellido");

		$Join = "JOIN egresos ON (egresos.id = detalle_egresos.egreso_id) 
		JOIN users ON (users.id = egresos.user_id)
		JOIN tiendas ON (tiendas.id = egresos.tienda_id)
		JOIN metodo_pago ON (metodo_pago.id = detalle_egresos.metodo_pago_id)";

		$where = " 
		DATE_FORMAT(detalle_egresos.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d') AND
		users.id =".Auth::user()->id;

		echo TableSearch::get($table, $columns, $Searchable, $Join, $where );	
	}

	public function GastosDelDiaUsuario()
	{
		$table = 'detalle_gastos';

		$columns = array(
			"tiendas.nombre as tienda_nombre",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"gastos.created_at as fecha",
			"detalle_gastos.descripcion as detalle_descripcion",
			"metodo_pago.descripcion as metodo_descripcion",
			'monto');

		$Searchable = array("users.nombre","users.apellido");

		$Join = "JOIN gastos ON (gastos.id = detalle_gastos.gasto_id) 
		JOIN users ON (users.id = gastos.user_id)
		JOIN tiendas ON (tiendas.id = gastos.tienda_id)
		JOIN metodo_pago ON (metodo_pago.id = detalle_gastos.metodo_pago_id)";

		$where = "
		DATE_FORMAT(detalle_gastos.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d') AND
		users.id =".Auth::user()->id;
		
		echo TableSearch::get($table, $columns, $Searchable, $Join, $where );		
	}

	public function AdelantosDelDiaUsuario()
	{
		$table = 'detalle_adelantos';

		$columns = array(
			"tiendas.nombre as tienda_nombre",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"adelantos.created_at as fecha",
			"detalle_adelantos.descripcion as detalle_descripcion",
			"metodo_pago.descripcion as metodo_descripcion",
			'monto');

		$Searchable = array("users.nombre","users.apellido");

		$Join = "JOIN adelantos ON (adelantos.id = detalle_adelantos.adelanto_id) 
		JOIN users ON (users.id = adelantos.user_id)
		JOIN tiendas ON (tiendas.id = adelantos.tienda_id)
		JOIN metodo_pago ON (metodo_pago.id = detalle_adelantos.metodo_pago_id)";

		$where = "
		DATE_FORMAT(detalle_adelantos.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d') AND
		users.id =".Auth::user()->id;

		echo TableSearch::get($table, $columns, $Searchable, $Join, $where );	
	}


}
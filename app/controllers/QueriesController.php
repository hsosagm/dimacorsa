<?php

class QueriesController extends \BaseController {

	public function getMasterQueries()
	{
		return Response::json(array(
			'success' => true,
			'view'    => View::make('queries.masterQueries')->render()
        ));
	}

	/*******************************************************************
	Inicio Consultas de Ventas
	*******************************************************************/
	public function getVentasPorFecha($consulta)
	{
		$fecha_final ='now()';

		if (Input::has('fecha_inicial')) {
			$fecha_inicial = Input::get('fecha_inicial');
			$fecha_final = Input::get('fecha_final');
			$consulta = 'fechas';
		}

		else if ($consulta == 'dia') {
			$fecha_inicial ='now()';
		}

		else {
			$fecha_inicial = Carbon::now()->startOfMonth();
		}


		$factura = DB::table('printer')->select('impresora')
		->where('tienda_id', Auth::user()->tienda_id)->where('nombre', 'factura')->first();

		$garantia = DB::table('printer')->select('impresora')
		->where('tienda_id',Auth::user()->tienda_id)->where('nombre','garantia')->first();

		return Response::json(array(
			'success' => true,
			'view'    => View::make('queries.ventasPorFecha', compact('consulta','fecha_inicial','fecha_final', 'factura', 'garantia'))->render()
        ));
	}

	public function DtVentasPorFecha($consulta)
	{
		if ($consulta == 'dia')
			echo $this->consultaVentas('%Y-%m-%d');
		else if ($consulta == 'mes')
			echo $this->consultaVentas('%Y-%m');
		else if ($consulta == 'fechas')
			echo $this->consultaVentas(null, Input::get('fecha_inicial'), Input::get('fecha_final'));
	}

	public function consultaVentas($formato , $fecha_inicial = null , $fecha_final = null)
	{
		$table = 'ventas';

		$columns = array(
			"ventas.created_at as fecha",
			"CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
			"clientes.nombre as cliente",
			"total",
			"saldo",
			"completed",
			"canceled"
		);

		$Search_columns = array("users.nombre","users.apellido","clientes.nombre","ventas.total",'ventas.created_at');
		$where = "DATE_FORMAT(ventas.created_at, '{$formato}') = DATE_FORMAT(current_date, '{$formato}')";

		if ($fecha_inicial != null && $fecha_final != null)
		{
			$where  = "DATE_FORMAT(ventas.created_at, '%Y-%m-%d') >= DATE_FORMAT('{$fecha_inicial}', '%Y-%m-%d')";
			$where .= " AND DATE_FORMAT(ventas.created_at, '%Y-%m-%d') <= DATE_FORMAT('{$fecha_final}', '%Y-%m-%d')";
		}

		$where .= " AND ventas.tienda_id = ".Auth::user()->tienda_id ;
		$Join = "JOIN users ON (users.id = ventas.user_id) JOIN clientes ON (clientes.id = ventas.cliente_id)";

		return TableSearch::get($table, $columns, $Search_columns, $Join, $where );
	}
	/*******************************************************************
	Fin Consultas de Ventas
	*******************************************************************/

	/*******************************************************************
	Inicio Consultas de Compras
	*******************************************************************/
	public function getComprasPorFecha($consulta)
	{
		$fecha_final ='now()';

		if (Input::has('fecha_inicial')) {
			$fecha_inicial = Input::get('fecha_inicial');
			$fecha_final = Input::get('fecha_final');
			$consulta = 'fechas';
		}

		else if ($consulta == 'dia') {
			$fecha_inicial ='now()';
		}

		else {
			$fecha_inicial = Carbon::now()->startOfMonth();
		}

		return Response::json(array(
			'success' => true,
			'view'    => View::make('queries.comprasPorFecha',compact('consulta','fecha_inicial','fecha_final'))->render()
        ));
	}

	public function DtComprasPorFecha($consulta)
	{
		if ($consulta == 'dia')
			echo $this->consultaCompras('%Y-%m-%d');
		else if ($consulta == 'mes')
			echo $this->consultaCompras('%Y-%m');
		else if ($consulta == 'fechas')
			echo $this->consultaCompras(null, Input::get('fecha_inicial'), Input::get('fecha_final'));
	}

	public function consultaCompras($formato , $fecha_inicial = null , $fecha_final = null)
	{
		$table = 'compras';

		$columns = array(
			"compras.created_at as fecha",
			"fecha_documento",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"proveedores.nombre as proveedor_nombre",
			"numero_documento",
			"total",
			"saldo",
			"completed"
		);

		$Search_columns = array(
			"users.nombre","users.apellido",
			"numero_documento","proveedores.nombre",
			'compras.fecha_documento','compras.created_at',
			'compras.total');

		$where = "DATE_FORMAT(compras.created_at, '{$formato}') = DATE_FORMAT(current_date, '{$formato}')";

		if ($fecha_inicial != null && $fecha_final != null)
		{
			$where  = "DATE_FORMAT(compras.created_at, '%Y-%m-%d') >= DATE_FORMAT('{$fecha_inicial}', '%Y-%m-%d')";
			$where .= " AND DATE_FORMAT(compras.created_at, '%Y-%m-%d') <= DATE_FORMAT('{$fecha_final}', '%Y-%m-%d')";
		}

		$where .= " AND compras.tienda_id = ".Auth::user()->tienda_id ;
		$Join = "JOIN users ON (users.id = compras.user_id) JOIN proveedores ON (proveedores.id = compras.proveedor_id)";

		return TableSearch::get($table, $columns, $Search_columns, $Join, $where );
	}
	/*******************************************************************
	Fin Consultas de Compras
	*******************************************************************/

	/*******************************************************************
	Inicio Consultas de Descargas
	*******************************************************************/
	public function getDescargasPorFecha($consulta)
	{
		$fecha_final ='now()';

		if (Input::has('fecha_inicial')) {
			$fecha_inicial = Input::get('fecha_inicial');
			$fecha_final = Input::get('fecha_final');
			$consulta = 'fechas';
		}

		else if ($consulta == 'dia') {
			$fecha_inicial ='now()';
		}

		else {
			$fecha_inicial = Carbon::now()->startOfMonth();
		}

		$comprobante = DB::table('printer')->select('impresora')
		->where('tienda_id',Auth::user()->tienda_id)->where('nombre','comprobante')->first();

		return Response::json(array(
			'success' => true,
			'view'    => View::make('queries.descargasPorFecha',compact('consulta','fecha_inicial','fecha_final','comprobante'))->render()
        ));
	}

	public function DtDescargasPorFecha($consulta)
	{
		if ($consulta == 'dia')
			echo $this->consultaDescargas('%Y-%m-%d');
		else if ($consulta == 'mes')
			echo $this->consultaDescargas('%Y-%m');
		else if ($consulta == 'fechas')
			echo $this->consultaDescargas(null, Input::get('fecha_inicial'), Input::get('fecha_final'));
	}

	public function consultaDescargas($formato , $fecha_inicial = null , $fecha_final = null)
	{
		$table = 'descargas';

		$columns = array(
			"descargas.id as identificador",
            "DATE_FORMAT(descargas.created_at, '%Y-%m-%d') as fecha",
            "CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
            'Round((select sum(cantidad*precio) from detalle_descargas where descarga_id = descargas.id),2) as total',
            "descargas.status as estado"
		);

		$Search_columns = array("users.nombre","users.apellido","descargas.id",'descargas.created_at');
		$where = "DATE_FORMAT(descargas.created_at, '{$formato}') = DATE_FORMAT(current_date, '{$formato}')";

		if ($fecha_inicial != null && $fecha_final != null)
		{
			$where  = "DATE_FORMAT(descargas.created_at, '%Y-%m-%d') >= DATE_FORMAT('{$fecha_inicial}', '%Y-%m-%d')";
			$where .= " AND DATE_FORMAT(descargas.created_at, '%Y-%m-%d') <= DATE_FORMAT('{$fecha_final}', '%Y-%m-%d')";
		}

		$where .= " AND descargas.tienda_id = ".Auth::user()->tienda_id ;
		$where .= " AND (select sum(cantidad*precio) from detalle_descargas where descarga_id = descargas.id) > 0";
		$Join = " JOIN users ON (users.id = descargas.user_id) JOIN tiendas ON (tiendas.id = descargas.tienda_id)";

		return TableSearch::get($table, $columns, $Search_columns, $Join, $where );
	}
	/*******************************************************************
	Fin Consultas de Descargas
	*******************************************************************/

	/*******************************************************************
	Inicio Consultas de Egresos
	*******************************************************************/
	public function getEgresosPorFecha($consulta)
	{
		$fecha_final ='now()';

		if (Input::has('fecha_inicial')) {
			$fecha_inicial = Input::get('fecha_inicial');
			$fecha_final = Input::get('fecha_final');
			$consulta = 'fechas';
		}

		else if ($consulta == 'dia') {
			$fecha_inicial ='now()';
		}

		else {
			$fecha_inicial = Carbon::now()->startOfMonth();
		}

		return Response::json(array(
			'success' => true,
			'view'    => View::make('queries.egresosPorFecha',compact('consulta','fecha_inicial','fecha_final'))->render()
        ));
	}

	public function DtEgresosPorFecha($consulta)
	{
		if ($consulta == 'dia')
			echo $this->consultaEgresos('%Y-%m-%d');
		else if ($consulta == 'mes')
			echo $this->consultaEgresos('%Y-%m');
		else if ($consulta == 'fechas')
			echo $this->consultaEgresos(null, Input::get('fecha_inicial'), Input::get('fecha_final'));
	}

	public function consultaEgresos($formato , $fecha_inicial = null , $fecha_final = null)
	{
		$table = 'detalle_egresos';

		$columns = array(
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
            "egresos.created_at as fecha",
            "detalle_egresos.descripcion as detalle_descripcion",
            'monto',
            "metodo_pago.descripcion as metodo_descripcion"
		);

		$Search_columns = array("users.nombre","users.apellido",
			"metodo_pago.descripcion","detalle_egresos.descripcion",
			'egresos.created_at','detalle_egresos.monto');
		$where = "DATE_FORMAT(detalle_egresos.created_at, '{$formato}') = DATE_FORMAT(current_date, '{$formato}')";

		if ($fecha_inicial != null && $fecha_final != null)
		{
			$where  = "DATE_FORMAT(detalle_egresos.created_at, '%Y-%m-%d') >= DATE_FORMAT('{$fecha_inicial}', '%Y-%m-%d')";
			$where .= " AND DATE_FORMAT(detalle_egresos.created_at, '%Y-%m-%d') <= DATE_FORMAT('{$fecha_final}', '%Y-%m-%d')";
		}

		$where .= " AND egresos.tienda_id = ".Auth::user()->tienda_id ;
		$Join = "JOIN egresos ON (egresos.id = detalle_egresos.egreso_id)
        JOIN users ON (users.id = egresos.user_id)
        JOIN tiendas ON (tiendas.id = egresos.tienda_id)
        JOIN metodo_pago ON (metodo_pago.id = detalle_egresos.metodo_pago_id)";

		return TableSearch::get($table, $columns, $Search_columns, $Join, $where );
	}
	/*******************************************************************
	Fin Consultas de Egresos
	*******************************************************************/

	/*******************************************************************
	Inicio Consultas de Gastos
	*******************************************************************/
	public function getGastosPorFecha($consulta)
	{
		$fecha_final ='now()';

		if (Input::has('fecha_inicial')) {
			$fecha_inicial = Input::get('fecha_inicial');
			$fecha_final = Input::get('fecha_final');
			$consulta = 'fechas';
		}

		else if ($consulta == 'dia') {
			$fecha_inicial ='now()';
		}

		else {
			$fecha_inicial = Carbon::now()->startOfMonth();
		}

		return Response::json(array(
			'success' => true,
			'view'    => View::make('queries.gastosPorFecha',compact('consulta','fecha_inicial','fecha_final'))->render()
        ));
	}

	public function DtGastosPorFecha($consulta)
	{
		if ($consulta == 'dia')
			echo $this->consultaGastos('%Y-%m-%d');
		else if ($consulta == 'mes')
			echo $this->consultaGastos('%Y-%m');
		else if ($consulta == 'fechas')
			echo $this->consultaGastos(null, Input::get('fecha_inicial'), Input::get('fecha_final'));
	}

	public function consultaGastos($formato , $fecha_inicial = null , $fecha_final = null)
	{
		$table = 'detalle_gastos';

		$columns = array(
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
            "gastos.created_at as fecha",
            "detalle_gastos.descripcion as detalle_descripcion",
            'monto',
            "metodo_pago.descripcion as metodo_descripcion"
		);

		$Search_columns = array("users.nombre","users.apellido",
			"metodo_pago.descripcion","detalle_gastos.descripcion",
			'gastos.created_at','detalle_gastos.monto');
		$where = "DATE_FORMAT(detalle_gastos.created_at, '{$formato}') = DATE_FORMAT(current_date, '{$formato}')";

		if ($fecha_inicial != null && $fecha_final != null)
		{
			$where  = "DATE_FORMAT(detalle_gastos.created_at, '%Y-%m-%d') >= DATE_FORMAT('{$fecha_inicial}', '%Y-%m-%d')";
			$where .= " AND DATE_FORMAT(detalle_gastos.created_at, '%Y-%m-%d') <= DATE_FORMAT('{$fecha_final}', '%Y-%m-%d')";
		}

		$where .= " AND gastos.tienda_id = ".Auth::user()->tienda_id ;
		$Join = "JOIN gastos ON (gastos.id = detalle_gastos.gasto_id)
        JOIN users ON (users.id = gastos.user_id)
        JOIN tiendas ON (tiendas.id = gastos.tienda_id)
        JOIN metodo_pago ON (metodo_pago.id = detalle_gastos.metodo_pago_id)";

		return TableSearch::get($table, $columns, $Search_columns, $Join, $where );
	}
	/*******************************************************************
	Fin Consultas de Gastos
	*******************************************************************/

	/*******************************************************************
	Inicio Consultas de Soporte
	*******************************************************************/
	public function getSoportePorFecha($consulta)
	{
		$fecha_final ='now()';

		if (Input::has('fecha_inicial')) {
			$fecha_inicial = Input::get('fecha_inicial');
			$fecha_final = Input::get('fecha_final');
			$consulta = 'fechas';
		}

		else if ($consulta == 'dia') {
			$fecha_inicial ='now()';
		}

		else {
			$fecha_inicial = Carbon::now()->startOfMonth();
		}

		return Response::json(array(
			'success' => true,
			'view'    => View::make('queries.soportePorFecha',compact('consulta','fecha_inicial','fecha_final'))->render()
        ));
	}

	public function DtSoportePorFecha($consulta)
	{
		if ($consulta == 'dia')
			echo $this->consultaSoporte('%Y-%m-%d');
		else if ($consulta == 'mes')
			echo $this->consultaSoporte('%Y-%m');
		else if ($consulta == 'fechas')
			echo $this->consultaSoporte(null, Input::get('fecha_inicial'), Input::get('fecha_final'));
	}

	public function consultaSoporte($formato , $fecha_inicial = null , $fecha_final = null)
	{
		$table = 'detalle_soporte';

		$columns = array(
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
            "soporte.created_at as fecha",
            "detalle_soporte.descripcion as detalle_descripcion",
            'monto',
            "metodo_pago.descripcion as metodo_descripcion"
		);

		$Search_columns = array("users.nombre","users.apellido",
			"metodo_pago.descripcion","detalle_soporte.descripcion",
			'soporte.created_at','detalle_soporte.monto');

		$where = "DATE_FORMAT(detalle_soporte.created_at, '{$formato}') = DATE_FORMAT(current_date, '{$formato}')";

		if ($fecha_inicial != null && $fecha_final != null)
		{
			$where  = "DATE_FORMAT(detalle_soporte.created_at, '%Y-%m-%d') >= DATE_FORMAT('{$fecha_inicial}', '%Y-%m-%d')";
			$where .= " AND DATE_FORMAT(detalle_soporte.created_at, '%Y-%m-%d') <= DATE_FORMAT('{$fecha_final}', '%Y-%m-%d')";
		}

		$where .= " AND soporte.tienda_id = ".Auth::user()->tienda_id ;
		$Join = "JOIN soporte ON (soporte.id = detalle_soporte.soporte_id)
        JOIN users ON (users.id = soporte.user_id)
        JOIN tiendas ON (tiendas.id = soporte.tienda_id)
        JOIN metodo_pago ON (metodo_pago.id = detalle_soporte.metodo_pago_id)";

		return TableSearch::get($table, $columns, $Search_columns, $Join, $where );
	}
	/*******************************************************************
	Fin Consultas de Soporte
	*******************************************************************/

	/*******************************************************************
	Inicio Consultas de Adelantos
	*******************************************************************/
	public function getAdelantosPorFecha($consulta)
	{
		$fecha_final ='now()';

		if (Input::has('fecha_inicial')) {
			$fecha_inicial = Input::get('fecha_inicial');
			$fecha_final = Input::get('fecha_final');
			$consulta = 'fechas';
		}

		else if ($consulta == 'dia') {
			$fecha_inicial ='now()';
		}

		else {
			$fecha_inicial = Carbon::now()->startOfMonth();
		}

		return Response::json(array(
			'success' => true,
			'view'    => View::make('queries.adelantosPorFecha',compact('consulta','fecha_inicial','fecha_final'))->render()
        ));
	}

	public function DtAdelantosPorFecha($consulta)
	{
		if ($consulta == 'dia')
			echo $this->consultaAdelantos('%Y-%m-%d');
		else if ($consulta == 'mes')
			echo $this->consultaAdelantos('%Y-%m');
		else if ($consulta == 'fechas')
			echo $this->consultaAdelantos(null, Input::get('fecha_inicial'), Input::get('fecha_final'));
	}

	public function consultaAdelantos($formato , $fecha_inicial = null , $fecha_final = null)
	{
		$table = 'notas_creditos';

		$columns = array(
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
            "notas_creditos.created_at as fecha",
			"notas_creditos.updated_at as fecha2",
            "notas_creditos.tipo as tipo",
            "notas_creditos.monto as monto",
			"notas_creditos.estado as estado"
		);

		$Search_columns = array("tipo", "nota", "notas_creditos.created_at", "users.nombre", "users.apellido");

		$where = "DATE_FORMAT(notas_creditos.created_at, '{$formato}') = DATE_FORMAT(current_date, '{$formato}')";

		if ($fecha_inicial != null && $fecha_final != null)
		{
			$where  = "DATE_FORMAT(notas_creditos.created_at, '%Y-%m-%d') >= DATE_FORMAT('{$fecha_inicial}', '%Y-%m-%d')";
			$where .= " AND DATE_FORMAT(notas_creditos.created_at, '%Y-%m-%d') <= DATE_FORMAT('{$fecha_final}', '%Y-%m-%d')";
		}

		$where .= " AND notas_creditos.tienda_id = ".Auth::user()->tienda_id ;

		$Join = "JOIN users ON (users.id = notas_creditos.user_id)";

		return TableSearch::get($table, $columns, $Search_columns, $Join, $where );
	}
	/*******************************************************************
	Fin Consultas de Adelantos
	*******************************************************************/

	/*******************************************************************
	Inicio Consultas de Ingresos
	*******************************************************************/
	public function getIngresosPorFecha($consulta)
	{
		$fecha_final ='now()';

		if (Input::has('fecha_inicial')) {
			$fecha_inicial = Input::get('fecha_inicial');
			$fecha_final = Input::get('fecha_final');
			$consulta = 'fechas';
		}

		else if ($consulta == 'dia') {
			$fecha_inicial ='now()';
		}

		else {
			$fecha_inicial = Carbon::now()->startOfMonth();
		}

		return Response::json(array(
			'success' => true,
			'view'    => View::make('queries.ingresosPorFecha',compact('consulta','fecha_inicial','fecha_final'))->render()
        ));
	}

	public function DtIngresosPorFecha($consulta)
	{
		if ($consulta == 'dia')
			echo $this->consultaIngresos('%Y-%m-%d');
		else if ($consulta == 'mes')
			echo $this->consultaIngresos('%Y-%m');
		else if ($consulta == 'fechas')
			echo $this->consultaIngresos(null, Input::get('fecha_inicial'), Input::get('fecha_final'));
	}

	public function consultaIngresos($formato , $fecha_inicial = null , $fecha_final = null)
	{
		$table = 'detalle_ingresos';

		$columns = array(
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
            "ingresos.created_at as fecha",
            "detalle_ingresos.descripcion as detalle_descripcion",
            'monto',
            "metodo_pago.descripcion as metodo_descripcion"
		);

		$Search_columns = array("users.nombre","users.apellido",
			"metodo_pago.descripcion","detalle_ingresos.descripcion",
			'ingresos.created_at','detalle_ingresos.monto');

		$where = "DATE_FORMAT(detalle_ingresos.created_at, '{$formato}') = DATE_FORMAT(current_date, '{$formato}')";

		if ($fecha_inicial != null && $fecha_final != null)
		{
			$where  = "DATE_FORMAT(detalle_ingresos.created_at, '%Y-%m-%d') >= DATE_FORMAT('{$fecha_inicial}', '%Y-%m-%d')";
			$where .= " AND DATE_FORMAT(detalle_ingresos.created_at, '%Y-%m-%d') <= DATE_FORMAT('{$fecha_final}', '%Y-%m-%d')";
		}

		$where .= " AND ingresos.tienda_id = ".Auth::user()->tienda_id ;
		$Join = "JOIN ingresos ON (ingresos.id = detalle_ingresos.ingreso_id)
        JOIN users ON (users.id = ingresos.user_id)
        JOIN tiendas ON (tiendas.id = ingresos.tienda_id)
        JOIN metodo_pago ON (metodo_pago.id = detalle_ingresos.metodo_pago_id)";

		return TableSearch::get($table, $columns, $Search_columns, $Join, $where );
	}
	/*******************************************************************
	Fin Consultas de Adelantos
	*******************************************************************/

	/*******************************************************************
	Inicio Consultas de AbonosProveedores
	*******************************************************************/
	public function getAbonosProveedoresPorFecha($consulta)
	{
		$fecha_final ='now()';

		if (Input::has('fecha_inicial')) {
			$fecha_inicial = Input::get('fecha_inicial');
			$fecha_final = Input::get('fecha_final');
			$consulta = 'fechas';
		}

		else if ($consulta == 'dia') {
			$fecha_inicial ='now()';
		}

		else {
			$fecha_inicial = Carbon::now()->startOfMonth();
		}

		$comprobante = DB::table('printer')->select('impresora')
		->where('tienda_id',Auth::user()->tienda_id)->where('nombre','comprobante')->first();

		return Response::json(array(
			'success' => true,
			'view'    => View::make('queries.abonosProveedoresPorFecha',compact('consulta','fecha_inicial','fecha_final', 'comprobante'))->render()
        ));
	}

	public function DtAbonosProveedoresPorFecha($consulta)
	{
		if ($consulta == 'dia')
			echo $this->consultaAbonosProveedores('%Y-%m-%d');
		else if ($consulta == 'mes')
			echo $this->consultaAbonosProveedores('%Y-%m');
		else if ($consulta == 'fechas')
			echo $this->consultaAbonosProveedores(null, Input::get('fecha_inicial'), Input::get('fecha_final'));
	}

	public function consultaAbonosProveedores($formato , $fecha_inicial = null , $fecha_final = null)
	{
		$table = 'abonos_compras';

		$columns = array(
			"proveedores.nombre as proveedor_nombre",
            "CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
            "DATE_FORMAT(abonos_compras.created_at, '%Y-%m-%d')",
            "metodo_pago.descripcion as metodo_descripcion",
            'abonos_compras.monto as total','observaciones'
		);

		$Search_columns = array("users.nombre","users.apellido",
			"metodo_pago.descripcion",'proveedores.nombre',
			'abonos_compras.created_at','abonos_compras.monto');

		$where = "DATE_FORMAT(abonos_compras.created_at, '{$formato}') = DATE_FORMAT(current_date, '{$formato}')";

		if ($fecha_inicial != null && $fecha_final != null)
		{
			$where  = "DATE_FORMAT(abonos_compras.created_at, '%Y-%m-%d') >= DATE_FORMAT('{$fecha_inicial}', '%Y-%m-%d')";
			$where .= " AND DATE_FORMAT(abonos_compras.created_at, '%Y-%m-%d') <= DATE_FORMAT('{$fecha_final}', '%Y-%m-%d')";
		}

		$where .= " AND abonos_compras.tienda_id = ".Auth::user()->tienda_id ;
		$Join = "JOIN users ON (users.id = abonos_compras.user_id)
        JOIN tiendas ON (tiendas.id = abonos_compras.tienda_id)
        JOIN metodo_pago ON (metodo_pago.id = abonos_compras.metodo_pago_id)
        JOIN proveedores ON (proveedores.id = abonos_compras.proveedor_id)";

		return TableSearch::get($table, $columns, $Search_columns, $Join, $where );
	}
	/*******************************************************************
	Fin Consultas de AbonosProveedores
	*******************************************************************/

	/*******************************************************************
	Inicio Consultas de AbonosClientes
	*******************************************************************/
	public function getAbonosClientesPorFecha($consulta)
	{
		$fecha_final ='now()';

		if (Input::has('fecha_inicial')) {
			$fecha_inicial = Input::get('fecha_inicial');
			$fecha_final = Input::get('fecha_final');
			$consulta = 'fechas';
		}

		else if ($consulta == 'dia') {
			$fecha_inicial ='now()';
		}

		else {
			$fecha_inicial = Carbon::now()->startOfMonth();
		}

		$comprobante = DB::table('printer')->select('impresora')
		->where('tienda_id',Auth::user()->tienda_id)->where('nombre','comprobante')->first();

		return Response::json(array(
			'success' => true,
			'view'    => View::make('queries.abonosClientesPorFecha',compact('consulta','fecha_inicial','fecha_final', 'comprobante'))->render()
        ));
	}

	public function DtAbonosClientesPorFecha($consulta)
	{
		if ($consulta == 'dia')
			echo $this->consultaAbonosClientes('%Y-%m-%d');
		else if ($consulta == 'mes')
			echo $this->consultaAbonosClientes('%Y-%m');
		else if ($consulta == 'fechas')
			echo $this->consultaAbonosClientes(null, Input::get('fecha_inicial'), Input::get('fecha_final'));
	}

	public function consultaAbonosClientes($formato , $fecha_inicial = null , $fecha_final = null)
	{
		$table = 'abonos_ventas';

        $columns = array(
            "clientes.nombre as cliente",
            "CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
            "DATE_FORMAT(abonos_ventas.created_at, '%Y-%m-%d')",
            "metodo_pago.descripcion as metodo_descripcion",
            'monto','observaciones'
        );

		$Search_columns = array("users.nombre","users.apellido",
			"metodo_pago.descripcion", 'clientes.nombre',
			 'abonos_ventas.created_at','abonos_ventas.monto');

		$where = "DATE_FORMAT(abonos_ventas.created_at, '{$formato}') = DATE_FORMAT(current_date, '{$formato}')";

		if ($fecha_inicial != null && $fecha_final != null)
		{
			$where  = "DATE_FORMAT(abonos_ventas.created_at, '%Y-%m-%d') >= DATE_FORMAT('{$fecha_inicial}', '%Y-%m-%d')";
			$where .= " AND DATE_FORMAT(abonos_ventas.created_at, '%Y-%m-%d') <= DATE_FORMAT('{$fecha_final}', '%Y-%m-%d')";
		}

		$where .= " AND abonos_ventas.tienda_id = ".Auth::user()->tienda_id ;
		$Join = "JOIN users ON (users.id = abonos_ventas.user_id)
        JOIN tiendas ON (tiendas.id = abonos_ventas.tienda_id)
        JOIN metodo_pago ON (metodo_pago.id = abonos_ventas.metodo_pago_id)
        JOIN clientes ON (clientes.id = abonos_ventas.cliente_id)";

		return TableSearch::get($table, $columns, $Search_columns, $Join, $where );
	}
	/*******************************************************************
	Fin Consultas de AbonosClientes
	*******************************************************************/
}

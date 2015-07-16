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

		if ($consulta == 'dia') 
			$fecha_inicial ='now()'; 

		else if ($consulta == 'mes') 
			$fecha_inicial = Carbon::now()->startOfMonth(); 

		else if ($consulta == 'fechas') 
		{
			$fecha_inicial = Input::get('fecha_inicial'); 
			$fecha_final = Input::get('fecha_final');
		}
		
		return Response::json(array(
			'success' => true,
			'view'    => View::make('queries.ventasPorFecha',compact('consulta','fecha_inicial','fecha_final'))->render()
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
			"CONCAT_WS(' ',clientes.nombre,clientes.apellido) as cliente",
			"total",
			"saldo",
			"completed"
		);

		$Search_columns = array("users.nombre","users.apellido","clientes.nombre","clientes.apellido");
		
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

		if ($consulta == 'dia') 
			$fecha_inicial ='now()'; 

		else if ($consulta == 'mes') 
			$fecha_inicial = Carbon::now()->startOfMonth(); 

		else if ($consulta == 'fechas') 
		{
			$fecha_inicial = Input::get('fecha_inicial'); 
			$fecha_final = Input::get('fecha_final');
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

		$Search_columns = array("users.nombre","users.apellido","numero_documento","proveedores.nombre");
		
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
}
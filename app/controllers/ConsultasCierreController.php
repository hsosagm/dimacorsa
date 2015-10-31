<?php

class ConsultasCierreController extends \BaseController {

	public function ConsultasPorMetodoDePago($model)
	{
		if($model == 'Ventas')
			return $this->consultasPagos('venta', 'showSalesDetail', true);

		if($model == 'PagosCompras')
			return $this->consultasPagos('compra', 'showPurchasesDetail');

		if ($model == 'AbonosVentas')
			return $this->consultasAbonos('ventas' , 'verDetalleAbonosClietes');

		if ($model == 'AbonosCompras')
			return $this->consultasAbonos('compras' , 'showPaymentsDetail');

		if (trim($model) == 'AdelantosNotasCreditos')
			return $this->consultasNotaCredito('adelanto');

	    if (trim($model) == 'DevolucionNotasCreditos')
	    	return $this->consultasNotaCredito('devolucion');

		if ($model == 'Soporte' || $model == 'Adelantos' || $model == 'Ingresos' || $model == 'Egresos' || $model == 'Gastos' )
			return $this->OperacionesConsultas(strtolower(rtrim($model, 's')));

		else
			return 'No se envio ninguna peticion';
	}

	public function consultasPagos($_table, $linkDetalle, $columAbono = false)
	{
		$fecha = "'".Input::get('fecha')."'";
		$columna = '';

        if (Input::get('fecha') == 'current_date')
            $fecha = 'current_date';

		$table = "{$_table}s";

		if($_table == "compra")
			$columna = 'proveedores.nombre';
		else
			$columna = "clientes.nombre ";

		$columns = array(
			"{$_table}s.id",
        	"{$_table}s.total as total",
        	"DATE_FORMAT({$_table}s.created_at, '%Y-%m-%d') as fecha",
            "CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
            "{$columna} as nombre_extra",
            "pagos_{$_table}s.monto as pago"
		);

		$Search_columns = array("users.nombre","users.apellido", $columna);

		$Join  = "JOIN pagos_{$_table}s ON (pagos_{$_table}s.{$_table}_id = {$_table}s.id) ";
		$Join .= "JOIN metodo_pago ON (pagos_{$_table}s.metodo_pago_id = metodo_pago.id) ";
		$Join .= "JOIN users ON (users.id = {$_table}s.user_id) ";

		if($_table == "compra")
			$Join .= "JOIN proveedores ON (proveedores.id = {$_table}s.proveedor_id)";
		else
			$Join .= "JOIN clientes ON (clientes.id = {$_table}s.cliente_id)";

		$where  = " {$_table}s.tienda_id = ".Auth::user()->tienda_id;
		$where .= " AND {$_table}s.completed =  1 ";
		$where .= " AND DATE_FORMAT({$_table}s.created_at, '%Y-%m-%d')= DATE_FORMAT(".$fecha." , '%Y-%m-%d')";
		$where .= " AND metodo_pago.id = ".Input::get('metodo_pago_id');

		if ($columAbono == true)
			$where .= " AND {$_table}s.abono = 0";

		$pagos = SST::get($table, $columns, $Search_columns, $Join, $where );

		$metodo_pago = MetodoPago::find(Input::get('metodo_pago_id'));

        return Response::json(array(
			'success' => true,
			'table' => View::make('cierre.consultas.ConsultasPagosPorMetodoDePago', compact('pagos','metodo_pago','linkDetalle'))->render()
        ));
	}

	public function consultasAbonos($_table , $linkDetalle)
	{
		$fecha = "'".Input::get('fecha')."'";

        if (Input::get('fecha') == 'current_date')
            $fecha = 'current_date';

        $columna = '';
		$table = "abonos_{$_table}";

		if($_table == "compras")
			$columna = 'proveedores.nombre';
		else
			$columna = "clientes.nombre ";

		$columns = array(
			"abonos_{$_table}.id",
        	"abonos_{$_table}.monto as total",
        	"DATE_FORMAT(abonos_{$_table}.created_at, '%Y-%m-%d') as fecha",
            "CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
            "{$columna} as nombre_extra"
		);

		$Search_columns = array("users.nombre","users.apellido","abonos_{$_table}.created_at");

		$Join  = "JOIN metodo_pago ON (abonos_{$_table}.metodo_pago_id = metodo_pago.id) ";
		$Join .= "JOIN users ON (users.id = abonos_{$_table}.user_id) ";

		if($_table == "compras")
			$Join .= "JOIN proveedores ON (proveedores.id = abonos_{$_table}.proveedor_id)";
		else
			$Join .= "JOIN clientes ON (clientes.id = abonos_{$_table}.cliente_id)";


		$where  = " abonos_{$_table}.tienda_id = ".Auth::user()->tienda_id;
		$where .= " AND DATE_FORMAT(abonos_{$_table}.created_at, '%Y-%m-%d')= DATE_FORMAT(".$fecha." , '%Y-%m-%d')";
		$where .= " AND metodo_pago.id = ".Input::get('metodo_pago_id');

		$abonos = SST::get($table, $columns, $Search_columns, $Join, $where );

		$metodo_pago = MetodoPago::find(Input::get('metodo_pago_id'));

        return Response::json(array(
			'success' => true,
			'table' => View::make('cierre.consultas.ConsultasAbonosPorMetodoDePago', compact('abonos','metodo_pago','linkDetalle'))->render()
        ));
	}

	public function OperacionesConsultas($_table)
	{
		$fecha = "'".Input::get('fecha')."'";
		$table_s = "{$_table}s";

        if (Input::get('fecha') == 'current_date')
            $fecha = 'current_date';

        if ($_table == 'soporte')
        	$table_s = $_table;

			$table = "{$table_s}";

		$columns = array(
			"{$table_s}.id",
        	"detalle_{$table_s}.monto as total",
        	"DATE_FORMAT({$table_s}.created_at, '%Y-%m-%d') as fecha",
            "CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
            "detalle_{$table_s}.descripcion as  descripcion"
		);

		$Search_columns = array("users.nombre","users.apellido","abonos_ventas.created_at");

		$Join  = "JOIN detalle_{$table_s} ON ({$table_s}.id = detalle_{$table_s}.{$_table}_id) ";
		$Join .= "JOIN metodo_pago ON (detalle_{$table_s}.metodo_pago_id = metodo_pago.id) ";
		$Join .= "JOIN users ON (users.id = {$table_s}.user_id) ";

		$where  = " {$table_s}.tienda_id = ".Auth::user()->tienda_id;
		$where .= " AND DATE_FORMAT({$table_s}.created_at, '%Y-%m-%d')= DATE_FORMAT(".$fecha." , '%Y-%m-%d')";
		$where .= " AND metodo_pago.id = ".Input::get('metodo_pago_id');

		$operaciones = SST::get($table, $columns, $Search_columns, $Join, $where );

		$metodo_pago = MetodoPago::find(Input::get('metodo_pago_id'));

        return Response::json(array(
			'success' => true,
			'table' => View::make('cierre.consultas.OperacionesPorMetodoDePago', compact('operaciones','metodo_pago'))->render()
        ));
	}

	public function consultasNotaCredito($_table)
	{
		$fecha = "'".Input::get('fecha')."'";

        if (Input::get('fecha') == 'current_date')
            $fecha = 'current_date';

        $table = 'notas_creditos';

		$columns = array(
			"notas_creditos.id",
        	"{$_table}_nota_credito.monto as total",
        	"DATE_FORMAT(notas_creditos.created_at, '%Y-%m-%d') as fecha",
            "CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
            "notas_creditos.nota as  descripcion"
		);

		$Search_columns = array("users.nombre","users.apellido","notas_creditos.created_at");

		$Join  = "JOIN {$_table}_nota_credito ON (notas_creditos.id = {$_table}_nota_credito.nota_credito_id) ";
		$Join .= "JOIN metodo_pago ON ({$_table}_nota_credito.metodo_pago_id = metodo_pago.id) ";
		$Join .= "JOIN users ON (users.id = notas_creditos.user_id) ";

		$where  = " notas_creditos.tienda_id = ".Auth::user()->tienda_id;
        $where .= " AND DATE_FORMAT(notas_creditos.created_at, '%Y-%m-%d') =  DATE_FORMAT({$fecha}, '%Y-%m-%d')";
        $where .= " AND metodo_pago.id = ".Input::get('metodo_pago_id');

		$notasCreditos = SST::get($table, $columns, $Search_columns, $Join, $where );
		$metodo_pago = MetodoPago::find(Input::get('metodo_pago_id'));

        return Response::json(array(
			'success' => true,
			'table' => View::make('cierre.consultas.notaCreditoPorMetodoDePago', compact('notasCreditos','metodo_pago'))->render()
        ));
	}

	 /*****************************************************************************************************************************
       Inicio Consultas de ventas por usuario del mes en el Balance General
    ******************************************************************************************************************************/
    public function getVentasDelMesPorUsuario()
    {
    	return Response::json(array(
			'success' => true,
			'table' => View::make('cierre.consultas.ventasDelMesPorUsuario')->render()
        ));
    }

    public function DTVentasDelMesPorUsuario()
    {
        $fecha = "'".Input::get('fecha')."'";

        $table = 'ventas';

        $columns = array(
            "ventas.created_at as fecha",
            "CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
            "clientes.nombre as cliente",
            "total",
            "saldo",
            "completed"
        );

        $Search_columns = array(
			"users.nombre",
			"users.apellido",
			"clientes.nombre",
			'total',
			'saldo'
		);

        $Join = "JOIN users ON (users.id = ventas.user_id) JOIN clientes ON (clientes.id = ventas.cliente_id)";

        $where  = " DATE_FORMAT(ventas.created_at, '%Y-%m') = DATE_FORMAT({$fecha}, '%Y-%m') ";
        $where .= " AND users.id =".Input::get('user_id');
        $where .= " AND ventas.tienda_id =".Auth::user()->tienda_id;

        echo TableSearch::get($table, $columns, $Search_columns, $Join, $where );
    }

    /*****************************************************************************************************************************
       Fin Consultas de ventas por usuario del mes en el Balance General
    ******************************************************************************************************************************/
}

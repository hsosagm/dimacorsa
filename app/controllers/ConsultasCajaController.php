<?php

class ConsultasCajaController extends \BaseController {

	public function ConsultasPorMetodoDePago($model)
	{
		if($model == 'Ventas')
			return $this->consultasPagos('venta','showSalesDetail');

		else if ($model == 'AbonosVentas')
			return $this->consultasAbonos('ventas' , 'verDetalleAbonosClietes');

		else if ($model == 'AbonosCompras')
			return $this->consultasAbonos('compras' , 'showPaymentsDetail');

        else if ($model == 'AdelantosNotasCreditos')
    		return $this->consultasNotasCreditos('adelanto');

        else if ($model == 'DevolucionNotasCreditos')
        	return $this->consultasNotasCreditos('devolucion');

		else if ($model == 'Soporte' || $model == 'Adelantos' || $model == 'Ingresos' || $model == 'Egresos' || $model == 'Gastos' )
			return $this->OperacionesConsultas(strtolower(rtrim($model, 's')));

		else
			return 'No se envio ninguna peticion';
	}

	public function consultasPagos($_table, $linkDetalle)
	{
        $fecha_inicial = "'".Input::get('fecha_inicial')."'";
		$fecha_final = "'".Input::get('fecha_final')."'";
		$columna = '';
		$table = "{$_table}s";

		if($_table == "compra")
			$columna = 'proveedores.nombre';
		else
			$columna = "clientes.nombre ";

		$columns = array(
			"{$_table}s.id",
        	"{$_table}s.total as total",
        	"DATE_FORMAT({$_table}s.updated_at, '%Y-%m-%d') as fecha",
            "CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
            "{$columna} as nombre_extra",
            "pagos_{$_table}s.monto as pago"
		);

		$Search_columns = array("users.nombre","users.apellido");

		$Join  = "JOIN pagos_{$_table}s ON (pagos_{$_table}s.{$_table}_id = {$_table}s.id) ";
		$Join .= "JOIN metodo_pago ON (pagos_{$_table}s.metodo_pago_id = metodo_pago.id) ";
		$Join .= "JOIN users ON (users.id = {$_table}s.user_id) ";

		if($_table == "compra")
			$Join .= "JOIN proveedores ON (proveedores.id = {$_table}s.proveedor_id)";
		else
			$Join .= "JOIN clientes ON (clientes.id = {$_table}s.cliente_id)";

		$where  = " {$_table}s.tienda_id = ".Auth::user()->tienda_id;
		$where .= " AND {$_table}s.completed =  1 ";
        $where .= " AND DATE_FORMAT({$_table}s.updated_at, '%Y-%m-%d %H:%i:%s') >  DATE_FORMAT({$fecha_inicial}, '%Y-%m-%d %H:%i:%s')";
        $where .= " AND DATE_FORMAT({$_table}s.updated_at, '%Y-%m-%d %H:%i:%s') <= DATE_FORMAT({$fecha_final}, '%Y-%m-%d %H:%i:%s')";
        $where .= " AND metodo_pago.id = ".Input::get('metodo_pago_id');
		$where .= " AND {$table}.caja_id = ".Input::get('caja_id');

		$pagos = SST::get($table, $columns, $Search_columns, $Join, $where );

		$metodo_pago = MetodoPago::find(Input::get('metodo_pago_id'));

        return Response::json(array(
			'success' => true,
			'table' => View::make('cajas.consultas.ConsultasPagosPorMetodoDePago', compact('pagos','metodo_pago','linkDetalle'))->render()
        ));
	}

	public function consultasAbonos($_table , $linkDetalle)
	{
        $fecha_inicial = "'".Input::get('fecha_inicial')."'";
		$fecha_final = "'".Input::get('fecha_final')."'";
        $columna = '';
		$table = "abonos_{$_table}";

		if($_table == "compras")
			$columna = 'proveedores.nombre';
		else
			$columna = "clientes.nombre ";

		$columns = array(
			"abonos_{$_table}.id",
        	"abonos_{$_table}.monto as total",
        	"DATE_FORMAT(abonos_{$_table}.updated_at, '%Y-%m-%d') as fecha",
            "CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
            "{$columna} as nombre_extra"
		);

		$Search_columns = array("users.nombre","users.apellido","abonos_{$_table}.updated_at");

		$Join  = "JOIN metodo_pago ON (abonos_{$_table}.metodo_pago_id = metodo_pago.id) ";
		$Join .= "JOIN users ON (users.id = abonos_{$_table}.user_id) ";

		if($_table == "compras")
			$Join .= "JOIN proveedores ON (proveedores.id = abonos_{$_table}.proveedor_id)";
		else
			$Join .= "JOIN clientes ON (clientes.id = abonos_{$_table}.cliente_id)";

		$where  = " abonos_{$_table}.tienda_id = ".Auth::user()->tienda_id;
        $where .= " AND DATE_FORMAT(abonos_{$_table}.updated_at, '%Y-%m-%d %H:%i:%s') >  DATE_FORMAT({$fecha_inicial}, '%Y-%m-%d %H:%i:%s')";
        $where .= " AND DATE_FORMAT(abonos_{$_table}.updated_at, '%Y-%m-%d %H:%i:%s') <= DATE_FORMAT({$fecha_final}, '%Y-%m-%d %H:%i:%s')";
		$where .= " AND metodo_pago.id = ".Input::get('metodo_pago_id');
        $where .= " AND {$_table}.caja_id = ".Input::get('caja_id');

		$abonos = SST::get($table, $columns, $Search_columns, $Join, $where );

		$metodo_pago = MetodoPago::find(Input::get('metodo_pago_id'));

        return Response::json(array(
			'success' => true,
			'table' => View::make('cajas.consultas.ConsultasAbonosPorMetodoDePago', compact('abonos','metodo_pago','linkDetalle'))->render()
        ));
	}

	public function OperacionesConsultas($_table)
	{
        $fecha_inicial = "'".Input::get('fecha_inicial')."'";
		$fecha_final = "'".Input::get('fecha_final')."'";
		$table_s = "{$_table}s";

        if ($_table == 'soporte')
        	$table_s = $_table;

			$table = "{$table_s}";

		$columns = array(
			"{$table_s}.id",
        	"detalle_{$table_s}.monto as total",
        	"DATE_FORMAT({$table_s}.updated_at, '%Y-%m-%d') as fecha",
            "CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
            "detalle_{$table_s}.descripcion as  descripcion"
		);

		$Search_columns = array("users.nombre","users.apellido","abonos_ventas.updated_at");

		$Join  = "JOIN detalle_{$table_s} ON ({$table_s}.id = detalle_{$table_s}.{$_table}_id) ";
		$Join .= "JOIN metodo_pago ON (detalle_{$table_s}.metodo_pago_id = metodo_pago.id) ";
		$Join .= "JOIN users ON (users.id = {$table_s}.user_id) ";

		$where  = " {$table_s}.tienda_id = ".Auth::user()->tienda_id;
        $where .= " AND DATE_FORMAT({$table_s}.updated_at, '%Y-%m-%d %H:%i:%s') >  DATE_FORMAT({$fecha_inicial}, '%Y-%m-%d %H:%i:%s')";
        $where .= " AND DATE_FORMAT({$table_s}.updated_at, '%Y-%m-%d %H:%i:%s') <= DATE_FORMAT({$fecha_final}, '%Y-%m-%d %H:%i:%s')";
        $where .= " AND metodo_pago.id = ".Input::get('metodo_pago_id');
		$where .= " AND {$table_s}.caja_id = ".Input::get('caja_id');

		$operaciones = SST::get($table, $columns, $Search_columns, $Join, $where );

		$metodo_pago = MetodoPago::find(Input::get('metodo_pago_id'));

        return Response::json(array(
			'success' => true,
			'table' => View::make('cajas.consultas.OperacionesPorMetodoDePago', compact('operaciones','metodo_pago'))->render()
        ));
	}

    public function consultasNotasCreditos($_table)
	{
        $fecha_inicial = "'".Input::get('fecha_inicial')."'";
		$fecha_final = "'".Input::get('fecha_final')."'";

        $table = 'notas_creditos';

		$columns = array(
			"notas_creditos.id",
        	"{$_table}_nota_credito.monto as total",
        	"DATE_FORMAT(notas_creditos.updated_at, '%Y-%m-%d') as fecha",
            "CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
            "notas_creditos.nota as  descripcion"
		);

		$Search_columns = array("users.nombre","users.apellido","notas_creditos.updated_at");

		$Join  = "JOIN {$_table}_nota_credito ON (notas_creditos.id = {$_table}_nota_credito.nota_credito_id) ";
		$Join .= "JOIN metodo_pago ON ({$_table}_nota_credito.metodo_pago_id = metodo_pago.id) ";
		$Join .= "JOIN users ON (users.id = notas_creditos.user_id) ";

		$where  = " notas_creditos.tienda_id = ".Auth::user()->tienda_id;
        $where .= " AND DATE_FORMAT(notas_creditos.updated_at, '%Y-%m-%d %H:%i:%s') >  DATE_FORMAT({$fecha_inicial}, '%Y-%m-%d %H:%i:%s')";
        $where .= " AND DATE_FORMAT(notas_creditos.updated_at, '%Y-%m-%d %H:%i:%s') <= DATE_FORMAT({$fecha_final}, '%Y-%m-%d %H:%i:%s')";
        $where .= " AND metodo_pago.id = ".Input::get('metodo_pago_id');
		$where .= " AND notas_creditos.caja_id = ".Input::get('caja_id');

		$notasCreditos = SST::get($table, $columns, $Search_columns, $Join, $where );
        return json_encode($notasCreditos);
		$metodo_pago = MetodoPago::find(Input::get('metodo_pago_id'));

        return Response::json(array(
			'success' => true,
			'table' => View::make('cajas.consultas.NotasDeCreditoPorMetodoDePago', compact('notasCreditos','metodo_pago'))->render()
        ));
	}
}
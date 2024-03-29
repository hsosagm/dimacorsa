<div style="border:1px solid #D5CBCB; background: #FFFFFF;">
	<table class="dt-table table-striped table-theme" id="consultasCierre">
		<tbody style="background: #ffffff;">
			<tr>
				<td style="font-size: 14px; color:#1b7be2;" colspan="7" class="dataTables_empty">Cargando datos del servidor...</td>
			</tr>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$("#iSearch").val("");
		$("#iSearch").unbind();
		$("#table_length_cierre").html("");
		setTimeout(function() {
			$('#econsultasCierre_length').prependTo("#table_length_cierre");
			$('#iSearch').keyup(function(){
				$('#consultasCierre').dataTable().fnFilter( $(this).val() );
			})
		}, 300);

		$('#consultasCierre').dataTable({
			"language": {
				"lengthMenu": "Mostrar _MENU_ archivos por pagina",
				"zeroRecords": "No se encontro ningun archivo",
				"info": "Mostrando la pagina _PAGE_ de _PAGES_",
				"infoEmpty": "No hay archivos disponibles",
				"infoFiltered": "- ( filtrado de _MAX_ archivos )"
			},
			"aoColumnDefs": [
				{"sClass": "mod_codigo hover width20", "sTitle": "Fecha",            "aTargets": [0]},
				{"sClass": "mod_codigo hover width15", "sTitle": "Usuario",          "aTargets": [1]},
				{"sClass": "mod_codigo hover width40", "sTitle": "Cliente",          "aTargets": [2]},
				{"sClass": "mod_codigo hover width10", "sTitle": "Total",            "aTargets": [3]},
				{"sClass": "mod_codigo hover width10", "sTitle": "{{$metodo_pago}}", "aTargets": [4]},
				{"sClass": "width5 icons center",      "sTitle": "",            	 "aTargets": [5],   
					"orderable": false,
					"mRender": function() {
						return '<i class="fa fa-plus-square btn-link theme-c" onClick="{{$linkDetalle}}(this)"></i>';
					}
				},
			],
			"order": [[ 3, "desc" ]],
			"bJQueryUI": false,
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "admin/cierre/consultas/ConsultasPorMetodoDePago/{{$model}}",
            "fnServerParams": function (aoData) {
                aoData.push({ "name": "DT", 		"value": "true" });
                aoData.push({ "name": "columAbono", "value": "{{$columAbono}}" });
            }
		});
	});
</script>

<?php

class ConsultasCierreController extends \BaseController {
 
	public function ConsultasPorMetodoDePago($model)
	{ 
		if(trim($model) == 'Ventas')
			return $this->consultasPagos($model, 'venta', 'showSalesDetail', true);

		if(trim($model) == 'PagosCompras')
			return $this->consultasPagos($model, 'compra', 'showPurchasesDetail');

		if (trim($model) == 'AbonosVentas')
			return $this->consultasAbonos($model, 'ventas', 'verDetalleAbonosClietes');

		if (trim($model) == 'AbonosCompras')
			return $this->consultasAbonos($model, 'compras', 'showPaymentsDetail');

		if (trim($model) == 'Adelantos')
        	return $this->consultasAdelantos($model, 'adelantos');;

	    if (trim($model) == 'Devolucion')
	    	return $this->consultasDevolucion($model, 'devolucion');

		if ($model == 'Soporte' || $model == 'Ingresos' || $model == 'Egresos' || $model == 'Gastos' )
			return $this->OperacionesConsultas($model, strtolower(rtrim($model, 's')));

		else
			return 'No se envio ninguna peticion';
	}
 
	public function consultasPagos($model, $_table, $linkDetalle, $columAbono = false)
	{
		if (!Input::get('DT')) 
		{
			$metodo_pago = MetodoPago::find(Input::get('metodo_pago_id'));

	        return Response::json(array(
				'success' => true,
				'table' => View::make('cierre.consultas.ConsultasPagosPorMetodoDePago', 
					compact('model', 'metodo_pago', 'linkDetalle', 'columAbono'))->render()
	        ));
		}

		$fecha = json_decode(Input::get('fecha'));
		$columna = '';
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
		
		(@$fecha->fecha_final->date == "")? $fecha_final = $fecha->fecha_final : $fecha_final = $fecha->fecha_final->date;
		(@$fecha->fecha_inicial->date == "")? $fecha_inicial = $fecha->fecha_inicial : $fecha_inicial = $fecha->fecha_inicial->date;

		$where  = " {$_table}s.tienda_id = ".Auth::user()->tienda_id;
		$where .= " AND {$_table}s.completed = 1";
		$where .= " AND metodo_pago.id = ".Input::get('metodo_pago_id');
		$where .= " AND DATE_FORMAT({$_table}s.updated_at, '%Y-%m-%d %H:%i:%s') > DATE_FORMAT('{$fecha_inicial}', '%Y-%m-%d %H:%i:%s')";
        $where .= " AND DATE_FORMAT({$_table}s.updated_at, '%Y-%m-%d %H:%i:%s') <= DATE_FORMAT('{$fecha_final}', '%Y-%m-%d %H:%i:%s')";
 
		if ($columAbono == true)
			$where .= " AND {$_table}s.abono = 0";

		return TableSearch::get($table, $columns, $Search_columns, $Join, $where );
	}

	public function consultasAbonos($model, $_table , $linkDetalle)
	{
		$fecha = json_decode(Input::get('fecha'));
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
 
		$Search_columns = array("users.nombre","users.apellido", "abonos_{$_table}.created_at");

		$Join  = " JOIN metodo_pago ON (abonos_{$_table}.metodo_pago_id = metodo_pago.id)";
		$Join .= " JOIN users ON (users.id = abonos_{$_table}.user_id)";

		if($_table == "compras")
			$Join .= " JOIN proveedores ON (proveedores.id = abonos_{$_table}.proveedor_id)";
		else
			$Join .= " JOIN clientes ON (clientes.id = abonos_{$_table}.cliente_id)";
  
		(@$fecha->fecha_final->date == "")? $fecha_final = $fecha->fecha_final : $fecha_final = $fecha->fecha_final->date;
		(@$fecha->fecha_inicial->date == "")? $fecha_inicial = $fecha->fecha_inicial : $fecha_inicial = $fecha->fecha_inicial->date;

		$where  = " abonos_{$_table}.tienda_id = ".Auth::user()->tienda_id;
		$where .= " AND metodo_pago.id = ".Input::get('metodo_pago_id');
		$where .= " AND DATE_FORMAT(abonos_{$_table}.updated_at, '%Y-%m-%d %H:%i:%s') >  DATE_FORMAT('{$fecha_inicial}', '%Y-%m-%d %H:%i:%s')";
        $where .= " AND DATE_FORMAT(abonos_{$_table}.updated_at, '%Y-%m-%d %H:%i:%s') <= DATE_FORMAT('{$fecha_final}', '%Y-%m-%d %H:%i:%s')";

		$abonos = SST::get($table, $columns, $Search_columns, $Join, $where );
		$metodo_pago = MetodoPago::find(Input::get('metodo_pago_id'));

        return Response::json(array(
			'success' => true,
			'table' => View::make('cierre.consultas.ConsultasAbonosPorMetodoDePago', compact('abonos', 'metodo_pago', 'linkDetalle'))->render()
        ));
	}
 
	public function OperacionesConsultas($model, $_table)
	{
		$fecha = json_decode(Input::get('fecha'));
		$table_s = "{$_table}s";

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

		$Search_columns = array("users.nombre", "users.apellido", "abonos_ventas.created_at");

		$Join  = "JOIN detalle_{$table_s} ON ({$table_s}.id = detalle_{$table_s}.{$_table}_id) ";
		$Join .= "JOIN metodo_pago ON (detalle_{$table_s}.metodo_pago_id = metodo_pago.id) ";
		$Join .= "JOIN users ON (users.id = {$table_s}.user_id) ";

		(@$fecha->fecha_final->date == "")? $fecha_final = $fecha->fecha_final : $fecha_final = $fecha->fecha_final->date;
		(@$fecha->fecha_inicial->date == "")? $fecha_inicial = $fecha->fecha_inicial : $fecha_inicial = $fecha->fecha_inicial->date;

		$where  = " {$table_s}.tienda_id = ".Auth::user()->tienda_id;
		$where .= " AND metodo_pago.id = ".Input::get('metodo_pago_id');
		$where .= " AND DATE_FORMAT({$table_s}.updated_at, '%Y-%m-%d %H:%i:%s') >  DATE_FORMAT('{$fecha_inicial}', '%Y-%m-%d %H:%i:%s')";
        $where .= " AND DATE_FORMAT({$table_s}.updated_at, '%Y-%m-%d %H:%i:%s') <= DATE_FORMAT('{$fecha_final}', '%Y-%m-%d %H:%i:%s')";

		$operaciones = SST::get($table, $columns, $Search_columns, $Join, $where );
		$metodo_pago = MetodoPago::find(Input::get('metodo_pago_id'));

        return Response::json(array(
			'success' => true,
			'table' => View::make('cierre.consultas.OperacionesPorMetodoDePago', compact('operaciones', 'metodo_pago'))->render()
        ));
	}

	public function consultasNotaCredito($model, $_table)
	{
		$fecha = json_decode(Input::get('fecha'));
        $table = 'notas_creditos';

		$columns = array(
			"notas_creditos.id",
        	"{$_table}_nota_credito.monto as total",
        	"DATE_FORMAT(notas_creditos.created_at, '%Y-%m-%d') as fecha",
            "CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
            "notas_creditos.nota as  descripcion"
		);

		$Search_columns = array("users.nombre", "users.apellido", "notas_creditos.created_at");

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
			'table' => View::make('cierre.consultas.notaCreditoPorMetodoDePago', compact('notasCreditos', 'metodo_pago'))->render()
        ));
	}

	public function consultasDevolucion($model, $linkDetalle)
	{
		$fecha = json_decode(Input::get('fecha'));
        $table = "devoluciones";
 
		$columns = array(
			"devoluciones.id",
        	"devoluciones.total as total",
        	"DATE_FORMAT(devoluciones.updated_at, '%Y-%m-%d') as fecha",
            "CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
            "clientes.nombre as nombre_extra",
            "devoluciones_pagos.monto as pago"
		);
 
		$Search_columns = array(
			"users.nombre",
			 "users.apellido"
		);

		$Join  = " JOIN devoluciones_pagos ON (devoluciones_pagos.devolucion_id = devoluciones.id)";
		$Join .= " JOIN metodo_pago ON (devoluciones_pagos.metodo_pago_id = metodo_pago.id)";
		$Join .= " JOIN users ON (users.id = devoluciones.user_id)";
		$Join .= " JOIN clientes ON (clientes.id = devoluciones.cliente_id)";
  
		(@$fecha->fecha_final->date == "")? $fecha_final = $fecha->fecha_final : $fecha_final = $fecha->fecha_final->date;
		(@$fecha->fecha_inicial->date == "")? $fecha_inicial = $fecha->fecha_inicial : $fecha_inicial = $fecha->fecha_inicial->date;

		$where  = " devoluciones.tienda_id = ".Auth::user()->tienda_id;
		$where .= " AND metodo_pago.id = ".Input::get('metodo_pago_id');
		$where .= " AND DATE_FORMAT(devoluciones.updated_at, '%Y-%m-%d %H:%i:%s') >  DATE_FORMAT('{$fecha_inicial}', '%Y-%m-%d %H:%i:%s')";
        $where .= " AND DATE_FORMAT(devoluciones.updated_at, '%Y-%m-%d %H:%i:%s') <= DATE_FORMAT('{$fecha_final}', '%Y-%m-%d %H:%i:%s')";

		$pagos = SST::get($table, $columns, $Search_columns, $Join, $where );
		$metodo_pago = MetodoPago::find(Input::get('metodo_pago_id'));
		$linkDetalle = "getDevolucionesDetail";

        return Response::json(array(
			'success' => true,
			'table' => View::make('cierre.consultas.ConsultasPagosPorMetodoDePago', compact('pagos', 'metodo_pago', 'linkDetalle'))->render()
        ));
	}

	public function consultasAdelantos($model, $_table)
	{
        $fecha = json_decode(Input::get('fecha'));

		$table = "adelantos";

		$columns = array(
			"adelantos.id as id",
			"adelantos.descripcion as descripcion",
        	"adelantos.total as total",
        	"DATE_FORMAT(adelantos.updated_at, '%Y-%m-%d') as fecha",
            "CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
            "clientes.nombre as cliente",
            "adelantos_pagos.monto as pago"
		);
 
		$Search_columns = array("users.nombre","users.apellido");

		$Join  = "JOIN adelantos_pagos ON (adelantos_pagos.adelanto_id = adelantos.id) ";
		$Join .= "JOIN metodo_pago ON (adelantos_pagos.metodo_pago_id = metodo_pago.id) ";
		$Join .= "JOIN users ON (users.id = adelantos.user_id) ";
		$Join .= "JOIN clientes ON (clientes.id = adelantos.cliente_id)";

		(@$fecha->fecha_final->date == "")? $fecha_final = $fecha->fecha_final : $fecha_final = $fecha->fecha_final->date;
		(@$fecha->fecha_inicial->date == "")? $fecha_inicial = $fecha->fecha_inicial : $fecha_inicial = $fecha->fecha_inicial->date;

		$where  = " adelantos.tienda_id = ".Auth::user()->tienda_id;
        $where .= " AND DATE_FORMAT(adelantos.updated_at, '%Y-%m-%d %H:%i:%s') >  DATE_FORMAT('{$fecha_inicial}', '%Y-%m-%d %H:%i:%s')";
        $where .= " AND DATE_FORMAT(adelantos.updated_at, '%Y-%m-%d %H:%i:%s') <= DATE_FORMAT('{$fecha_final}', '%Y-%m-%d %H:%i:%s')";
        $where .= " AND metodo_pago.id = ".Input::get('metodo_pago_id');

		$pagos = SST::get($table, $columns, $Search_columns, $Join, $where );

		$metodo_pago = MetodoPago::find(Input::get('metodo_pago_id'));

        return Response::json(array(
			'success' => true,
			'table' => View::make('cajas.consultas.ConsultasAdelantosPagosPorMetodoDePago', compact('pagos','metodo_pago'))->render()
        ));
	}
}

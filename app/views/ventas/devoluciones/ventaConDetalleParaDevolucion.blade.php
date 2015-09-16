
<div style="font-size:12px; padding-left: 15px;">
    <h4 style="text-align:center">Devolucion de productos</h4>

	<table class="table_white">
		<tr>
			<td> <label>Monto: @{{ totalMontoDevolucion }}</label> </td>
			<td> <label>Articulos: 0</label> </td>
			<td colspan="3"></td>
			<td> <label>Fecha: @{{ devoluciones.venta.created_at }}</label> </td>
		</tr>

		<tr>
			<td colspan="5"> <label>Cliente: @{{ devoluciones.venta.cliente.nombre }}</label> </td>
			<td> <label>Nit: @{{ devoluciones.venta.cliente.nit }}</label> </td>
		</tr>
	</table>
</div>


<div style="min-height:250px; padding:1px; font-size:12px;">
	<table class="table table-striped">
		<thead>
			<tr>
				<th class="center">Check</th>
				<th class="center">Cantidad</th>
				<th class="center">Descripcion</th>
				<th class="center">Precio</th>
				<th class="center">Totales</th>
			</tr>
		</thead>

		<tbody>
	        <tr v-repeat="dev: devoluciones.detalle_venta">
				<td>
					<div class="ckbox ckbox-teal ckbox-dev">
						<input 
						    id="checkbox-@{{dev.producto_id}}"
						    type="checkbox"
						    v-on="click: pushToDevoluciones($event, dev.producto_id, dev.cantidad, dev.precio, {{@index}})"
						>
						<label for="checkbox-@{{dev.producto_id}}"></label>
					</div>
				</td>
				<td> @{{dev.cantidad}} </td>
				<td> @{{dev.descripcion}} </td>
				<td> @{{dev.precio}} </td>
				<td> @{{dev.precio}} </td>
	        </tr>
		</tbody>

		<tfoot>
			<tr>
				<td colspan="2"></td>
				<td>
					<div class="row">
						<div class="col-md-8" style="font-size:14px;">Total cancelado</div>
					</div>
				</td>
				<td></td>
				<td>
					<div class="col-md-4" style="text-align:right; font-size:14px;"> 
						total
					</div>
				</td>
			</tr>
		</tfoot>
	</table>
</div>

<div>
	<pre>@{{ $data | json }}</pre>
</div>

<script type="text/javascript">
	queries.devoluciones.venta = {{ $venta }};
	queries.devoluciones.detalle_venta = {{ $detalle_venta }};
</script>

<style type="text/css">
    .table th:nth-child(1) { width: 10% !important; }
    .table th:nth-child(2) { width: 10% !important; }
    .table th:nth-child(3) { width: 60% !important; }
    .table th:nth-child(4) { width: 10% !important; }
    .table th:nth-child(5) { width: 10% !important; }
    .table_white tr td {
    	background: white;
    }
</style>
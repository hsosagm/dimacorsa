<div style="font-size:12px; padding-left: 15px; padding-bottom:20px; border: 1px solid #D7D7D7">
    <h4 style="text-align:center">Devolucion de productos</h4>

	<table class="table_white">
		<tr>
			<td colspan="2"> Cliente: @{{ devoluciones.venta.cliente.nombre }} </td>
			<td> Nit: @{{ devoluciones.venta.cliente.nit }} </td>
		</tr>
		<tr>
			<td style="width: 28%"> Monto: @{{ totalMontoDevolucion | currency ' '}} </td>
			<td style="width: 28%"> Articulos: @{{ totalCantidadDevolucion }} </td>
			<td style="width: 28%"> Fecha: 2015-09-01 </td>
			<td> <i v-if="totalCantidadDevolucion" v-on="click: enviarDevolucion" class="fa fa-check fa-lg icon-success"></i> </td>
		</tr>
	</table>
</div>

<div style="min-height:200px; padding:1px; font-size:12px;">
	<table class="table table-bordered">
		<tbody>
			<tr>
				<th class="center"></th>
				<th class="center">Cantidad</th>
				<th class="center">Descripcion</th>
				<th class="center">Precio</th>
				<th class="center">Totales</th>
			</tr>

	        <tr v-repeat="dev: devoluciones.detalle_venta">
				<td>
					<div class="ckbox ckbox-teal" style="margin-left:30px;">
						<input 
						    id="checkbox-@{{dev.producto_id}}"
						    type="checkbox"
						    v-on="click: pushToDevoluciones($event, dev.producto_id, dev.cantidad, dev.precio)"
						>
						<label for="checkbox-@{{dev.producto_id}}"></label>
					</div>
				</td>
				<td v-on="dblclick: edit" class="right"> @{{dev.cantidad}} </td>
				<td  class="detail-input-edit">
				    <input style="width:90px" class="input_numeric" type="text" 
				    v-on="keyup: doneEdit($event, dev.producto_id) | key 'enter', keyup: cancelEdit | key 'esc', blur:onBlur"> 
				</td>
				<td> @{{dev.descripcion}} </td>
				<td class="right"> @{{dev.precio | currency ' '}} </td>
				<td class="right"> @{{dev.cantidad * dev.precio | currency ' '}} </td>
	        </tr>
			<tr>
				<th class="center" colspan="4"> Total cancelado: </th>
				<th class="right"> @{{ totalVenta | currency ' '}} </th>
			</tr>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	dv.devoluciones.venta = {{ $venta }};
	dv.devoluciones.detalle_venta = {{ $detalle_venta }};
	dv.devoluciones.articulos = [];
</script>

<style type="text/css">
    .table th:nth-child(1) { width: 8% !important; }
    .table th:nth-child(2) { width: 10% !important; }
    .table th:nth-child(3) { width: 62% !important; }
    .table th:nth-child(4) { width: 10% !important; }
    .table th:nth-child(5) { width: 10% !important; }
    .table tr td {
    	padding-right: 12px !important;
  
    }
    .table_white tr td {
    	background: transparent;
    }
</style>
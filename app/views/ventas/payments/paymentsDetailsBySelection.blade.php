<table class="SST">
	<thead>
		<tr>
			<th>Metodo de pago</th>
			<th>No. Venta</th>
			<th>Total</th>
			<th>Saldo Anterior</th>
			<th>Monto Abonado</th>
			<th>Nuevo Saldo</th>
		</tr>
	</thead>
	<tbody>
		@foreach($detalle as $key => $dt)
		<tr>
			<td>{{$m_pago}}</td>
			<td>{{$dt->venta_id}}</td>
			<td class="right">{{ f_num::get($dt->total) }}</td>
			<td class="right">{{ f_num::get($dt->saldo_anterior) }}</td>
			<td class="right">{{ f_num::get($dt->monto) }}</td>
			<td class="right">{{ f_num::get($dt->saldo) }}</td>
		</tr>
		@endforeach
	</tbody>
</table> 

<div class="form-footer" align="right">
	<input class="btn btn-danger" v-on="click: eliminarAbonoPorSeleccion( this, {{$abonos_ventas_id}} )" type="button" value="Eliminar">
	<input class="btn theme-button" v-on="click: imprimirAbonoVenta( this, {{$abonos_ventas_id}}, '{{@$comprobante->impresora}}' )" type="button" value="Imprimir">
</div>

<table class="SST">
	<thead>
		<tr>
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
			<td>{{$dt->venta_id}}</td>
			<td>{{$dt->total}}</td>
			<td>{{$dt->saldo_anterior}}</td>
			<td>{{$dt->monto}}</td>
			<td>{{$dt->saldo}}</td>
		</tr>
		@endforeach
	</tbody>
</table> 

<div class="form-footer" align="right">
	<input class="btn btn-danger" v-on="click: eliminarAbonoPorSeleccion( this, {{$abonos_ventas_id}} )" type="button" value="Eliminar">
	<input class="btn theme-button" v-on="click: imprimirAbonoVenta( this, {{$abonos_ventas_id}} )" type="button" value="Imprimir">
</div>

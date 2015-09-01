<table class="SST">
	<thead>
		<tr>
			<th>No. Compra</th>
			<th>Total</th>
			<th>Saldo Anterior</th>
			<th>Monto Abonado</th>
			<th>Nuevo Saldo</th>
			<th>Metodo Pago</th>
		</tr>
	</thead> 
	<tbody>
		@foreach($detalle as $key => $dt)
		<tr>
			<td>{{$dt->compra_id}}</td>
			<td class="right">{{ f_num::get($dt->total) }}</td>
			<td class="right">{{ f_num::get($dt->saldo_anterior) }}</td>
			<td class="right">{{ f_num::get($dt->monto) }}</td>
			<td class="right">{{ f_num::get($dt->saldo) }}</td>
			<td class=""> {{ $dt->metodo_pago}}</td>
		</tr>
		@endforeach
	</tbody>
</table> 

<div class="form-footer" align="right">
	<input class="btn btn-info" onClick="ImprimirAbonoProveedor(this,{{ $abonos_compra_id }}, '{{$comprobante->impresora}}')" type="button" value="Imprimir">
	<input class="btn btn-danger" v-on="click: eliminarAbono( this, {{$abonos_compra_id}} )" type="button" value="Eliminar">
</div>

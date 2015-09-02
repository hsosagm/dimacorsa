<table width="100%" class="table table-bordered">
	<tr>
		<td> Nombre :</td>
		<td> {{ $abonos_venta->cliente->nombre.' '.$abonos_venta->cliente->apellido}} </td>
		<td> Direccion :</td>
		<td> {{ $abonos_venta->cliente->direccion }} </td>
	</tr>
	<tr>
		<td> Nit :</td>
		<td> {{ $abonos_venta->cliente->nit }} </td>
		<td> Telefono :</td>
		<td> {{ $abonos_venta->cliente->telefono }} </td>
	</tr>
</table>
<br>
<table width="100%" class="table table-bordered">
	<tr>
		<td> Metodo Pago :</td>
		<td> {{ $abonos_venta->metodoPago->descripcion }} </td>
		<td> Fecha :</td>
		<td> {{ $abonos_venta->created_at}} </td>
	</tr>
	<tr>
		<td> Usuario :</td>
		<td colspan="3"> {{ $abonos_venta->user->nombre .' '. $abonos_venta->user->apellido}} </td>
	</tr>
	<tr>
		<td>Observaciones</td>
		<td colspan="3"> {{ $abonos_venta->observaciones }} </td>
	</tr>
</table>
<table width="100%" class="table table-bordered">
	<tr>
		<td> Saldo ala fecha:</td>
		<td> Q {{ f_num::get($saldo->total) }} </td>
		<td> Monto total abonado :</td>
		<td> Q {{ f_num::get($abonos_venta->monto) }} </td>
	</tr>
</table>
<table width="100%" class="table table-condensed">
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


<table class="SST">
	
</table> 



<html>
<head>
	<meta charset="ISO-8859-1">
</head>
<body>
	<div align="center">
		<div class="" width="750" height="" >
			<table width="750" style="border:solid  1px #030303">
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
			<table width="750" style="border:solid  1px #030303">
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

			<table width="750" style="border:solid  1px #030303">
				<tr>
					<td> Saldo ala fecha:</td>
					<td> Q {{ f_num::get($saldo->total) }} </td>
					<td> Monto total abonado :</td>
					<td> Q {{ f_num::get($abonos_venta->monto) }} </td>
				</tr>
			</table>

			<table class="table" width="750">
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
		</div>
	</div>	 	
</body>
</html>


<style>
	.table {
		border-spacing: 0;
		margin-top:25px;
	}
	.table thead tr{
		border:#000000 1px solid;
	}

	.table {
		color:#666;
		font-size:12px;
		background:#eaebec;
		border:#000000 1px solid;
	}

	.table tr th {
		padding:10px 25px 11px 25px !important;
		background: #fafafa;
		text-align: center !important;
		border-left:1px solid #000000 !important;
		border-bottom:1px solid #000000 !important;

	}

	.table tr td {
		padding:10px !important;
		border-bottom:1px solid #000000 !important;
		border-left: 1px solid #000000 !important;
		background: #fafafa;
	}

	.table tr:last-child td{
		border-bottom:0;
	}
</style>
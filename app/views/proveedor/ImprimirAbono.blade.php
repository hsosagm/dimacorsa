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
					<td> {{ $abono->proveedor->nombre }} </td>
					<td> Direccion :</td>
					<td> {{ $abono->proveedor->direccion }} </td>
				</tr>
				<tr>
					<td> Nit :</td>
					<td> {{ $abono->proveedor->nit }} </td>
					<td> Telefono :</td>
					<td> {{ $abono->proveedor->telefono }} </td>
				</tr>
			</table>
			<br>
			<table width="750" style="border:solid  1px #030303">
				<tr>
					<td> Metodo Pago :</td>
					<td> {{ $abono->metodoPago->descripcion }} </td>
					<td> Fecha :</td>
					<td> {{ $abono->created_at}} </td>
				</tr>
				<tr>
					<td> Usuario :</td>
					<td colspan="3"> {{ $abono->user->nombre .' '. $abono->user->apellido}} </td>
				</tr>
				<tr>
					<td>Observaciones</td>
					<td colspan="3"> {{ $abono->observaciones }} </td>
				</tr>
			</table>

			<table width="750" style="border:solid  1px #030303">
				<tr>
					<td> Saldo ala fecha:</td>
					<td> Q {{ f_num::get($saldo->total) }} </td>
					<td> Monto total abonado :</td>
					<td> Q {{ f_num::get($abono->total) }} </td>
				</tr>
			</table>

			<table class="table" width="750">

				<thead>
					<tr class="">
						<th>No. Compra</th>
						<th>Total</th>
						<th>Monto Abonado </th>
						<th>Saldo Anterior</th>
						<th>Nuevo Saldo</th>
					</tr>
				</thead>
				<tbody >

					@foreach($detalle as $key => $dt)
					<?php
					$total = number_format($dt->total,2,'.',',');
					$monto = number_format($dt->monto,2,'.',',');

					$abonos = DetalleAbonosCompra::select(DB::raw('sum(monto) as total'))
					->where('compra_id','=',$dt->compra_id)
					->where('created_at','<',$dt->fecha)->first();

					$pagos = PagosCompra::select(DB::raw('sum(monto) as total'))
					->where('compra_id','=',$dt->compra_id)
					->where('metodo_pago_id','!=', 2)
					->where('created_at','<',$dt->fecha)->first();

		        // $saldo_ant = $dt->total - ($abonos->total + $pagos->total);
					$saldo_ant = $dt->total - ($abonos->total + $pagos->total);
					$saldo_anterior = number_format($saldo_ant ,2,'.',',');
					$saldo = number_format(($saldo_ant - $dt->monto),2,'.',',');
					?>
					<tr>
						<td>{{$dt->compra_id}}</td>
						<td class="align_right">{{$total}}</td>
						<td class="align_right">{{$monto}}</td>
						<td class="align_right">{{$saldo_anterior}}</td>
						<td class="align_right">{{$saldo}}</td>
					</tr>
					@endforeach

				</tbody>

				<tfoot width="100%">

				</tfoot>

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
<div width="Impresiones">
	<div width="ImpresionesBody">
		<table class="table table-bordered">
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
		<table class="table table-bordered">
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
		<table class="table table-bordered">
			<tr>
				<td> Saldo ala fecha:</td>
				<td> Q {{ f_num::get($saldo->total) }} </td>
				<td> Monto total abonado :</td>
				<td> Q {{ f_num::get($abono->monto) }} </td>
			</tr>
		</table>
		<table class="table table-condensed">
			<thead>
				<tr class="">
					<th>No. Compra</th>
					<th>Total</th>
					<th>Monto Abonado </th>
					<th>Saldo Anterior</th>
					<th>Nuevo Saldo</th>
				</tr>
			</thead>
			<tbody>
				@foreach($detalle as $key => $dt)
				<?php
				$total = f_num::get($dt->total);
				$monto = f_num::get($dt->monto);

				$abonos = DetalleAbonosCompra::select(DB::raw('sum(monto) as total'))
				->where('compra_id','=',$dt->compra_id)
				->where('created_at','<',$dt->fecha)->first();

				$pagos = PagosCompra::select(DB::raw('sum(monto) as total'))
				->where('compra_id','=',$dt->compra_id)
				->where('metodo_pago_id','!=', 2)
				->where('created_at','<',$dt->fecha)->first();

				$saldo_ant = $dt->total - ($abonos->total + $pagos->total);
				$saldo_anterior = f_num::get($saldo_ant);
				$saldo =  f_num::get(($saldo_ant - $dt->monto));
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
		</table>
	</div>
</div>

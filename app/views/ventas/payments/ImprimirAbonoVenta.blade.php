<?php 
	$brtdTop = "border-top:1px solid #444444;";
	$brtdBottom = "border-bottom:1px solid #444444; ";
	$brtdBT = "border-bottom:1px solid #444444; border-top:1px solid #444444; ";
?>
<div align="center"> 
	<h2>Comprobante de Abono de Cliente</h2>
</div>
<table width="100%">
	<tr>
		<td> Nombre :</td>
		<td> {{ $abonos_venta->cliente->nombre.' '.$abonos_venta->cliente->apellido}} </td>
		<td> Direccion :</td>
		<td> {{ $abonos_venta->cliente->direccion }} </td>
	</tr>
	<tr>
		<td colspan="4" style="{{$brtdBottom}}"></td>
	</tr>
	<tr>
		<td> Nit :</td>
		<td> {{ $abonos_venta->cliente->nit }} </td>
		<td> Telefono :</td>
		<td> {{ $abonos_venta->cliente->telefono }} </td>
	</tr>
	<tr>
		<td colspan="4" style="{{$brtdBottom}}"></td>
	</tr>
</table>
<br>
<br>
<table width="100%">
	<tr>
		<td colspan="4" style="{{$brtdBottom}}"></td>
	</tr>
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
	<tr>
		<td colspan="4" style="{{$brtdBottom}}"></td>
	</tr>
</table>

<table width="100%">
	<tr>
		<td> Saldo ala fecha:</td>
		<td> Q {{ f_num::get($saldo->total) }} </td>
		<td> Monto total abonado :</td>
		<td> Q {{ f_num::get($abonos_venta->monto) }} </td>
	</tr>
	<tr>
		<td colspan="4" style="{{$brtdBottom}}"></td>
	</tr>
</table>
<br><br>

<table width="100%">
	<tr>
		<td colspan="5" style="{{$brtdBottom}}"></td>
	</tr>

	<tr>
		<th>No. Venta</th>
		<th>Total</th>
		<th>Saldo Anterior</th>
		<th>Monto Abonado</th>
		<th>Nuevo Saldo</th>
	</tr>

	@foreach($detalle as $key => $dt)
	<tr>
		<td align="center">{{$dt->venta_id}}</td>
		<td align="center">{{$dt->total}}</td>
		<td align="center">{{$dt->saldo_anterior}}</td>
		<td align="center">{{$dt->monto}}</td>
		<td align="center">{{$dt->saldo}}</td>
	</tr>
	@endforeach
	<tr>
	<td colspan="5" style="{{$brtdBottom}}"></td>
	</tr>

</table>

<table width="100%" class="table">
	<thead>
		<tr>
			<td>No. Compra</td>
			<td>Total</td>
			<td>Saldo Anterior</td>
			<td>Monto Abonado</td>
			<td>Nuevo Saldo</td>
		</tr>
	</thead>
	<tbody>
		@foreach($detalle as $key => $dt)
		<tr>
			<td>{{$dt->compra_id}}</td>
			<td>{{$dt->total}}</td>
			<td>{{$dt->saldo_anterior}}</td>
			<td>{{$dt->monto}}</td>
			<td>{{$dt->saldo}}</td>
		</tr>
		@endforeach
	</tbody>
</table> 

<div class="form-footer" align="right">
	<input  class="btn theme-button" onClick="DeleteBalancePay(this,{{$abono_id}})" type="button" value="Eliminar" >
</div>

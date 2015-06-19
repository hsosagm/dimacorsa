<table width="100%" class="SST">
	<thead>
		<tr>
			<th>No. Compra</th>
			<th>Total</th>
			<th>Saldo Anterior</th>
			<th>Monto Abonado</th>
			<th>Nuevo Saldo</th>
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
	<input  class="btn btn-danger" onClick="DeleteBalancePay(this,{{$abono_id}})" type="button" value="Eliminar" >
</div>

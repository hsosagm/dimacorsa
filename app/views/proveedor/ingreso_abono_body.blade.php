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


<script>
	$(function() {
		$(".modal-body .form-footer").slideUp('slow', function() { 
			$(".modal-body :input").prop('disabled', true);
			$(".modal-body .form-footer").html('<button class="btn btn-default" data-dismiss="modal" type="button">Cerrar!</button> <input  class="btn theme-button" type="button" value="Eliminar" onClick="DeleteBalancePay({{$abono_id}})" >');
			$(".modal-body .form-footer").slideDown('slow', function() { });
		});

	});
</script>

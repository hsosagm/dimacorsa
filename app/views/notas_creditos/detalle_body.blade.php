<table class="table" width="100%" >
	<tbody>
	 	@foreach($detalle as $dt)
	 		<tr>
	 			<td width="70%"> {{ $dt->metodo_pago->descripcion }}  </td>
	 			<td width="30%" align="right" style="padding-right:25px !important"> {{ $dt->monto }} </td>
	 			<td width="5%">
	 				<i class="fa fa-trash-o fg-theme" onClick="EliminarDetalleNotaCreditoAdelanto(this, {{ $dt->id }});"></i>
	 			</td>
	 		</tr>
	 	@endforeach		
	</tbody>
</table>
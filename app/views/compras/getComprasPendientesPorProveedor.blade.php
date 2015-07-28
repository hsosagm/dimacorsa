<table class="DT_table_div" width="100%">
	<tr class="DT_table_div_detail">
		<td align="center">Factura</td>
		<td align="center">Fenca Ing.</td>
		<td align="center">Fecha Doc.</td>
		<td align="center">Usuario</td>
		<td align="center">Total</td>
		<td align="center">Saldo</td>
		<td align="center"></td>
	</tr>
	<tbody >
		@foreach($detalle as $key => $dt)
			<tr class="{{($dt->dias >= 30)? 'red':''}}">
				<td width="15%">{{$dt->factura }}</td>
				<td width="15%">{{$dt->fecha_ingreso}}</td>
				<td width="15%">{{$dt->fecha_documento}}</td>
				<td width="30%">{{$dt->usuario}}</td>
				<td width="10%">{{$dt->total }}</td>
				<td width="10%" class="right">{{$dt->saldo}}</td>
				<td width="5%" class="right"> 
					<i class="fa fa-plus-square btn-link theme-c" onclick="getCompraConDetalle(this, {{$dt->id}});"></i>
				</td>
			</tr>
		@endforeach
	</tbody>
	<tfoot width="100%">
		<tr>
			<td colspan="9">
				<div style="float:right" class="pagination_compras_por_proveedor"> {{ @$detalle->links() }} </div>
				
			</td>
		</tr>
	</tfoot>
</table>


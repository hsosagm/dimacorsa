<table class="DT_table_div" width="100%">
	<tr class="DT_table_div_detail">
		<td align="center">Fecha</td>
		<td align="center">Usuario</td>
		<td align="center">Total</td>
		<td align="center">Saldo</td>
		<td align="center"></td>
	</tr>
	<tbody >
		@foreach($detalle as $key => $dt)
			<tr class="{{($dt->dias >= 30)? 'red':''}}">
				<td width="15%">{{$dt->fecha_ingreso}}</td>
				<td width="30%">{{$dt->usuario}}</td>
				<td width="10%">{{$dt->total }}</td>
				<td width="10%" class="right">{{$dt->saldo}}</td>
				<td width="5%" class="right"> 
					<i class="fa fa-plus-square btn-link theme-c" onclick="getVentaConDetalle(this, {{$dt->id}});"></i>
				</td>
			</tr>
		@endforeach
	</tbody>
	<tfoot width="100%">
		<tr>
			<td colspan="9">
				<div style="float:right" class="pagination_ventas_por_cliente"> {{ @$detalle->links() }} </div>
				
			</td>
		</tr>
	</tfoot>
</table>


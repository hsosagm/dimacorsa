<table class="DT_table_div" width="100%">
	<tr class="DT_table_div_detail">
		<td align="center">No. Venta</td>
		<td align="center">Fecha</td>
		<td align="center">Cantidad</td>
		<td align="center">Producto</td>
		<td align="center">Usuario</td>
		<td align="center">Cliente</td>
		<td align="center">Utilidad</td>
		<td align="center">P. Venta</td>
		<td align="center"></td>
	</tr>
	<tbody >
		@foreach($detalle as $key => $dt)
		<tr>
			<td width="5%">{{$dt->id_venta }}</td>
			<td width="14%">{{$dt->fecha}}</td>
			<td width="5%">{{$dt->cantidad}}</td>
			<td width="21%">{{$dt->descripcion}}</td>
			<td width="18%">{{$dt->usuario }}</td>
			<td width="21%">{{$dt->cliente }}</td>
			<td width="7%" class="right">{{$dt->ganancias}}</td>
			<td width="6%" class="right">{{$dt->precio}}</td>
			<td width="3%" class="right"> 
				<i class="fa fa-plus-square btn-link theme-c" onclick="DetalleVentaCierre(this,{{ $dt->id_venta }})"></i>
			</td>
		</tr>
		@endforeach
	</tbody>
	<tfoot width="100%">
		<tr>
			<td colspan="9">
				<div style="float:right" class="pagination_cierre_ventas"> {{ @$detalle->links() }} </div>
				
			</td>
		</tr>
	</tfoot>
</table>


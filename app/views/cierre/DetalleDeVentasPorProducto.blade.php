<table class="DT_table_div" width="100%">
    <tr class="DT_table_div_detail">
        	<td align="center">No. Venta</td>
			<td align="center">Cantidad</td>
			<td align="center">Producto</td>
			<td align="center">Usuario</td>
			<td align="center">Cliente</td>
			<td align="center">Precio</td>
    </tr>
	<tbody >
		@foreach($detalle as $key => $dt)
			<tr>
				<td width="8%">{{$dt->venta_id}}</td>
				<td width="8%">{{$dt->cantidad}}</td>
				<td width="26%">{{$dt->producto->descripcion}}</td>
				<td width="25%">{{$dt->venta->user->nombre.' '.$dt->venta->user->apellido}}</td>
				<td width="25%">{{$dt->venta->cliente->nombre.' '.$dt->venta->cliente->apellido}}</td>
				<td width="8%" class="right">{{$dt->precio}}</td>
			</tr>
		@endforeach
	</tbody>
	<tfoot width="100%">
	</tfoot>
</table>
	 	 	 	

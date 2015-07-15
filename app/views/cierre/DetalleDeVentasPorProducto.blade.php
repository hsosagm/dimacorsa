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
    </tr>
	<tbody >
		@foreach($detalle as $key => $dt)
			<tr>
				<td width="5%">{{$dt->venta_id}}</td>
				<td width="14%">{{$dt->created_at}}</td>
				<td width="5%">{{$dt->cantidad}}</td>
				<td width="21%">{{$dt->producto->descripcion}}</td>
				<td width="20%">{{$dt->venta->user->nombre.' '.$dt->venta->user->apellido}}</td>
				<td width="21%">{{$dt->venta->cliente->nombre.' '.$dt->venta->cliente->apellido}}</td>
				<td width="8%" class="right">{{$dt->ganancias}}</td>
				<td width="6%" class="right">{{$dt->precio}}</td>
			</tr>
		@endforeach
	</tbody>
	<tfoot width="100%">
	</tfoot>
</table>
	 	 	 	

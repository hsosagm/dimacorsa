<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<table>
	<tr>
		<td height="30" colspan="10" align="center">
			<h1>Reporte de Kardex</h1>
		</td>
	</tr>
	<tr>
		<td  colspan="10" height="30" align="center">
			<h1>Del {{ Input::get('fecha_inicial') }} al {{ Input::get('fecha_final') }}</h1>
		</td>
	</tr>
	<tr>
		<td colspan="10" height="30" align="center">
			<h1>Producto: {{ $producto->descripcion }}</h1>
		</td>
	</tr>
	
</table>

<table>
	<tr style="background-color: #D5D5D5;">
		<td align="center"> <strong>Fecha </strong> </td>              
		<td align="center"> <strong>Usuario </strong> </td>             
		<td align="center"> <strong>Transaccion </strong> </td>         
		<td align="center"> <strong>Evento </strong> </td>              
		<td align="center"> <strong>Cantidad </strong> </td>            
		<td align="center"> <strong>Existencia </strong> </td>          
		<td align="center"> <strong>Costo Unitario </strong> </td>      
		<td align="center"> <strong>Costo Promedio </strong> </td>      
		<td align="center"> <strong>Costo del Movimiento </strong> </td>
		<td align="center"> <strong>Total Acumulado </strong> </td> 
	</tr>
	<?php $i = 0 ?>
	@foreach($kardex as $data)
		@if($i == 0)
			<tr>
				<td> {{ $data->fecha }} </td>
				<td> {{ $data->usuario }} </td>
				<td> {{ $data->transaccion }} </td>
				<td> {{ $data->evento }} </td>
				<td> {{ $data->cantidad }} </td>
				<td> {{ $data->existencia }} </td>
				<td align="right"> {{ $data->costo }} </td>
				<td align="right"> {{ $data->costo_promedio }} </td>
				<td align="right"> {{ $data->total_movimiento }} </td>
				<td align="right"> {{ $data->total_acumulado }} </td>
			</tr>
			<?php $i = 1; ?>
		@else
			<tr style="background-color: #ECECEC;">
				<td> {{ $data->fecha }} </td>
				<td> {{ $data->usuario }} </td>
				<td> {{ $data->transaccion }} </td>
				<td> {{ $data->evento }} </td>
				<td> {{ $data->cantidad }} </td>
				<td> {{ $data->existencia }} </td>
				<td align="right"> {{ $data->costo }} </td>
				<td align="right"> {{ $data->costo_promedio }} </td>
				<td align="right"> {{ $data->total_movimiento }} </td>
				<td align="right"> {{ $data->total_acumulado }} </td>
			</tr>
			<?php $i = 0; ?>
		@endif
	@endforeach
</table>

 

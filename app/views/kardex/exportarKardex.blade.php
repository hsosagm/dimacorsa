<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<table width="100%">
	@if(trim($tipo) == 'pdf')
		<tr>
			<td height="60" colspan="10" align="center">
				<h1>Reporte de Kardex</h1>
				<h1>Del {{ Input::get('fecha_inicial') }} al {{ Input::get('fecha_final') }}</h1>
				<h1>Producto: {{ $producto->descripcion }}</h1>
			</td>
		</tr>
	@else
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
	@endif
</table>

<table width="97%">
	<tr style="background-color: #D5D5D5;">
		<td align="center" width="18%"> <strong>Fecha </strong> </td>
		<td align="center" width="15%"> <strong>Tienda/Usuario </strong> </td>
		<td align="center" width="10%"> <strong>Transaccion </strong> </td>
		<td align="center" width="8%"> <strong>Evento </strong> </td>
		<td align="center" width="5%"> <strong>Cantidad </strong> </td>
		<td align="center" width="5%"> <strong>Existencia </strong> </td>
		<td align="center" width="9%"> <strong>Costo Unitario </strong> </td>
		<td align="center" width="10%"> <strong>Costo Promedio </strong> </td>
		<td align="center" width="10%"> <strong>Costo del Movimiento </strong> </td>
		<td align="center" width="10%"> <strong>Total Acumulado </strong> </td>
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


<style>
	@page { margin: 10px; }
body { margin: 10px; }
</style>

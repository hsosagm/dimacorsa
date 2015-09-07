<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<table>
	<tr>
		<td height="30" colspan="5" align="center">
			<h1>Reporte general de estado de cuenta de Clientes</h1>
		</td>
	</tr>
	<tr>
		<td  colspan="5" height="30" align="center">
			<h1>Fecha : {{ Carbon::now() }}</h1>
		</td>
	</tr>
</table>

<table>
	<tr style="background-color: #D5D5D5;">
		<td align="center"> <strong>Cliente </strong> </td>              
		<td align="center"> <strong>Direccion </strong> </td>            
		<td align="center"> <strong>Total </strong> </td>          
		<td align="center"> <strong>Saldo Total</strong> </td>      
		<td align="center"> <strong>Saldo Vencido</strong> </td>      
	</tr>

	<?php $i = 0 ?>
	@foreach($data['ventas'] as $dt)
		@if($i == 0)
			<tr height="15" >
				<td>{{ $dt->cliente }} </td>              
				<td>{{ $dt->direccion }} </td>            
				<td align="right">{{ $dt->total }} </td>          
				<td align="right">{{ $dt->saldo_total }} </td>      
				<td align="right">{{ $dt->saldo_vencido }}</td>    
			</tr>
			<?php $i = 1; ?>
		@else
			<tr height="15" style="background-color: #ECECEC;" >
				<td>{{ $dt->cliente }} </td>              
				<td>{{ $dt->direccion }} </td>            
				<td align="right">{{ $dt->total }} </td>          
				<td align="right">{{ $dt->saldo_total }} </td>      
				<td align="right">{{ $dt->saldo_vencido }}</td>    
			</tr>
			<?php $i = 0; ?>
		@endif
	@endforeach
</table>
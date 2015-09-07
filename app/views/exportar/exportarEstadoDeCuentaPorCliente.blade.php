
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<table>
	<tr>
		<td height="30" colspan="4" align="center">
			<h1>Reporte de estado de cuenta del Cliente</h1>
		</td>
	</tr>
	<tr>
		<td height="30" colspan="4" align="center">
			<h1>{{ $data['cliente'] }}</h1>
		</td>
	</tr>
	<tr>
		<td  colspan="4" height="30" align="center">
			<h1>Fecha : {{ Carbon::now() }}</h1>
		</td>
	</tr>
</table>

<table>
	<tr style="background-color: #D5D5D5;">
		<td align="center"> <strong>Fecha </strong> </td>              
		<td align="center"> <strong>Usuario </strong> </td>            
		<td align="center"> <strong>Total </strong> </td>          
		<td align="center"> <strong>Saldo</strong> </td>      
	</tr>

	<?php $i = 0 ?>
	@foreach($data['ventas'] as $dt)
		@if($i == 0)
			<tr height="15" style="{{($dt->dias >= 30)? 'background-color:#FFE3E3;':''}}">
				<td>{{ $dt->fecha_ingreso }} </td>              
				<td>{{ $dt->usuario }} </td>            
				<td align="right">{{ $dt->total }} </td>          
				<td align="right">{{ $dt->saldo }} </td>      
			</tr>
			<?php $i = 1; ?>
		@else
			<tr height="15" style="background-color: #ECECEC;{{($dt->dias >= 30)? 'background-color:#FFE3E3;':''}}" >
				<td>{{ $dt->fecha_ingreso }} </td>              
				<td>{{ $dt->usuario }} </td>            
				<td align="right">{{ $dt->total }} </td>          
				<td align="right">{{ $dt->saldo }} </td>   
			</tr>
			<?php $i = 0; ?>
		@endif
	@endforeach
</table>
<table>
	<tr style="background-color: #FFFFFF;">
		<td height="30" colspan="4" align="center">
			<h1>Reporte de estado de cuenta del Cliente</h1>
		</td>
	</tr>
	<tr style="background-color: #FFFFFF;">
		<td height="30" colspan="4" align="center">
			<h1>{{ $data['cliente'] }}</h1>
		</td>
	</tr>
	<tr style="background-color: #FFFFFF;">
		<td  colspan="4" height="30" align="center">
			<h1>Fecha : {{ Carbon::now() }} <?php $i = 0 ?></h1>
		</td>
	</tr>
	<tr style="background-color: #D5D5D5;"><?php $i = 0 ?>
		<td align="center"> <strong>Fecha </strong> </td>              
		<td align="center"> <strong>Usuario </strong> </td>            
		<td align="center"> <strong>Total </strong> </td>          
		<td align="center"> <strong>Saldo</strong> </td>      
	</tr>
	@foreach($data['ventas'] as $dt)
			<tr height="15" style="{{($i == 1)?'background-color: #ECECEC;':'background-color: #FFFFFF;'}}{{($dt->dias >= 30)? 'background-color:#FFE3E3;':''}}" >
				<td>{{ $dt->fecha_ingreso }} </td>              
				<td>{{ $dt->usuario }} </td>            
				<td align="right">{{ $dt->total }} </td>          
				<td align="right">{{ $dt->saldo }} <?php ($i == 0)? $i=1:$i=0; ?></td>   
			</tr>
	@endforeach
</table>
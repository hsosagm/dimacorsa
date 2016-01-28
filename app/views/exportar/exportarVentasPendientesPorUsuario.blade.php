<table width="100%">
	<tr style="background-color: #FFFFFF;">
		<td height="30" colspan="4" align="center">
			<h1>VENTAS PENDIENTES DE PAGO POR USUARIO</h1>
		</td>
	</tr>
	<tr style="background-color: #FFFFFF;">
		<td height="15" colspan="4" align="left">
			<strong>Usuario: {{ $data['usuario'] }}</strong>
		</td>
	</tr>
	<tr style="background-color: #FFFFFF;">
		<td  colspan="4" height="15" align="left">
			<strong>Fecha : {{ Carbon::now() }}</strong>
		</td>
	</tr>
	<tr style="background-color: #D5D5D5;">
		<td align="center" width="10%"> <strong>No. Doc.</strong> </td>              
		<td align="center" width="20%"> <strong>Fecha</strong> </td>              
		<td align="center" width="38%"> <strong>Cliente</strong> </td>            
		<td align="center" width="12%"> <strong>Telefono</strong> </td>            
		<td align="center" width="10%"> <strong>Total </strong> </td>          
		<td align="center" width="10%"> <strong>Saldo</strong> <?php $i = 0 ?> </td>      
	</tr>
	@foreach($data['ventas'] as $dt)
		<tr height="15" style="{{($i == 1)?'background-color: #ECECEC;':'background-color: #FFFFFF;'}}{{($dt->dias >= 30)? 'background-color:#FFE3E3;':''}}" >
			<td>{{ $dt->venta_id }}</td>
			<td>{{ $dt->fecha_ingreso }}</td>              
			<td>{{ $dt->cliente }}</td>            
			<td>{{ (strlen($dt->telefono) > 7)? $dt->telefono:'-' }}</td>            
			<td align="right">{{ f_num::get($dt->total) }}</td>          
			<td align="right">{{ f_num::get($dt->saldo) }} <?php ($i == 0)? $i=1:$i=0; ?> </td>      
		</tr>
	@endforeach
</table>
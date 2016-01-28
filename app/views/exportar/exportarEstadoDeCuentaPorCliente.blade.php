<table width="100%">
	<tr style="background-color: #FFFFFF;">
		<td height="30" colspan="4" align="center">
			<h1>ESTADO DE CUENTA</h1>
		</td>
	</tr>
	<tr style="background-color: #FFFFFF;">
		<td height="15" colspan="4" align="left">
			Cliente: <strong> {{ $data['cliente']['nombre'] }} </strong>
		</td>
	</tr>
	<tr style="background-color: #FFFFFF;">
		<td height="15" colspan="4" align="left">
			Telefono: <strong> {{ $data['cliente']['telefono'] }} </strong>
		</td>
	</tr>
	<tr style="background-color: #FFFFFF;">
		<td height="15" colspan="4" align="left">
			Direccion: <strong> {{ $data['cliente']['direccion'] }} </strong>
		</td>
	</tr>
	<tr style="background-color: #FFFFFF;">
		<td  colspan="4" height="15" align="left">
			Fecha: <strong> {{ Carbon::now() }} @php($i = 0); </strong>
		</td>
	</tr>
	<tr style="background-color: #D5D5D5;">
		<td align="center" width="25%"> <strong>Fecha</strong> </td>              
		<td align="center" width="35%"> <strong>Usuario</strong> </td>            
		<td align="center" width="20%"> <strong>Total</strong> </td>          
		<td align="center" width="20%"> <strong>Saldo</strong> </td>      
	</tr>
	@foreach($data['ventas'] as $dt)
			<tr height="15" style="{{($i == 1)?'background-color: #ECECEC;':'background-color: #FFFFFF;'}}{{($dt->dias >= 30)? 'background-color:#FFE3E3;':''}}" >
				<td>{{ $dt->fecha_ingreso }}</td>              
				<td>{{ $dt->usuario }}</td>            
				<td align="right">{{ $dt->total }}</td>          
				<td align="right">{{ $dt->saldo }} <?php ($i == 0)? $i=1:$i=0; ?></td>   
			</tr>
	@endforeach
</table>
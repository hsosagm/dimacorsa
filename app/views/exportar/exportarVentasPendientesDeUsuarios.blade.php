<table width="100%">
	<tr>
		<td height="30" colspan="5" align="center" style="background-color: #FFFFFF;">
			<h1>Reporte general de ventas pendientes de pago de Usuarios</h1>
		</td>
	</tr>
	<tr>
		<td  colspan="5" height="30" align="center" style="background-color: #FFFFFF;">
			<h1>Fecha : {{ Carbon::now() }}</h1>
		</td>
	</tr>
	<tr style="background-color: #D5D5D5;">
		<td align="center" width="20%"> <strong>Usuario </strong> </td>              
		<td align="center" width="40%"> <strong>Tienda </strong> </td>            
		<td align="center" width="10%"> <strong>Total Ventas </strong> </td>          
		<td align="center" width="10%"> <strong>Saldo Total</strong> </td>      
		<td align="center" width="10%"> <strong>Saldo Vencido</strong> @php($i = 0); </td>      
	</tr>
	@foreach($data['ventas'] as $dt)
		<tr height="15" style="{{($i == 1)?'background-color: #ECECEC;':'background-color: #FFFFFF;'}}" >
			<td>{{ $dt->usuario }}</td>              
			<td>{{ $dt->tienda }}</td>            
			<td align="right">{{ f_num::get($dt->total) }}</td>          
			<td align="right">{{ f_num::get($dt->saldo_total) }}</td>      
			<td align="right">{{ f_num::get($dt->saldo_vencido) }} <?php ($i == 0)? $i=1:$i=0; ?> </td>    
		</tr>
	@endforeach
</table>
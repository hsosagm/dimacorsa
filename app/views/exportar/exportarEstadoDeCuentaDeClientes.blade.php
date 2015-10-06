<table>
	<tr style="background-color: #FFFFFF;">
		<td height="30" colspan="5" align="center">
			<h1>Reporte general de estado de cuenta de Clientes</h1>
		</td>
	</tr>
	<tr style="background-color: #FFFFFF;">
		<td  colspan="5" height="30" align="center">
			<h1>Fecha : {{ Carbon::now() }}</h1>
		</td>
	</tr>
	<tr style="background-color: #D5D5D5;">
		<td align="center"><strong>Cliente</strong></td>
		<td align="center"><strong>Direccion</strong></td>
		<td align="center"><strong>Total</strong></td>
		<td align="center"><strong>Saldo Total</strong></td>
		<td align="center"><strong>Saldo Vencido</strong> <?php $i = 0 ?> </td>
	</tr>
	@foreach($data['ventas'] as $dt)
		<tr height="15" style="{{($i == 1)?'background-color: #ECECEC;':'background-color: #FFFFFF;'}}" >
			<td>{{ $dt->cliente }}</td>
			<td>{{ $dt->direccion }}</td>
			<td align="right">{{ $dt->total }}</td>
			<td align="right">{{ $dt->saldo_total }}</td>
			<td align="right">{{ $dt->saldo_vencido }} <?php ($i == 0)? $i=1:$i=0; ?> </td>    
		</tr>
	@endforeach
</table>

<table width="70%">
	<tr style="background-color: #FFFFFF;">
		<td height="30" colspan="5" align="center">
			<h1>REPORTE DE INVENTARIO ACTUAL</h1>
		</td>
	</tr>
	<tr style="background-color: #FFFFFF;">
		<td  colspan="5" height="30" align="center">
			<h1>Fecha : {{ Carbon::now() }}</h1>
		</td>
	</tr>
	<tr style="background-color: #D5D5D5;">
		<td align="center"><strong>CODIGO</strong></td>
		<td align="center"><strong>DESCRIPCION</strong></td>
		<td align="center"><strong>P. COSTO</strong></td>
        <td align="center"><strong>P. PUBLICO</strong> </td>
        <td align="center"><strong>EXISTENCIA</strong> </td>
		<td align="center"><strong>TOTAL</strong> </td>
	</tr>
	@foreach($data['productos'] as $dt)
		<tr height="15">
			<td>{{ $dt->codigo }}</td>
			<td>{{ $dt->descripcion }}</td>
			<td align="right">{{ $dt->p_costo }}</td>
            <td align="right">{{ $dt->p_publico }}</td>
            <td align="right">{{ $dt->existencia }}</td>
			<td align="right">{{ $dt->existencia_total }}</td>
		</tr>
	@endforeach
</table>

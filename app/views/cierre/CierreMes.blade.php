<table width="100%" class="SST">
 
	<thead>
		<tr>
			<th width="20%" style="text-align: center;" >Ventas</th>
			<th width="20%" style="text-align: center;" >Ganancias</th>
			<th width="20%" style="text-align: center;" >Soporte</th>
			<th width="20%" style="text-align: center;" >Gastos</th>
			<th width="20%" style="text-align: center;" >Ganancias Netas</th>
		</tr>

	</thead>

	<tbody>
		<tr>
			<td style="text-align: right;">{{ $total_ventas    }}</td>
			<td style="text-align: right;">{{ $total_ganancias }}</td>
			<td style="text-align: right;">{{ $total_soporte   }}</td>
			<td style="text-align: right;">{{ $total_gastos    }}</td>
			<td style="text-align: right;">{{ $ganancias_netas }}</td>
		</tr>
		<tr>
			<td colspan="5">
			</td>
		</tr>
		<tr>
			<th colspan="5">
				- Ventas por Usuario -
			</th>
		</tr>
		@foreach(@$ventas_usuarios as $key => $user)
			<tr class="cierre_body">
				<td colspan="2">{{ $user->nombre .' '. $user->apellido}}</td>
				<td style="text-align: right;">{{ $user->total }} </td>
				<td style="text-align: right;">{{ $user->utilidad }} </td>
				<td style="text-align: right;"> </td>
			</tr>
		@endforeach 
		<tr>
			<th colspan="5">
			</th>
		</tr>
		<tr class="">
			<th colspan="5">
			</th>
		</tr>

	<tfoot>
		<tr>
			<td colspan="2">Inversion Actual :</td>
			<td style="text-align: right;"> {{ $inversion_actual }} </td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td colspan="2">Ventas Creditos  :</td>
			<td style="text-align: right;"> {{ $ventas_credito }}</td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td colspan="2">Compras Creditos :</td>
			<td style="text-align: right;"> {{ $compras_credito }} </td>
			<td colspan="2"></td>
		</tr>
	</tfoot>

</table>
<style type="text/css">
	.bs-modal .Lightbox{width: 850px;} 
	.modal-body { padding: 0px 0px 0px; }
</style>
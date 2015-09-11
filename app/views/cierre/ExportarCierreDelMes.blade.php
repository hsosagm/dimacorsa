<table width="100%">
	<thead > 
		<tr>
			<td colspan="5" align="center"> <h2>Balance General - {{$data['mes']}} </h2></td>
		</tr>
		
		<tr>
			<td width="20%" style="text-align: center;">Ventas</td>
			<td width="20%" style="text-align: center;" >Utilidades</td>
			<td width="20%" style="text-align: center;" >Soporte</td>
			<td width="20%" style="text-align: center;" >Gastos	</td>
			<td width="20%" style="text-align: center;" >Utilidades Netas</td>
		</tr>
		<tr> <td colspan="5" style="border-top:1px solid"></td></tr>

		<tr>
			<td style="text-align: right;"> {{ ($data['total_ventas'] )}} </td>
			<td style="text-align: right;"> {{ ($data['total_ganancias'] )}} 
				@if($data['total_ventas'] > 0)
				(%{{ f_num::get(($data['total_ganancias']*100)/$data['total_ventas']) }})
				@endif
			</td>
			<td style="text-align: right;"> {{ ($data['total_soporte']   )}} </td>
			<td style="text-align: right;"> {{ ($data['total_gastos']    )}} 
				@if($data['total_ventas'] > 0)
				(%{{ f_num::get(($data['total_gastos']*100)/$data['total_ventas']) }})
				@endif
			</td>
			<td style="text-align: right;"> {{ ($data['ganancias_netas'] )}} 
				@if($data['total_ventas'] > 0)
				(%{{ f_num::get(($data['ganancias_netas'] *100)/$data['total_ventas']) }})
				@endif
			</td>
		</tr>
		<tr> <td colspan="5" style="border-top:1px solid"></td></tr>		

	</thead>

	<tbody class="table-hover cierre_body cierre_detalle" style="">
		<tr>
			<td colspan="5" style="text-align: center;"><br><br>
				- Ventas por Usuario - 
			</td>
		</tr>
		<tr> <td colspan="5" style="border-top:1px solid"></td></tr>

		@foreach(@$ventas_usuarios as $key => $user)
		<tr>
			<td colspan="2" class="fg-theme"> {{ $user->nombre .' '. $user->apellido}}</td>
			<td style="text-align: right;"> {{ f_num::get($user->total) }} </td>
			<td style="text-align: right;"> {{ f_num::get($user->utilidad) }} </td>
			<td style="text-align: right;">%{{ f_num::get(($user->utilidad * 100 )/str_replace(',', '', $user->total ))}}</td>
		</tr>
		@endforeach 
		<tr> <td colspan="5" style="border-top:1px solid"></td></tr>
		<tr> <td colspan="5" style="border-top:1px solid"></td></tr>

		<tr>
			<td colspan="2">Inversion Actual :</td>
			<td style="text-align: right;"> {{ $data['inversion_actual'] }} </td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td colspan="2">Cuentas por Cobrar :</td>
			<td style="text-align: right;"> {{ $data['ventas_credito'] }} </td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td colspan="2">Cuentas por Pagar :</td>
			<td style="text-align: right;"> {{ $data['compras_credito'] }} </td>
			<td colspan="2"></td>
		</tr>
		<tr> <td colspan="5" style="border-top:1px solid"></td></tr>
	</tbody>
</table>

<style>
	td{ height:20px;}
	th{ height:20px;}
</style>
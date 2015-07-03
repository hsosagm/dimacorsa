<table class="DT_table_div" width="100%">
	<tr>
		<td class="center" width="25%">  </td>
		<td class="center" width="25%">Esperado</td>
		<td class="center" width="25%">Real</td>
		<td class="center" width="25%">Efectivo</td>
	</tr>

	<tbody >
		<tr>
			<td>Efectivo</td>
			<td> Q {{ f_num::get($cierre->efectivo_esp) }} </td>
			<td> Q {{ f_num::get($cierre->efectivo) }} </td>
			<td> Q {{ f_num::get($cierre->efectivo_esp - $cierre->efectivo) }} </td>
		</tr>
		<tr>
			<td>Cheque</td>
			<td> Q {{ f_num::get($cierre->cheque_esp) }} </td>
			<td> Q {{ f_num::get($cierre->cheque) }} </td>
			<td> Q {{ f_num::get($cierre->cheque_esp - $cierre->cheque) }} </td>
		</tr>
		<tr>
			<td>Tarjeta</td>
			<td> Q {{ f_num::get($cierre->tarjeta_esp) }} </td>
			<td> Q {{ f_num::get($cierre->tarjeta) }} </td>
			<td> Q {{ f_num::get($cierre->tarjeta_esp - $cierre->tarjeta) }} </td>
		</tr>
		<tr>
			<td>Deposito</td>
			<td> Q {{ f_num::get($cierre->deposito_esp) }} </td>
			<td> Q {{ f_num::get($cierre->deposito) }} </td>
			<td> Q {{ f_num::get($cierre->deposito_esp - $cierre->deposito) }} </td>
		</tr>

	</tbody>

	<tfoot width="100%">
	<?php 
		$suma_esperado = $cierre->efectivo_esp + $cierre->cheque_esp + $cierre->tarjeta_esp + $cierre->deposito_esp;
		$suma_real     = $cierre->efectivo + $cierre->cheque + $cierre->tarjeta + $cierre->deposito;
	 ?>
		<tr>
			<td></td>
			<td>Total</td>
			<td> {{ f_num::get($suma_real) }} </td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td>Diferencia</td>
			<td>{{ f_num::get($suma_esperado - $suma_real) }}</td>
			<td></td>
		</tr>
		<tr>
			<td colspan="4">
				- {{ $cierre->nota }}
			</td>
		</tr>
	</tfoot>
</table>
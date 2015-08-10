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
			<td class="right"> Q {{ f_num::get($cierre->efectivo_esp) }} </td>
			<td class="right"> Q {{ f_num::get($cierre->efectivo) }} </td>
			<td class="right"> Q {{ f_num::get($cierre->efectivo - $cierre->efectivo_esp) }} </td>
		</tr>
		<tr>
			<td>Cheque</td>
			<td class="right"> Q {{ f_num::get($cierre->cheque_esp) }} </td>
			<td class="right"> Q {{ f_num::get($cierre->cheque) }} </td>
			<td class="right"> Q {{ f_num::get($cierre->cheque - $cierre->cheque_esp) }} </td>
		</tr>
		<tr>
			<td>Tarjeta</td>
			<td class="right"> Q {{ f_num::get($cierre->tarjeta_esp) }} </td>
			<td class="right"> Q {{ f_num::get($cierre->tarjeta) }} </td>
			<td class="right"> Q {{ f_num::get($cierre->tarjeta - $cierre->tarjeta_esp) }} </td>
		</tr>
		<tr>
			<td>Deposito</td>
			<td class="right"> Q {{ f_num::get($cierre->deposito_esp) }} </td>
			<td class="right"> Q {{ f_num::get($cierre->deposito) }} </td>
			<td class="right"> Q {{ f_num::get($cierre->deposito - $cierre->deposito_esp) }} </td>
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
			<td class="right">Q {{ f_num::get($suma_real) }} </td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td>Diferencia</td>
			<td class="right">Q {{ f_num::get($suma_real - $suma_esperado) }}</td>
			<td></td>
		</tr>
		<tr>
			<td colspan="4">
				- {{ $cierre->nota }}
			</td>
		</tr>
	</tfoot>
</table>
<p>
	Cierre realizado por {{ $cierre->user->nombre .' '. $cierre->user->apellido }}
</p>
<p>	
	Fecha de creacion : {{ $cierre->created_at }}
</p>
<table class="table" width="100%">
	<tr>
		<th class="center" width="25%">  </th>
		<th class="center" width="25%">Esperado</th>
		<th class="center" width="25%">Real</th>
		<th class="center" width="25%">Efectivo</th>
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
	</tfoot>
</table>
- {{ $cierre->nota }}

<style>
	.table {
		border-spacing: 0;
		margin-top:25px;
	}
	.table thead tr{
		border:#000000 1px solid;
	}
	.table tfoot tr  td{
		border-top:#000000 1px solid;
	}

	.table {
		color:#000000;
		font-size:12px;
		border:#000000 1px solid;
	}

	.table tr th {
		padding:10px 25px 11px 25px !important;
		text-align: center !important;
		border-bottom:1px solid #000000 !important;

	}

	.table tr td {
		padding:10px !important;
		border-left: 1px solid #000000 !important;
	}

	.table tr:last-child td{
		border-bottom:0;
	}
</style>
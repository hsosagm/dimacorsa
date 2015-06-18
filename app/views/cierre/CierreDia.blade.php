	<table width="100%" class="table table-responsive">

		<thead>

			<tr>
				<td width="30%">Descripcion</td>
				<td width="12%">Efectivo</td>
				<td width="12%">Credito</td>
				<td width="12%">Cheque</td>
				<td width="12%">Tarjeta</td>
				<td width="12%">Deposito</td>
				<td width="12%">Totales</td>
			</tr>

		</thead>

		<tbody class="table-hover cierre_body">

			<tr class="">
				<td>Ventas</td>
				<td class="right"> {{ $pagos_ventas['efectivo'] }} </td> <!-- al credito -->
				<td class="right"> {{ $pagos_ventas['credito'] }} </td> <!-- al credito -->
				<td class="right"> {{ $pagos_ventas['cheque']  }} </td> <!-- con cheque -->
				<td class="right"> {{ $pagos_ventas['tarjeta'] }} </td> <!-- con tarjeta -->
				<td class="right"> {{ $pagos_ventas['deposito']}} </td> <!-- con deposito -->
				<td class="right"> {{ f_num::get($pagos_ventas['total']) }} </td> <!-- total -->
			</tr>

			<tr>
				<td>Abonos</td>
				<td class="right"> {{ $abonos_ventas['efectivo'] }} </td> <!-- al credito -->
				<td class="right"> {{ $abonos_ventas['credito'] }} </td> <!-- al credito -->
				<td class="right"> {{ $abonos_ventas['cheque']  }} </td> <!-- con cheque -->
				<td class="right"> {{ $abonos_ventas['tarjeta'] }} </td> <!-- con tarjeta -->
				<td class="right"> {{ $abonos_ventas['deposito']}} </td> <!-- con deposito -->
				<td class="right"> {{ f_num::get($abonos_ventas['total'])  }} </td> <!-- total -->
			</tr>

			<tr>
				<td>Soporte</td>
				<td class="right"> {{ $soporte['efectivo'] }} </td> <!-- al credito -->
				<td class="right"> {{ $soporte['credito'] }} </td> <!-- al credito -->
				<td class="right"> {{ $soporte['cheque']  }} </td> <!-- con cheque -->
				<td class="right"> {{ $soporte['tarjeta'] }} </td> <!-- con tarjeta -->
				<td class="right"> {{ $soporte['deposito']}} </td> <!-- con deposito -->
				<td class="right"> {{ f_num::get($soporte['total'])  }} </td> <!-- total -->
			</tr>

			<tr>
				<td>Adelantos</td>
				<td class="right"> {{ $adelantos['efectivo'] }} </td> <!-- al credito -->
				<td class="right"> {{ $adelantos['credito'] }} </td> <!-- al credito -->
				<td class="right"> {{ $adelantos['cheque']  }} </td> <!-- con cheque -->
				<td class="right"> {{ $adelantos['tarjeta'] }} </td> <!-- con tarjeta -->
				<td class="right"> {{ $adelantos['deposito']}} </td> <!-- con deposito -->
				<td class="right"> {{ f_num::get($adelantos['total'])   }} </td> <!-- total -->
			</tr>

			<tr>
				<td>Ingresos</td>
				<td class="right"> {{ $ingresos['efectivo'] }} </td> <!-- al credito -->
				<td class="right"> {{ $ingresos['credito'] }} </td> <!-- al credito -->
				<td class="right"> {{ $ingresos['cheque']  }} </td> <!-- con cheque -->
				<td class="right"> {{ $ingresos['tarjeta'] }} </td> <!-- con tarjeta -->
				<td class="right"> {{ $ingresos['deposito']}} </td> <!-- con deposito -->
				<td class="right"> {{ f_num::get($ingresos['total'])   }} </td> <!-- total -->
			</tr>

			<tr>
				<td>Gastos</td>
				<td class="right">({{ ($gastos['efectivo'] == 0) ?  '0.00':$gastos['efectivo']}})</td> <!--  en efectivo -->
				<td class="right"> {{ $gastos['credito'] }} </td> <!-- al credito -->
				<td class="right"> {{ $gastos['cheque']  }} </td> <!-- con cheque -->
				<td class="right"> {{ $gastos['tarjeta'] }} </td> <!-- con tarjeta -->
				<td class="right"> {{ $gastos['deposito']}} </td> <!-- con deposito -->
				<td class="right"> {{ f_num::get($gastos['total'])   }} </td> <!-- total -->
			</tr>

			<tr>
				<td>Egresos</td>
				<td class="right">({{ ($egresos['efectivo'] == 0) ?  '0.00':$egresos['efectivo']}})</td> <!--  en efectivo -->
				<td class="right"> {{ $egresos['credito'] }} </td> <!-- al credito -->
				<td class="right"> {{ $egresos['cheque']  }} </td> <!-- con cheque -->
				<td class="right"> {{ $egresos['tarjeta'] }} </td> <!-- con tarjeta -->
				<td class="right"> {{ $egresos['deposito']}} </td> <!-- con deposito -->
				<td class="right"> {{ f_num::get($egresos['total'])   }} </td> <!-- total -->
			</tr>

			<tr>
				<td>Pagos Compras</td>
				<td class="right"> ({{ ($pagos_compras['efectivo'] == 0) ?  '0.00':$pagos_compras['efectivo']}}) </td> <!--en efectivo -->
				<td class="right"> {{ $pagos_compras['credito'] }} </td> <!-- al credito -->
				<td class="right"> {{ $pagos_compras['cheque']  }} </td> <!-- con cheque -->
				<td class="right"> {{ $pagos_compras['tarjeta'] }} </td> <!-- con tarjeta -->
				<td class="right"> {{ $pagos_compras['deposito']}} </td> <!-- con deposito -->
				<td class="right"> {{ f_num::get($pagos_compras['total'])   }} </td> <!-- total -->
			</tr>

			<tr>
				<td>Abonos Compras</td>
				<td class="right"> ({{ ($abonos_compras['efectivo'] == 0) ?  '0.00':$abonos_compras['efectivo']}}) </td> <!--en efectivo -->
				<td class="right"> {{ $abonos_compras['credito'] }} </td> <!--al credito -->
				<td class="right"> {{ $abonos_compras['cheque']  }} </td> <!--con cheque -->
				<td class="right"> {{ $abonos_compras['tarjeta'] }} </td> <!--con tarjeta -->
				<td class="right"> {{ $abonos_compras['deposito']}} </td> <!--con deposito -->
				<td class="right"> {{ f_num::get($abonos_compras['total'])  }} </td> <!-- total-->
			</tr>

			<tr>
				<td>Efectivo esperado en caja</td>
				<td>
					<?php 
					$caja_negativos = $abonos_compras['efectivo'] + $pagos_compras['efectivo'] + $egresos['efectivo'] + $gastos['efectivo'];

					$caja_positivos = $ingresos['efectivo'] + $adelantos['efectivo'] + $soporte['efectivo'] + $pagos_ventas['efectivo'] + $abonos_ventas['efectivo'];

					$caja =  $caja_positivos - $caja_negativos;
					$total_caja = number_format($caja,2,'.',','); 

					echo $total_caja;
					?>
				</td> 
				<td></td> 
				<td></td> 
				<td></td>
				<td></td> 
				<td></td> 
			</tr>

		</tbody>

	</table>

<style type="text/css">
	.bs-modal .Lightbox{width: 850px !important;} 
	.modal-body { padding: 0px 0px 0px; }
	.cierre_body .right {
		text-align:right; 
		margin-right:20px !important;
		padding-right:20px !important;
	}
</style>
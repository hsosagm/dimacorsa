<table width="100%" class="table table-responsive">

	<thead>

		<tr>
			<td width="30%">Descripcion</td>
			<td width="12%">Efectivo</td>
			<td width="12%">Credito</td>
			<td width="12%">Cheque</td>
			<td width="12%">Targeta</td>
			<td width="12%">Deposito</td>
			<td width="12%">Totales</td>
		</tr>

	</thead>

	<tbody class="table-hover">
		
		<tr class="">
			<td>Ventas</td>
			<td> {{ $abonos_ventas['efectivo'] }} </td> <!-- al credito -->
			<td> {{ $abonos_ventas['credito'] }} </td> <!-- al credito -->
			<td> {{ $abonos_ventas['cheque']  }} </td> <!-- con cheque -->
			<td> {{ $abonos_ventas['tarjeta'] }} </td> <!-- con tarjeta -->
			<td> {{ $abonos_ventas['deposito']}} </td> <!-- con deposito -->
			<td> {{ $abonos_ventas['total']   }} </td> <!-- total -->
		</tr>
		
		<tr>
			<td>Abonos</td>
			<td> {{ $pagos_ventas['efectivo'] }} </td> <!-- al credito -->
			<td> {{ $pagos_ventas['credito'] }} </td> <!-- al credito -->
			<td> {{ $pagos_ventas['cheque']  }} </td> <!-- con cheque -->
			<td> {{ $pagos_ventas['tarjeta'] }} </td> <!-- con tarjeta -->
			<td> {{ $pagos_ventas['deposito']}} </td> <!-- con deposito -->
			<td> {{ $pagos_ventas['total']   }} </td> <!-- total -->
		</tr>
		
		<tr>
			<td>Soporte</td>
			<td> {{ $soporte['efectivo'] }} </td> <!-- al credito -->
			<td> {{ $soporte['credito'] }} </td> <!-- al credito -->
			<td> {{ $soporte['cheque']  }} </td> <!-- con cheque -->
			<td> {{ $soporte['tarjeta'] }} </td> <!-- con tarjeta -->
			<td> {{ $soporte['deposito']}} </td> <!-- con deposito -->
			<td> {{ $soporte['total']   }} </td> <!-- total -->
		</tr>
		
		<tr>
			<td>Adelantos</td>
			<td> {{ $adelantos['efectivo'] }} </td> <!-- al credito -->
			<td> {{ $adelantos['credito'] }} </td> <!-- al credito -->
			<td> {{ $adelantos['cheque']  }} </td> <!-- con cheque -->
			<td> {{ $adelantos['tarjeta'] }} </td> <!-- con tarjeta -->
			<td> {{ $adelantos['deposito']}} </td> <!-- con deposito -->
			<td> {{ $adelantos['total']   }} </td> <!-- total -->
		</tr>

		<tr>
			<td>Ingresos</td>
			<td> {{ $ingresos['efectivo'] }} </td> <!-- al credito -->
			<td> {{ $ingresos['credito'] }} </td> <!-- al credito -->
			<td> {{ $ingresos['cheque']  }} </td> <!-- con cheque -->
			<td> {{ $ingresos['tarjeta'] }} </td> <!-- con tarjeta -->
			<td> {{ $ingresos['deposito']}} </td> <!-- con deposito -->
			<td> {{ $ingresos['total']   }} </td> <!-- total -->
		</tr>

		<tr>
			<td>Gastos</td>
			<td>({{ ($gastos['efectivo'] == 0) ?  '0.00':$gastos['efectivo']}})</td> <!--  en efectivo -->
			<td> {{ $gastos['credito'] }} </td> <!-- al credito -->
			<td> {{ $gastos['cheque']  }} </td> <!-- con cheque -->
			<td> {{ $gastos['tarjeta'] }} </td> <!-- con tarjeta -->
			<td> {{ $gastos['deposito']}} </td> <!-- con deposito -->
			<td> {{ $gastos['total']   }} </td> <!-- total -->
		</tr>
		
		<tr>
			<td>Egresos</td>
			<td>({{ ($egresos['efectivo'] == 0) ?  '0.00':$egresos['efectivo']}})</td> <!--  en efectivo -->
			<td> {{ $egresos['credito'] }} </td> <!-- al credito -->
			<td> {{ $egresos['cheque']  }} </td> <!-- con cheque -->
			<td> {{ $egresos['tarjeta'] }} </td> <!-- con tarjeta -->
			<td> {{ $egresos['deposito']}} </td> <!-- con deposito -->
			<td> {{ $egresos['total']   }} </td> <!-- total -->
		</tr>
		
		<tr>
			<td>Pagos Compras</td>
			<td> ({{ ($pagos_compras['efectivo'] == 0) ?  '0.00':$pagos_compras['efectivo']}}) </td> <!--en efectivo -->
			<td> {{ $pagos_compras['credito'] }} </td> <!-- al credito -->
			<td> {{ $pagos_compras['cheque']  }} </td> <!-- con cheque -->
			<td> {{ $pagos_compras['tarjeta'] }} </td> <!-- con tarjeta -->
			<td> {{ $pagos_compras['deposito']}} </td> <!-- con deposito -->
			<td> {{ $pagos_compras['total']   }} </td> <!-- total -->
		</tr>

		<tr>
			<td>Abonos Compras</td>
			<td> ({{ ($abonos_compras['efectivo'] == 0) ?  '0.00':$abonos_compras['efectivo']}}) </td> <!--en efectivo -->
			<td> {{ $abonos_compras['credito'] }} </td> <!--al credito -->
			<td> {{ $abonos_compras['cheque']  }} </td> <!--con cheque -->
			<td> {{ $abonos_compras['tarjeta'] }} </td> <!--con tarjeta -->
			<td> {{ $abonos_compras['deposito']}} </td> <!--con deposito -->
			<td> {{ $abonos_compras['total']   }} </td> <!-- total-->
		</tr>

		<tr>
			<td>Efectivo esperado en caja</td>
			<td>
			<?php 
				$caja_negativos = $abonos_compras['efectivo'] + $pagos_compras['efectivo'] + $egresos['efectivo'] + $gastos['efectivo'];

				$caja_positivos = $ingresos['efectivo'] + $adelantos['efectivo'] + $soporte['efectivo'];

				$caja = $caja_positivos - $caja_negativos ;

				echo ($caja < 0) ? '('.$caja.')':$caja;
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
</style>
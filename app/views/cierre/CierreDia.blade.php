	<table width="100%" class="table table-responsive table-theme">

		<thead class="cierre_head ">

			<tr>
				<th width="30%" style="text-align:center; font-style: normal;" >
					<i style="cursor:pointer; font-style: normal;">
						Descripcion
					</i>
				</th>
				<th width="12%" style="text-align:center; font-style: normal;">
					<i style="cursor:pointer; font-style: normal;" onclick="cierre_fecha_enviar='{{$fecha}}'; cierre_metodo_pago_id = 1; VentasPorMetodoDePago(1 , null);">
						Efectivo
					</i>
				</th>
				<th width="12%" style="text-align:center">
					<i style="cursor:pointer; font-style: normal;" onclick="cierre_fecha_enviar='{{$fecha}}'; cierre_metodo_pago_id = 2; VentasPorMetodoDePago(1 , null);">
						Credito
					</i>
				</th>

				<th width="12%" style="text-align:center">
					<i style="cursor:pointer; font-style: normal;" onclick="cierre_fecha_enviar='{{$fecha}}'; cierre_metodo_pago_id = 3; VentasPorMetodoDePago(1 , null);">
						Cheque
					</i>
				</th>
				<th width="12%" style="text-align:center">
					<i style="cursor:pointer; font-style: normal;" onclick="cierre_fecha_enviar='{{$fecha}}'; cierre_metodo_pago_id = 4; VentasPorMetodoDePago(1 , null);">
						Tarjeta
					</i>
				</th>
				<th width="12%" style="text-align:center">
					<i style="cursor:pointer; font-style: normal;" onclick="cierre_fecha_enviar='{{$fecha}}'; cierre_metodo_pago_id = 5; VentasPorMetodoDePago(1 , null);">
						Deposito
					</i>
				</th>
				<th width="12%" style="text-align:center">
					<i style="cursor:pointer; font-style: normal;" >
						Totales
					</i>
				</th>
			</tr>
		</thead>

		<tbody class="table-hover cierre_body">
			
			<tr class="">
				<td>Ventas</td>
				<td class="right"> {{ f_num::get($data['pagos_ventas']['efectivo']) }} </td> 
				<td class="right"> {{ f_num::get($data['pagos_ventas']['credito']) }} </td> 
				<td class="right"> {{ f_num::get($data['pagos_ventas']['cheque']) }} </td> 
				<td class="right"> {{ f_num::get($data['pagos_ventas']['tarjeta']) }} </td> 
				<td class="right"> {{ f_num::get($data['pagos_ventas']['deposito'])}} </td> 
				<td class="right"> {{ f_num::get($data['pagos_ventas']['total']) }} </td> 
			</tr>

			<tr>
				<td>Abonos</td>
				<td class="right"> {{ f_num::get($data['abonos_ventas']['efectivo'])}} </td> 
				<td class="right"> {{ f_num::get($data['abonos_ventas']['credito'])}} </td> 
				<td class="right"> {{ f_num::get($data['abonos_ventas']['cheque'])}} </td> 
				<td class="right"> {{ f_num::get($data['abonos_ventas']['tarjeta'])}} </td> 
				<td class="right"> {{ f_num::get($data['abonos_ventas']['deposito'])}} </td> 
				<td class="right"> {{ f_num::get($data['abonos_ventas']['total'])  }} </td> 
			</tr>

			<tr>
				<td>Soporte</td>
				<td class="right"> {{ f_num::get($data['soporte']['efectivo'])}} </td> 
				<td class="right"> {{ f_num::get($data['soporte']['credito'] )}} </td> 
				<td class="right"> {{ f_num::get($data['soporte']['cheque']  )}} </td> 
				<td class="right"> {{ f_num::get($data['soporte']['tarjeta'] )}} </td> 
				<td class="right"> {{ f_num::get($data['soporte']['deposito'])}} </td> 
				<td class="right"> {{ f_num::get($data['soporte']['total'])  }} </td> 
			</tr>

			<tr>
				<td>Adelantos</td>
				<td class="right"> {{ f_num::get($data['adelantos']['efectivo'])}} </td> 
				<td class="right"> {{ f_num::get($data['adelantos']['credito'] )}} </td> 
				<td class="right"> {{ f_num::get($data['adelantos']['cheque']  )}} </td> 
				<td class="right"> {{ f_num::get($data['adelantos']['tarjeta'] )}} </td> 
				<td class="right"> {{ f_num::get($data['adelantos']['deposito'])}} </td> 
				<td class="right"> {{ f_num::get($data['adelantos']['total'])   }} </td> 
			</tr>

			<tr>
				<td>Ingresos</td>
				<td class="right"> {{ f_num::get($data['ingresos']['efectivo'])}} </td> 
				<td class="right"> {{ f_num::get($data['ingresos']['credito'] )}} </td> 
				<td class="right"> {{ f_num::get($data['ingresos']['cheque']  )}} </td> 
				<td class="right"> {{ f_num::get($data['ingresos']['tarjeta'] )}} </td> 
				<td class="right"> {{ f_num::get($data['ingresos']['deposito'])}} </td> 
				<td class="right"> {{ f_num::get($data['ingresos']['total'])   }} </td> 
			</tr>

			<tr>
				<td>Gastos</td>
				<td class="right">({{  f_num::get(($data['gastos']['efectivo'] == 0) ?  '0.00':$data['gastos']['efectivo'])}})</td> 
				<td class="right"> {{  f_num::get($data['gastos']['credito'] )}} </td> 
				<td class="right"> {{  f_num::get($data['gastos']['cheque']  )}} </td> 
				<td class="right"> {{  f_num::get($data['gastos']['tarjeta'] )}} </td> 
				<td class="right"> {{  f_num::get($data['gastos']['deposito'])}} </td> 
				<td class="right"> {{  f_num::get($data['gastos']['total'])  }} </td> 
			</tr>

			<tr>
				<td>Egresos</td>
				<td class="right">({{  f_num::get(($data['egresos']['efectivo'] == 0) ?  '0.00':$data['egresos']['efectivo'])}})</td> 
				<td class="right"> {{  f_num::get($data['egresos']['credito'] )}} </td> 
				<td class="right"> {{  f_num::get($data['egresos']['cheque']  )}} </td> 
				<td class="right"> {{  f_num::get($data['egresos']['tarjeta'] )}} </td> 
				<td class="right"> {{  f_num::get($data['egresos']['deposito'])}} </td> 
				<td class="right"> {{ f_num::get($data['egresos']['total'])   }} </td> 
			</tr>

			<tr>
				<td>Pagos Compras</td>
				<td class="right"> ({{  f_num::get(($data['pagos_compras']['efectivo'] == 0) ?  '0.00':$data['pagos_compras']['efectivo'])}}) </td>
				<td class="right"> {{  f_num::get($data['pagos_compras']['credito'] )}} </td> 
				<td class="right"> {{  f_num::get($data['pagos_compras']['cheque']  )}} </td> 
				<td class="right"> {{  f_num::get($data['pagos_compras']['tarjeta'] )}} </td> 
				<td class="right"> {{  f_num::get($data['pagos_compras']['deposito'])}} </td> 
				<td class="right"> {{ f_num::get($data['pagos_compras']['total'])   }} </td> 
			</tr>

			<tr>
				<td>Abonos Compras</td>
				<td class="right"> ({{  f_num::get(($data['abonos_compras']['efectivo'] == 0) ?  '0.00':$data['abonos_compras']['efectivo'])}}) </td> 
				<td class="right"> {{  f_num::get($data['abonos_compras']['credito'] )}} </td> 
				<td class="right"> {{  f_num::get($data['abonos_compras']['cheque']  )}} </td> 
				<td class="right"> {{  f_num::get($data['abonos_compras']['tarjeta'] )}} </td> 
				<td class="right"> {{  f_num::get($data['abonos_compras']['deposito'])}} </td> 
				<td class="right"> {{ f_num::get($data['abonos_compras']['total'])  }} </td> 
			</tr>
		</tbody>
		<tfoot class="cierre_footer">
			<tr>
				<td>Efectivo esperado en caja</td>
				<td class="right" style="padding-right: 20px !important;"> 
					<?php 
					$caja_negativos = $data['abonos_compras']['efectivo'] + $data['pagos_compras']['efectivo'] + $data['egresos']['efectivo'] + $data['gastos']['efectivo'];

					$caja_positivos = $data['ingresos']['efectivo'] + $data['adelantos']['efectivo'] + $data['soporte']['efectivo'] + $data['pagos_ventas']['efectivo'] + $data['abonos_ventas']['efectivo'];

					$caja =  $caja_positivos - $caja_negativos;
					$total_caja = f_num::get($caja); 

					echo $total_caja;
					?>
				</td> 
				<td colspan="3"></td> 
				<td colspan="2" align="right">
					<a href="javascript:void(0)">
						<i  class="fa fa-file-excel-o fa-2" style="font-size: 16px !important; padding-left:10px" onclick="ExportarCierreDelDia('xls','{{$fecha}}')"> </i>
					</a>
					<a href="javascript:void(0)">
						<i class="fa fa-file-pdf-o fa-2" style="font-size: 16px !important; padding-left:10px" onclick="ExportarCierreDelDia('pdf','{{$fecha}}')"> </i>
					</a>
					<a href="javascript:void(0)">
						<i class="fa fa-print fa-2" style="font-size: 18px !important; padding-left:10px;  padding-right: 12px;" onclick="imprimir_cierre_por_fecha('{{$fecha}}')"> </i>
					</a>
				</td> 
			</tr>
		</tfoot>  

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
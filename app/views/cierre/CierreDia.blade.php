<div class="panel dt-panel-cierre rounded shadow">
    <div class="panel-heading-cierre bg-theme">
        <div class="pull-left"><span>Movimientos del Dia</span></div>
        <div class="pull-right">
        		<i  class="fa fa-file-excel-o fa-2" onclick="ExportarCierreDelDia('xls','{{$fecha}}')"> </i>
        		<i class="fa fa-file-pdf-o fa-2" onclick="ExportarCierreDelDia('pdf','{{$fecha}}')"> </i>
        		<i class="fa fa-print fa-2"  onclick="imprimir_cierre_por_fecha('{{$fecha}}')"> </i>
        		<i onclick="$('.dt-container-cierre').hide();" class="fa fa-times"></i>
         </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body-cierre no-padding" id="table ">
		<table width="100%" id="table table-responsive">
			<thead class="cierre_head">
				<tr>
					<th width="30%" style="text-align:center"> Descripcion </th>
					<th width="12%" style="text-align:center"> Efectivo </th>
					<th width="12%" style="text-align:center"> Credito</th>
					<th width="12%" style="text-align:center"> Cheque</th>
					<th width="12%" style="text-align:center"> Tarjeta</th>
					<th width="12%" style="text-align:center"> Deposito</th>
					<th width="12%" style="text-align:center"> Totales</th>
				</tr>
			</thead>
			<tbody class="table-hover cierre_body">
				<tr class="">
					<td>Ventas</td>
					<td class="right hover" onclick="asignarInfoEnviar('Ventas',1);"> 
						{{ f_num::get($data['pagos_ventas']['efectivo']) }} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('Ventas',2);">
						{{ f_num::get($data['pagos_ventas']['credito']) }} </td> 
					<td class="right hover" onclick="asignarInfoEnviar('Ventas',3);">
					 	{{ f_num::get($data['pagos_ventas']['cheque']) }} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('Ventas',4);">
					 	{{ f_num::get($data['pagos_ventas']['tarjeta']) }} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('Ventas',5);">
					 	{{ f_num::get($data['pagos_ventas']['deposito'])}} </td> 
					<td class="right      "> {{ f_num::get($data['pagos_ventas']['total']) }} </td> 
				</tr>
				<tr>
					<td>Abonos</td>
					<td class="right hover" onclick="asignarInfoEnviar('AbonosVentas',1);"> 
						{{ f_num::get($data['abonos_ventas']['efectivo'])}} 
					</td> 
					<td class="right"> 		 {{ f_num::get($data['abonos_ventas']['credito'])}} </td> 
					<td class="right hover" onclick="asignarInfoEnviar('AbonosVentas',3);">
						{{ f_num::get($data['abonos_ventas']['cheque'])}} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('AbonosVentas',4);" > 
						{{ f_num::get($data['abonos_ventas']['tarjeta'])}} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('AbonosVentas',5);"> 
						{{ f_num::get($data['abonos_ventas']['deposito'])}} 
					</td> 
					<td class="right"> 		 {{ f_num::get($data['abonos_ventas']['total'])  }} </td> 
				</tr>
				<tr>
					<td>Soporte</td>
					<td class="right hover" onclick="asignarInfoEnviar('Soporte',1);">
					    {{ f_num::get($data['soporte']['efectivo'])}} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('Soporte',2);">
					    {{ f_num::get($data['soporte']['credito'] )}} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('Soporte',3);">
					    {{ f_num::get($data['soporte']['cheque']  )}} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('Soporte',4);">
					    {{ f_num::get($data['soporte']['tarjeta'] )}} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('Soporte',5);">
					    {{ f_num::get($data['soporte']['deposito'])}} 
					</td> 
					<td class="right"> 		 {{ f_num::get($data['soporte']['total'])  }} </td> 
				</tr>
				<tr>
					<td>Adelantos</td>
					<td class="right hover" onclick="asignarInfoEnviar('Adelantos',1);">
					   {{ f_num::get($data['adelantos']['efectivo'])}} 
					</td> 
					<td class="right      "> 
						{{ f_num::get($data['adelantos']['credito'] )}} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('Adelantos',3);">
					   {{ f_num::get($data['adelantos']['cheque']  )}} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('Adelantos',4);">
					   {{ f_num::get($data['adelantos']['tarjeta'] )}} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('Adelantos',5);">
					   {{ f_num::get($data['adelantos']['deposito'])}} 
					</td> 
					<td class="right      "> {{ f_num::get($data['adelantos']['total'])   }} </td> 
				</tr>
				<tr>
					<td>Ingresos</td>
					<td class="right hover" onclick="asignarInfoEnviar('Ingresos',1);">
					   {{ f_num::get($data['ingresos']['efectivo'])}} 
					</td> 
					<td class="right      "> 
						{{ f_num::get($data['ingresos']['credito'] )}} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('Ingresos',3);">
					   {{ f_num::get($data['ingresos']['cheque']  )}} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('Ingresos',4);">
					   {{ f_num::get($data['ingresos']['tarjeta'] )}} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('Ingresos',5);">
					   {{ f_num::get($data['ingresos']['deposito'])}} 
					</td> 
					<td class="right      "> {{ f_num::get($data['ingresos']['total'])   }} </td> 
				</tr>
				<tr>
					<td>Gastos</td>
					<td class="right hover" onclick="asignarInfoEnviar('Gastos',1);">
						({{  f_num::get(($data['gastos']['efectivo'] == 0) ?  '0.00':$data['gastos']['efectivo'])}})
					</td> 
					<td class="right      "> 
						{{  f_num::get($data['gastos']['credito'] )}} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('Gastos',3);">
						 {{  f_num::get($data['gastos']['cheque']  )}} 
					 </td> 
					<td class="right hover" onclick="asignarInfoEnviar('Gastos',4);">
						 {{  f_num::get($data['gastos']['tarjeta'] )}} 
					 </td> 
					<td class="right hover" onclick="asignarInfoEnviar('Gastos',5);">
						 {{  f_num::get($data['gastos']['deposito'])}} 
					 </td> 
					<td class="right      "> {{  f_num::get($data['gastos']['total'])  }} </td> 
				</tr>
				<tr>
					<td>Egresos</td>
					<td class="right hover" onclick="asignarInfoEnviar('Egresos',1);">
						({{  f_num::get(($data['egresos']['efectivo'] == 0) ?  '0.00':$data['egresos']['efectivo'])}})
					</td> 
					<td class="right      "> 
						{{  f_num::get($data['egresos']['credito'] )}} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('Egresos',3);">
						{{  f_num::get($data['egresos']['cheque']  )}} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('Egresos',4);">
						{{  f_num::get($data['egresos']['tarjeta'] )}} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('Egresos',5);">
						{{  f_num::get($data['egresos']['deposito'])}} 
					</td> 
					<td class="right      "> {{ f_num::get($data['egresos']['total'])   }} </td> 
				</tr>
				<tr>
					<td>Pagos Compras</td>
					<td class="right hover" onclick="asignarInfoEnviar('PagosCompras',1);">
					   ({{  f_num::get(($data['pagos_compras']['efectivo'] == 0) ?  '0.00':$data['pagos_compras']['efectivo'])}}) 
					 </td>
					<td class="right hover" onclick="asignarInfoEnviar('PagosCompras',2);">
					   {{  f_num::get($data['pagos_compras']['credito'] )}} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('PagosCompras',3);">
					   {{  f_num::get($data['pagos_compras']['cheque']  )}} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('PagosCompras',4);">
					   {{  f_num::get($data['pagos_compras']['tarjeta'] )}} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('PagosCompras',5);">
					   {{  f_num::get($data['pagos_compras']['deposito'])}} 
					</td> 
					<td class="right      "> {{ f_num::get($data['pagos_compras']['total'])   }} </td> 
				</tr>
				<tr>
					<td>Abonos Compras</td>
					<td class="right hover" onclick="asignarInfoEnviar('AbonosCompras',1);">
						({{  f_num::get(($data['abonos_compras']['efectivo'] == 0) ?  '0.00':$data['abonos_compras']['efectivo'])}}) 
					</td> 
					<td class="right      "> 
						{{  f_num::get($data['abonos_compras']['credito'] )}} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('AbonosCompras',3);">
						{{  f_num::get($data['abonos_compras']['cheque']  )}} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('AbonosCompras',4);">
						{{  f_num::get($data['abonos_compras']['tarjeta'] )}} 
					</td> 
					<td class="right hover" onclick="asignarInfoEnviar('AbonosCompras',5);">
						{{  f_num::get($data['abonos_compras']['deposito'])}} 
					</td> 
					<td class="right      "> {{ f_num::get($data['abonos_compras']['total'])  }} </td> 
				</tr>
			</tbody>
			<tfoot class="cierre_footer">
				<tr>
					<td>Efectivo esperado en caja</td>
					<td class="right" style="padding-right: 10px !important;"> 
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
					</td> 
				</tr>
			</tfoot>  
		</table>
    </div>
</div>

<script>
	cierre_fecha_enviar='{{$fecha}}'; 
</script>


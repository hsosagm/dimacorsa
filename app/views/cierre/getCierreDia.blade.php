<div class="panel dt-panel-cierre rounded shadow">
    <div class="panel-heading-cierre bg-theme">
        <div class="pull-left cierre-titulos">
			<strong >{{ strtoupper(@$titulo['fecha']) }}</strong>
        </div>
        <div class="pull-right">
        		<i  class="fa fa-file-excel-o fa-2" onclick="ExportarCierreDelDia('xls','{{$fecha}}')"> </i>
        		<i class="fa fa-file-pdf-o fa-2"onclick="ExportarCierreDelDia('pdf','{{$fecha}}')"> </i>
        		<i class="fa fa-print fa-2" onclick="imprimir_cierre_por_fecha('{{$fecha}}')"> </i>
        		@if(!Input::has('grafica'))
        			<i onclick="click: $('.dt-container-cierre').hide();" class="fa fa-times"></i>
                @endif
         </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body-cierre no-padding" id="table " style="border-bottom: double;">
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
			<tbody class="table-hover cierre_body" style="border-bottom: double;">
				<tr class="">
					<td>Ventas</td>
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Ventas',1);"> 
						{{ f_num::get($data['pagos_ventas']['efectivo']) }} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Ventas',2);">
						{{ f_num::get($data['pagos_ventas']['credito']) }} </td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Ventas',3);">
					 	{{ f_num::get($data['pagos_ventas']['cheque']) }} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Ventas',4);">
					 	{{ f_num::get($data['pagos_ventas']['tarjeta']) }} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Ventas',5);">
					 	{{ f_num::get($data['pagos_ventas']['deposito'])}} </td> 
					<td class="right      "> {{ f_num::get($data['pagos_ventas']['total']) }} </td> 
				</tr>
				<tr>
					<td>Abonos</td>
					<td class="right hover" v-on="click: getAsignarInfoEnviar('AbonosVentas',1);"> 
						{{ f_num::get($data['abonos_ventas']['efectivo'])}} 
					</td> 
					<td class="right"> 		 {{ f_num::get($data['abonos_ventas']['credito'])}} </td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('AbonosVentas',3);">
						{{ f_num::get($data['abonos_ventas']['cheque'])}} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('AbonosVentas',4);" > 
						{{ f_num::get($data['abonos_ventas']['tarjeta'])}} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('AbonosVentas',5);"> 
						{{ f_num::get($data['abonos_ventas']['deposito'])}} 
					</td> 
					<td class="right"> 		 {{ f_num::get($data['abonos_ventas']['total'])  }} </td> 
				</tr>
				<tr>
					<td>Soporte</td>
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Soporte',1);">
					    {{ f_num::get($data['soporte']['efectivo'])}} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Soporte',2);">
					    {{ f_num::get($data['soporte']['credito'] )}} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Soporte',3);">
					    {{ f_num::get($data['soporte']['cheque']  )}} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Soporte',4);">
					    {{ f_num::get($data['soporte']['tarjeta'] )}} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Soporte',5);">
					    {{ f_num::get($data['soporte']['deposito'])}} 
					</td> 
					<td class="right"> 		 {{ f_num::get($data['soporte']['total'])  }} </td> 
				</tr>
				<tr>
					<td>Adelantos</td>
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Adelantos',1);">
					   {{ f_num::get($data['adelantos']['efectivo'])}} 
					</td> 
					<td class="right      "> 
						{{ f_num::get($data['adelantos']['credito'] )}} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Adelantos',3);">
					   {{ f_num::get($data['adelantos']['cheque']  )}} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Adelantos',4);">
					   {{ f_num::get($data['adelantos']['tarjeta'] )}} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Adelantos',5);">
					   {{ f_num::get($data['adelantos']['deposito'])}} 
					</td> 
					<td class="right      "> {{ f_num::get($data['adelantos']['total'])   }} </td> 
				</tr>
				<tr>
					<td>Ingresos</td>
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Ingresos',1);">
					   {{ f_num::get($data['ingresos']['efectivo'])}} 
					</td> 
					<td class="right      "> 
						{{ f_num::get($data['ingresos']['credito'] )}} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Ingresos',3);">
					   {{ f_num::get($data['ingresos']['cheque']  )}} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Ingresos',4);">
					   {{ f_num::get($data['ingresos']['tarjeta'] )}} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Ingresos',5);">
					   {{ f_num::get($data['ingresos']['deposito'])}} 
					</td> 
					<td class="right      "> {{ f_num::get($data['ingresos']['total'])   }} </td> 
				</tr>
				<tr>
					<td>Gastos</td>
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Gastos',1);">
						({{  f_num::get(($data['gastos']['efectivo'] == 0) ?  '0.00':$data['gastos']['efectivo'])}})
					</td> 
					<td class="right      "> 
						{{  f_num::get($data['gastos']['credito'] )}} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Gastos',3);">
						 {{  f_num::get($data['gastos']['cheque']  )}} 
					 </td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Gastos',4);">
						 {{  f_num::get($data['gastos']['tarjeta'] )}} 
					 </td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Gastos',5);">
						 {{  f_num::get($data['gastos']['deposito'])}} 
					 </td> 
					<td class="right      "> {{  f_num::get($data['gastos']['total'])  }} </td> 
				</tr>
				<tr>
					<td>Egresos</td>
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Egresos',1);">
						({{  f_num::get(($data['egresos']['efectivo'] == 0) ?  '0.00':$data['egresos']['efectivo'])}})
					</td> 
					<td class="right      "> 
						{{  f_num::get($data['egresos']['credito'] )}} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Egresos',3);">
						{{  f_num::get($data['egresos']['cheque']  )}} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Egresos',4);">
						{{  f_num::get($data['egresos']['tarjeta'] )}} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('Egresos',5);">
						{{  f_num::get($data['egresos']['deposito'])}} 
					</td> 
					<td class="right      "> {{ f_num::get($data['egresos']['total'])   }} </td> 
				</tr>
				<tr>
					<td>Pagos Compras</td>
					<td class="right hover" v-on="click: getAsignarInfoEnviar('PagosCompras',1);">
					   ({{  f_num::get(($data['pagos_compras']['efectivo'] == 0) ?  '0.00':$data['pagos_compras']['efectivo'])}}) 
					 </td>
					<td class="right hover" v-on="click: getAsignarInfoEnviar('PagosCompras',2);">
					   {{  f_num::get($data['pagos_compras']['credito'] )}} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('PagosCompras',3);">
					   {{  f_num::get($data['pagos_compras']['cheque']  )}} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('PagosCompras',4);">
					   {{  f_num::get($data['pagos_compras']['tarjeta'] )}} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('PagosCompras',5);">
					   {{  f_num::get($data['pagos_compras']['deposito'])}} 
					</td> 
					<td class="right      "> {{ f_num::get($data['pagos_compras']['total'])   }} </td> 
				</tr>
				<tr>
					<td>Abonos Compras</td>
					<td class="right hover" v-on="click: getAsignarInfoEnviar('AbonosCompras',1);">
						({{  f_num::get(($data['abonos_compras']['efectivo'] == 0) ?  '0.00':$data['abonos_compras']['efectivo'])}}) 
					</td> 
					<td class="right      "> 
						{{  f_num::get($data['abonos_compras']['credito'] )}} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('AbonosCompras',3);">
						{{  f_num::get($data['abonos_compras']['cheque']  )}} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('AbonosCompras',4);">
						{{  f_num::get($data['abonos_compras']['tarjeta'] )}} 
					</td> 
					<td class="right hover" v-on="click: getAsignarInfoEnviar('AbonosCompras',5);">
						{{  f_num::get($data['abonos_compras']['deposito'])}} 
					</td> 
					<td class="right      "> {{ f_num::get($data['abonos_compras']['total'])  }} </td> 
				</tr>
			</tbody>
			<tfoot class="cierre_footer">
				<tr class="noFontBold">
					<th style="text-align: left;">Efectivo esperado en caja</th>
					<th class="right" style="padding-right: 10px !important;"> 
						<?php 
							$caja_negativos = $data['abonos_compras']['efectivo'] + $data['pagos_compras']['efectivo'] + $data['egresos']['efectivo'] + $data['gastos']['efectivo'];

							$caja_positivos = $data['ingresos']['efectivo'] + $data['adelantos']['efectivo'] + $data['soporte']['efectivo'] + $data['pagos_ventas']['efectivo'] + $data['abonos_ventas']['efectivo'];

							$caja =  $caja_positivos - $caja_negativos;
							$total_caja = f_num::get($caja); 
							echo $total_caja;
						?>
					</th> 
					<th></th> 
					<th class="right" style="padding-right: 10px !important;">
						<?php 
							$total_cheque = $data['pagos_ventas']['cheque'] + $data['abonos_ventas']['cheque'] + $data['soporte']['cheque'] + $data['ingresos']['cheque'] + $data['adelantos']['cheque'];
							echo f_num::get($total_cheque);
						 ?>
					</th> 
					<th class="right" style="padding-right: 10px !important;">
						<?php 
							$total_tarjeta = $data['pagos_ventas']['tarjeta'] + $data['abonos_ventas']['tarjeta'] + $data['soporte']['tarjeta'] + $data['ingresos']['tarjeta'] + $data['adelantos']['tarjeta'];
							echo f_num::get($total_tarjeta);
						 ?>
					</th> 
					<th class="right" style="padding-right: 10px !important;">
						<?php 
							$total_deposito = $data['pagos_ventas']['deposito'] + $data['abonos_ventas']['deposito'] + $data['soporte']['deposito'] + $data['ingresos']['deposito'] + $data['adelantos']['deposito'];
							echo f_num::get($total_deposito);
						 ?>
					</th> 
					<th></th> 
				</tr>
				@if(@$corte_realizado != null)
					<tr class="noFontBold">
						<th style="text-align: left;">Monto real</th>
						<th class="right" style="padding-right: 10px !important;">{{f_num::get(@$corte_realizado->efectivo)}}</th>
						<th class="right" style="padding-right: 10px !important;"></th>
						<th class="right" style="padding-right: 10px !important;">{{f_num::get(@$corte_realizado->cheque)}}</th>
						<th class="right" style="padding-right: 10px !important;">{{f_num::get(@$corte_realizado->tarjeta)}}</th>
						<th class="right" style="padding-right: 10px !important;">{{f_num::get(@$corte_realizado->deposito)}}</th>
						<th></th>
					</tr>
					<tr class="noFontBold">
						<th style="text-align: left;">Diferencia</th>
						<th class="right" style="padding-right: 10px !important;">
							{{ f_num::get(@$corte_realizado->efectivo - $caja) }}
						</th>
						<th class="right" style="padding-right: 10px !important;">
							
						</th>
						<th class="right" style="padding-right: 10px !important;">
							{{ f_num::get(@$corte_realizado->cheque - $total_cheque) }}
						</th>
						<th class="right" style="padding-right: 10px !important;">
							{{ f_num::get(@$corte_realizado->tarjeta - $total_tarjeta) }}
						</th>
						<th class="right" style="padding-right: 10px !important;">
							{{ f_num::get(@$corte_realizado->deposito - $total_deposito) }}
						</th>
						<th></th>
					</tr>
					<tr style="border-top:solid 1px #000000">
						<th style="text-align: left;">Monto a depositar</th>
						<th class="right" style="padding-right: 10px !important;">{{f_num::get(@$corte_realizado->efectivo)}}</th>
						<th class="right" style="padding-right: 10px !important;"></th>
						<th class="right" style="padding-right: 10px !important;">{{f_num::get(@$corte_realizado->cheque)}}</th>
						<th class="right" style="padding-right: 10px !important;">{{f_num::get(@$corte_realizado->tarjeta)}}</th>
						<th class="right" style="padding-right: 10px !important;">{{f_num::get(@$corte_realizado->deposito)}}</th>
						<th class="right" style="padding-right: 10px !important;"> 
							
						</th>
					</tr>
				@endif
			</tfoot>  
		</table>
    </div>
    <div class="row">
		<div class="col-md-11">
			@if(@$corte_realizado != null)
				<div align="center">
					*** El corte fue realizado por {{ @$corte_realizado->user->nombre.' '.@$corte_realizado->user->apellido }} a las {{ @$corte_realizado->created_at }} horas ***
				</div>
			@endif
		</div>
		<div class="col-md-1" align="right" >
			<i class="fa fa-chevron-down btn-link theme-c" v-on="click: $('.detalle_cierre_footer').slideToggle()"> </i> 
			&nbsp;&nbsp;
		</div>
    </div>
    
	
    <div class="detalle_cierre_footer" style="display:{{(Input::has('imprimir'))?'':'none';}}"> 
       <!--  inicio de ventas al credito -->
        @if(count($dataDetalle['credito']['pagosVentas']))
		<div style="border-bottom:solid 1px #000000">
			<h5> <strong>&nbsp;&nbsp;&nbsp;Ventas al credito</strong> </h5>
			<table width="100%" class=""> 
				<thead>
					<tr class="bg-theme" style="opacity: 0.6;">
						<th width="30%">&nbsp;&nbsp;&nbsp;Usuario</th>
						<th width="40%" style="text-align: center;">Cliente</th>
						<th width="15%" style="text-align: center;">Total</th>
						<th width="15%" style="text-align: center;">Saldo</th>
					</tr>
				</thead>
				<tbody>
					@foreach($dataDetalle['credito']['pagosVentas'] as $vc)
						<tr>
							<td> {{ $vc->user->nombre.' '.$vc->user->apellido }} </td>
							<td> {{ $vc->cliente->nombre.' '.$vc->cliente->apellido }} </td>
							<td class="right"> {{ f_num::get($vc->total) }} </td>
							<td class="right"> {{ f_num::get($vc->saldo) }} </td>
						</tr>
					@endforeach					
				</tbody>
			</table>
		</div>
		@endif
		<!-- fin de ventas al credito-->	

		<!-- inicio de Depositos -->
			@include('cierre.consultaDetalleOperaciones', array('metodoDePago'=>'deposito'))
		<!-- fin de Depositos -->

		<!-- inicio de Cheques -->
			@include('cierre.consultaDetalleOperaciones', array('metodoDePago'=>'cheque'))
		<!-- fin de Cheques -->

		<!--  inicio de detalle de gastos-->
		@if(count($dataDetalle['todos']['detalleGastos']))
		<div style="border-bottom:solid 1px #000000">
		<h5> <strong>&nbsp;&nbsp;&nbsp;Detalle de Gastos</strong> </h5>
			<table width="100%" class=""> 
				<thead>
					<tr class="bg-theme" style="opacity: 0.6;">
						<th width="30%">&nbsp;&nbsp;&nbsp;Usuario</th>
						<th width="40%" style="text-align: center;">Descripcion</th>
						<th width="15%"style="text-align: center;">Monto</th>
						<th width="15%" style="text-align: center;">Metodo Pago</th>
					</tr>
				</thead>
				<tbody>
					@foreach($dataDetalle['todos']['detalleGastos']as $op)
						<tr>
							<td> {{ $op->gasto->user->nombre.' '.$op->gasto->user->apellido }} </td>
							<td> {{ $op->descripcion }} </td>
							<td class="right"> {{ f_num::get($op->monto) }} </td>
							<td> {{ $op->metodoPago->descripcion }}  </td>
						</tr>								
					@endforeach	
				</tbody>
			</table>
		</div>
		@endif
		<!--  fin de detalle de gastos-->

		<!--  inicio de detalle de egresos-->
		@if(count($dataDetalle['todos']['detalleEgresos']))
		<div style="border-bottom:solid 1px #000000">
		<h5> <strong>&nbsp;&nbsp;&nbsp;Detalle de Egresos</strong> </h5>
			<table width="100%" class=""> 
				<thead>
					<tr class="bg-theme" style="opacity: 0.6;">
						<th width="30%">&nbsp;&nbsp;&nbsp;Usuario</th>
						<th width="40%" style="text-align: center;">Descripcion</th>
						<th width="15%"style="text-align: center;">Monto</th>
						<th width="15%" style="text-align: center;">Metodo Pago</th>
					</tr>
				</thead>
				<tbody>
					@foreach($dataDetalle['todos']['detalleEgresos']as $op)
						<tr>
							<td> {{ $op->egreso->user->nombre.' '.$op->egreso->user->apellido }} </td>
							<td> {{ $op->descripcion }} </td>
							<td class="right"> {{ f_num::get($op->monto) }} </td>
							<td> {{ $op->metodoPago->descripcion }}  </td>
						</tr>								
					@endforeach	
				</tbody>
			</table>
		</div>
		@endif
		<!--  fin de detalle de egresos-->

		<!--  inicio de compras del dia -->
		@if(count($dataDetalle['todos']['detalleCompras']))
		<div style="border-bottom:solid 1px #000000">
			<h5> <strong>&nbsp;&nbsp;&nbsp;Comrpas del Dia</strong> </h5>
			<table width="100%" class=""> 
				<thead>
					<tr class="bg-theme" style="opacity: 0.6;">
						<th width="30%">&nbsp;&nbsp;&nbsp;Usuario</th>
						<th width="40%" style="text-align: center;">Proveedor</th>
						<th width="15%" style="text-align: center;">Total</th>
						<th width="15%" style="text-align: center;">Saldo</th>
					</tr>
				</thead>
				<tbody>
					@foreach($dataDetalle['todos']['detalleCompras'] as $dc)
						<tr>
							<td> {{ $dc->user->nombre.' '.$dc->user->apellido }} </td>
							<td> {{ $dc->proveedor->nombre}} </td>
							<td class="right"> {{ f_num::get($dc->total) }} </td>
							<td class="right"> {{ f_num::get($dc->saldo) }} </td>
						</tr>
					@endforeach					
				</tbody>
			</table>
		</div>
		@endif
		<!--  fin de compras del dia -->

    </div>
</div>

<script>
	cierre_fecha_enviar='{{$fecha}}'; 
</script>

@if(Input::has('imprimir'))
	<style>
		table {
			font-size: 12px;
		}
		.right {
			text-align: right;
		}
		table thead {
			border-bottom: 1px solid black
		}
	</style>
@endif
        
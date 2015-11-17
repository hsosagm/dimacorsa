<?php $fecha = $data['fecha']; ?>
<div class="panel dt-panel-cierre rounded shadow">
	<div class="panel-heading-cierre bg-theme">
		<div class="pull-left"><span>Balance General - {{$data['mes']}}  </span> </div>
		<div class="pull-right">
			<i  class="fa fa-file-excel-o fa-2" onclick="ExportarCierreDelMes('xls','{{$fecha}}')"> </i>
			<i class="fa fa-file-pdf-o fa-2"  onclick="ExportarCierreDelMes('pdf','{{$fecha}}')"> </i>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body-cierre no-padding" id="table">
		<table width="100%" id="table table-responsive">
			<thead class="cierre_head">
				<tr>
					<td width="20%" style="text-align: center;">
						<i style="cursor:pointer; font-style: normal;" v-on="click: getVentasDelMes(this,'{{$fecha}}')" >Ventas</i>
						<i class="fa fa-search btn-link" v-on="click: getVentasDelMes(this,'{{$fecha}}')"></i>
					</td> 
					<td width="20%" style="text-align: center;" >Utilidades</td>
					<td width="20%" style="text-align: center;" >
						<i style="cursor:pointer; font-style: normal;" v-on="click: getSoporteDelMes(this,'{{$fecha}}')">Soporte</i>
						<i class="fa fa-search btn-link" v-on="click: getSoporteDelMes(this,'{{$fecha}}')"></i>
					</td>
					<td width="20%" style="text-align: center;" >
						<i style="cursor:pointer; font-style: normal;" v-on="click: getGastosDelMes(this,'{{$fecha}}')">Gastos</i>
						<i class="fa fa-search btn-link" v-on="click: getGastosDelMes(this,'{{$fecha}}')"></i>
					</td>
					<td width="20%" style="text-align: center;" >Utilidades Netas</td>
				</tr>
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
			</thead>
			<tbody class="table-hover cierre_body cierre_detalle" style="">
				<tr>
					<td colspan="5" style="text-align: center;">
						- Ventas por Usuario -
					</td>
				</tr>
				@foreach(@$ventas_usuarios as $key => $user)
				<tr>
					<td colspan="2" class="fg-theme">
						<i v-on="click: getVentasDelMesPorUsuario(this,{{$user->id}},'{{$fecha}}')" class="fa fa-search" style="cursor:pointer">
							{{ $user->nombre .' '. $user->apellido}}
						</i>
					</td>
					<td style="text-align: right;"> {{ f_num::get($user->total) }} </td>
					<td style="text-align: right;"> {{ f_num::get($user->utilidad) }} </td>
					<td style="text-align: right;">%{{ f_num::get(($user->utilidad * 100 )/str_replace(',', '', $user->total ))}}</td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td colspan="5" class="cierre_totales">
						<div class="row">
							<div class="col-md-3">
								<div class="row">
									<div class="col-md-6">Inversion Actual :</div>
									<div class="col-md-6" style="text-align: right;"> {{ $data['inversion_actual'] }} </div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="row">
									<div class="col-md-7">Cuentas por Cobrar :</div>
									<div class="col-md-5" style="text-align: right;"> {{ $data['ventas_credito'] }} </div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="row">
									<div class="col-md-6">Cuentas por Pagar :</div>
									<div class="col-md-6" style="text-align: right;"> {{ $data['compras_credito'] }} </div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="row">
									<div class="col-md-6">Notas de Credito :</div>
									<div class="col-md-6" style="text-align: right;"> {{ $data['notas_creditos']}} </div>
								</div>
							</div>
						</div>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<style type="text/css">
	.bs-modal .Lightbox{width: 850px;}
	.modal-body { padding: 0px 0px 0px; }
</style>

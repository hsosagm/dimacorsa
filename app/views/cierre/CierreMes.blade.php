<div class="panel dt-panel-cierre rounded shadow">
	<div class="panel-heading-cierre bg-theme">
		<div class="pull-left"><span>Balance General - {{$mes}}</span></div>
		<div class="pull-right">
			<i  class="fa fa-file-excel-o fa-2" onclick=""> </i>
			<i class="fa fa-file-pdf-o fa-2" onclick=""> </i>
			<i class="fa fa-print fa-2"  onclick=""> </i>
			<?php $dt_container = "$('.dt-container').show();"; ?>
			<i onclick="$('.dt-container-cierre').hide(); {{(Input::has('grafica'))? $dt_container:''}}" class="fa fa-times"></i>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body-cierre no-padding" id="table">
		<table width="100%" id="table table-responsive">
			<thead class="cierre_head"> 
				<tr>
					<td width="20%" style="text-align: center;">
						<i style="cursor:pointer; font-style: normal;" onclick="VentasDelMesCierre(this,'{{$fecha}}')">Ventas</i>
						<i class="fa fa-search btn-link" onclick="VentasDelMesCierre(this,'{{$fecha}}')"></i>
					</td>
					<td width="20%" style="text-align: center;" >Utilidades</td>
					<td width="20%" style="text-align: center;" >
						<i style="cursor:pointer; font-style: normal;" onclick="SoporteDelMesCierre(this,'{{$fecha}}')">Soporte</i>
						<i class="fa fa-search btn-link" onclick="SoporteDelMesCierre(this,'{{$fecha}}')"></i>
					</td>
					<td width="20%" style="text-align: center;" >
						<i style="cursor:pointer; font-style: normal;" onclick="GastosDelMesCierre(this,'{{$fecha}}')">Gastos</i>
						<i class="fa fa-search btn-link" onclick="GastosDelMesCierre(this,'{{$fecha}}')"></i>
					</td>
					<td width="20%" style="text-align: center;" >Utilidades Netas</td>
				</tr>
				<tr>
					<td style="text-align: right;"> {{ ($total_ventas	 )}} </td>
					<td style="text-align: right;"> {{ ($total_ganancias )}} (%{{ f_num::get(($total_ganancias*100)/$total_ventas) }})</td>
					<td style="text-align: right;"> {{ ($total_soporte   )}} </td>
					<td style="text-align: right;"> {{ ($total_gastos    )}} (%{{ f_num::get(($total_gastos*100)/$total_ventas) }})</td>
					<td style="text-align: right;"> {{ ($ganancias_netas )}} (%{{ f_num::get(($ganancias_netas*100)/$total_ventas) }})</td>
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
					<td colspan="2">{{ $user->nombre .' '. $user->apellido}}</td>
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
							<div class="col-md-4">
								<div class="row">
									<div class="col-md-6">Inversion Actual :</div>
									<div class="col-md-6" style="text-align: right;"> {{ $inversion_actual }} </div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="row">
									<div class="col-md-6">Cuentas por Cobrar :</div>
									<div class="col-md-6" style="text-align: right;"> {{ $ventas_credito }} </div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="row">
									<div class="col-md-6">Cuentas por Pagar :</div>
									<div class="col-md-6" style="text-align: right;"> {{ $compras_credito }} </div>
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
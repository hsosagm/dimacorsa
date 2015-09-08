<div class="rounded shadow"> 
	<div class="panel_heading">
		<div id="table_length" class="pull-left"></div>
		<div class="DTTT btn-group"></div>
		<div class="pull-right">
			@if($id_pagination == 'pagination_ventas_por_usuario')
				<i class="fa fa-file-excel-o fa-lg" v-on="click: exportarVentasPendientesPorUsuario('xlsx',{{Input::get('user_id')}})"></i>
				<i class="fa fa-file-pdf-o fa-lg" v-on="click: exportarVentasPendientesPorUsuario('pdf',{{Input::get('user_id')}})"></i>
				<i class="fa fa-reply" v-on="click: getVentasPedientesPorUsuario" ></i>
			@else
				<i class="fa fa-file-excel-o fa-lg" v-on="click: exportarEstadoDeCuentaPorCliente('xlsx',{{Input::get('cliente_id')}})"></i>
				<i class="fa fa-file-pdf-o fa-lg" v-on="click: exportarEstadoDeCuentaPorCliente('pdf',{{Input::get('cliente_id')}})"></i>
				<i  v-on="click: getVentasPedientesDePago" class="fa fa-reply"></i>
			@endif

			<i  v-on="click: closeMainContainer" class="fa fa-times"></i>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="no-padding table">
		<table class="DT_table_div" width="100%">
			<tr class="DT_table_div_detail">
				<td align="center">Fecha</td>
				<td align="center">{{ ($id_pagination == 'pagination_ventas_por_usuario')? 'Cliente':'Usuario';}}</td>
				<td align="center">Total</td>
				<td align="center">Saldo</td>
				<td align="center"></td>
			</tr>
			<tbody >
				@foreach($detalle as $key => $dt)
				<tr class="{{($dt->dias >= 30)? 'red':''}}">
					<td width="15%">{{$dt->fecha_ingreso}}</td>
					<td width="30%">{{$dt->usuario}}</td>
					<td width="10%">{{$dt->total }}</td>
					<td width="10%" class="right">{{$dt->saldo}}</td>
					<td width="5%" class="right"> 
						<i class="fa fa-plus-square btn-link theme-c" v-on="click: getVentaConDetalle($event, {{$dt->id}});"></i>
					</td>
				</tr>
				@endforeach
			</tbody>
			<tfoot width="100%">
				<tr>
					<td colspan="9">
						<div style="float:right" class="{{$id_pagination}}"> {{ @$detalle->links() }} </div>

					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>


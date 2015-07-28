<div class="row" style=" line-height: 140%;  font-size: 12px; padding:10px">
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-6">Cliente:</div>
			<div class="col-md-6">{{ $venta->cliente->nombre .' '. $venta->cliente->apellido }}</div>
		</div>
		<div class="row">
			<div class="col-md-6">Direccion:</div>
			<div class="col-md-6">{{ $venta->cliente->direccion }}</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-6">Fecha:</div>
			<div class="col-md-6">{{ $venta->cretaed_at }}</div>
		</div>
		<div class="row">
			<div class="col-md-6">Nit:</div>
			<div class="col-md-6">{{ $venta->cliente->nit }}</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="body-detail">
			<table width="100%">
				<thead >
					<tr>
						<th width="10%">Cantidad</th>
						<th width="75%">Descripcion</th>
						<th width="13%">Precio</th>
						<th width="25%" style="margin-right:5px">Totales</th>
					</tr>
				</thead>
				<tbody style="  height: 275px!important;  line-height: 140%;  font-size: 12px;">
					<?php $total = 0; ?>
					@foreach( $venta->detalle_venta as $dt)
						<tr>
							<td width="10%"> {{ $dt->cantidad }} </td>
							<td width="90%"> {{ $dt->producto->descripcion }} </td>
							<td width="10%" style="text-align:right; padding-right: 20px !important;"> {{ f_num::get($dt->precio) }} </td>
							<td width="10%" style="text-align:right; padding-right: 20px !important;"> {{ f_num::get($dt->precio * $dt->cantidad)}} </td>
						</tr>
						<?php $total = $total + ( $dt->precio * $dt->cantidad ); ?>
					@endforeach
				</tbody>
				<tfoot width="100%">
					<tr style="border: solid 1px black">
						<td colspan="4">
							<div class="row">
								<div class="col-md-8" style="line-height: 140%;  font-size: 12px;" >  Total a cancelar </div>
								<div class="col-md-4" style="text-align:right; padding-right:50px; line-height: 140%;  font-size: 12px;"> 
									{{ f_num::get( $total ) }} 
								</div>
							</div>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
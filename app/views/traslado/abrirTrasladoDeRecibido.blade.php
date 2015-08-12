<div class="row info_head">
	@include('traslado.info_head')
</div>
<div class="master-detail"> 
	<div class="master-detail-body">
		<div class="body-detail">
			@if (count(@$detalle) > 0)
			<table width="100%">
				<thead >
					<tr>
						<th width="10%">Cantidad</th>
						<th width="75%">Descripcion</th>
						<th width="10%">Precio</th>
						<th width="10%">Totales</th>
					</tr>
				</thead>
				<tbody>
					<?php $deuda = 0; ?>
					@foreach($detalle as $q)
					<?php
						$deuda = $deuda + $q->total;        
						$precio = f_num::get($q->precio);
						$total = f_num::get($q->total);
					?>
					<tr>
						<td field="cantidad" cod="{{ $q->id }}" class="edit" width="10%"> {{ $q->cantidad }} </td>          
						<td width="75%"> {{ $q->descripcion }} </td>
						<td field="precio" style="text-align:right;   padding-right: 20px !important;" cod="{{ $q->id }}" class="edit" width="10%"> {{ $precio }} </td>
						<td width="10%" style="text-align:right;   padding-right: 20px !important; "> {{ $total }} </td>
					</tr>
					@endforeach
				</tbody>
				<tfoot width="100%">
					<tr>
						<td>
							<div class="row">
								<div class="col-md-8" >  Total Traslado </div>
								<div class="col-md-4" id="totalventas" class="td_total_text" style="text-align:right; padding-right:50px;" >
									{{ f_num::get($deuda) }} 
								</div>
							</div>
						</td>
					</tr>
				</tfoot>

			</table>

			@endif
		</div>
		<div class="form-footer" >
			<div class="row">
				<div class="col-md-6">
				</div>
				<div class="col-md-6" align="right">
					{{ Form::button('Recibir Traslado!', ['class'=>'btn btn-info theme-button', 'onClick'=>'recibirTraslado(this,'.$id.')']) }}
				</div>
			</div>
		</div>
	</div>
</div>
</div>         

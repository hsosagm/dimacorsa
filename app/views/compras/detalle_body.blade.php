@if(count(@$detalle) > 0 )
	<?php $deuda=0; ?>
	<table width="100%"> 
		<thead>
			<tr>
				<th width="10%">Cantidad</th>
				<th width="70%">Descripcion</th>
				<th width="10%" style="text-align: center;">Precio</th>
				<th width="10%" style="text-align: center;">Totales</th>
				<th width="5%"></th>
			</tr>
		</thead>
		<tbody> 
			@foreach ($detalle as $key => $q)
				<?php $deuda = $deuda + $q->total;   ?>
				<tr>
					<td field="cantidad" cod="{{ $q->id }}" compra_id="Input::get('compra_id')" class="EditPurchaseItemDetails" width="10%">
						{{ $q->cantidad }}
					</td>   
					<td width="70%">
						{{ $q->descripcion }}  
					</td>
					<td align="right" field="precio" cod="{{ $q->id }}" compra_id="Input::get('compra_id')" class="EditPurchaseItemDetails" width="10%">
						{{ f_num::get($q->precio) }}
					</td>
					<td width="10%" align="right"> 
						{{ f_num::get($q->total) }} 
					</td>
					<td width="5%">
						<i id="{{ $q->id }}" href="admin/compras/DeletePurchaseDetailsItem" class="fa fa-trash-o pointer btn-link theme-c" onClick="DeleteDetalle(this);"></i>
					</td>
					<td width="5%" >
		                <i onclick="ingresarSeriesDetalleCompra(this, {{ $q->id }})" class="fa fa-barcode fg-theme"></i>
		            </td>
				</tr> 
			@endforeach	
		</tbody> 
		<tfoot width="100%">
			<tr style="">
			    <td>
					<div class="row">
						<div class="col-md-8" >  Total a cancelar </div>
						<div class="col-md-4" id="totalcompra" class="td_total_text" style="text-align: right; padding-right:30px;" >
							{{ f_num::get($deuda) }} 
							{{ Form::hidden('saldo_compra', $deuda) }}
						</div>
					</div>
			    </td>
		    </tr>
		</tfoot>
	</table>
@endif

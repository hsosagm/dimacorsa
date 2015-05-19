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
		<?php 
			$deuda = $deuda + $q->total;   
			$precio = number_format($q->precio,2,'.',',');
			$total = number_format($q->total,2,'.',',');
		?>

		<tr>
			<td field="cantidad" cod="{{ $q->id }}" class="EditPurchaseItemDetails" width="10%">
				{{ $q->cantidad }}
			</td>   
			<td width="70%">
				{{ $q->descripcion }}  
			</td>
			<td align="right" field="precio" cod="{{ $q->id }}" class="EditPurchaseItemDetails" width="10%">
				{{ $precio }}
			</td>
			<td width="10%" align="right"> 
				{{ $total }} 
			</td>
			<td width="5%">
				<i id="{{ $q->id }}" href="admin/compras/DeletePurchaseDetailsItem" class="fa fa-trash-o pointer btn-link theme-c" onClick="DeleteDetalle(this);"></i>
			</td>
		</tr> 

		@endforeach	

	</tbody> 

	<tfoot width="100%">
		<?php
		    $deuda2 = $deuda;
		    $deuda = number_format($deuda,2,'.',',');
        ?>
		<tr style="border: solid 1px black">
		    <td>
				<div class="row">
					<div class="col-md-8" >  Total a cancelar </div>
					<div class="col-md-4" id="totalcompra" class="td_total_text" style="text-align:center" >
						{{ $deuda }} 
						{{ Form::hidden('saldo_compra', $deuda2) }}
					</div>
				</div>
		    </td>
	    </tr>
	</tfoot>

</table>

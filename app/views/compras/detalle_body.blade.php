<table width="100%"> 

	<tbody> 

		@foreach ($detalle as $key => $q)

			<?php 
				$precio = number_format($q->precio,2,'.',',');
				$total = number_format($q->total,2,'.',',');
			?>

			<tr>

				<td class="hide">
					{{ $q->producto_id }} 
				</td>

				<td field="cantidad" cod="{{ $q->id }}" class="edit_detalle_compra" width="10%">
					{{ $q->cantidad }}
				</td>   

				<td width="70%">
					{{ $q->descripcion }}  
				</td>

				<td align="right" field="precio" cod="{{ $q->id }}" class="edit_detalle_compra" width="10%">
					{{ $precio }}
				</td>

				<td width="10%" align="right"> 
					{{ $total }} 
				</td>

				<td width="5%">
					<i id="{{ $q->id }}" href="admin/compras/delete_inicial" class="fa fa-times pointer btn-link theme-c" onClick="DeleteDetalle(this);"></i>
				</td>

			</tr> 

		@endforeach
		

	</tbody> 

</table>

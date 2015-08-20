@if (count(@$detalle) > 0)
	<table width="100%">
		<tbody>
			<tr>
	            <th width="10%">Cantidad</th>
	            <th width="60%">Descripcion</th>
	            <th width="10%">Precio</th>
	            <th width="10%">Totales</th>
	            <th width="10%" colspan="2"></th>
	        </tr>
	        <?php $deuda = 0; ?>
			@foreach($detalle as $q)
			    <?php  $deuda = $deuda + $q->total; ?>
		        <tr>
		            <td field="cantidad" cod="{{ $q->id }}" class="edit"> {{ $q->cantidad }} </td>          
		            <td> {{ $q->descripcion }} </td>
		            <td field="precio" style="text-align:right;   padding-right: 20px !important;" cod="{{ $q->id }}" class="edit"> 
		            	{{ f_num::get($q->precio) }} 
		            </td>
		            <td style="text-align:right;   padding-right: 20px !important; "> {{ f_num::get($q->total); }} </td>
		            <td>
		            	<i id="{{ $q->id }}" href="admin/traslados/eliminar_detalle" class="fa fa-trash-o pointer btn-link theme-c" onClick="DeleteDetalle(this);"></i>
		            </td>
		            <td>
		            	<i onclick="ingresarSeriesDetalleTraslado(this, {{ $q->id }})" class="fa fa-barcode fg-theme"></i>
		            </td>
		        </tr>
			@endforeach
		</tbody>
		<tfoot >
			<tr>
			    <td>Total Traslado:</td>
		    </tr>
		</tfoot>
	</table>
@endif

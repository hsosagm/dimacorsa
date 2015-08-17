@if (count(@$detalle) > 0)

<table width="100%">

    <thead >
        <tr>
            <th width="10%">Cantidad</th>
            <th width="70%">Descripcion</th>
            <th width="10%">Precio</th>
            <th width="10%">Totales</th>
            <th width="5%"></th>
        </tr>
    </thead>

	<tbody>

        <?php $deuda = 0; ?>

		@foreach($detalle as $q)
		    <?php  $deuda = $deuda + $q->total;  ?>
	        <tr>
	            <td field="cantidad" cod="{{ $q->id }}" class="edit" width="10%"> {{ $q->cantidad }} </td>          
	            <td width="70%"> {{ $q->descripcion }} </td>
	            <td field="precio" style="text-align:right;   padding-right: 20px !important;" cod="{{ $q->id }}" class="edit" width="10%"> {{ f_num::get($q->precio) }} </td>
	            <td width="10%" style="text-align:right;   padding-right: 20px !important; "> {{ f_num::get($q->total) }} </td>
	            <td width="5%" >
	            		<i id="{{ $q->id }}" href="admin/descargas/eliminar_detalle" class="fa fa-trash-o pointer btn-link theme-c" onClick="DeleteDetalle(this);"></i>
	            </td>
	            <td>
	            	<i onclick="ingresarSeriesDetalleDescarga(this, {{ $q->id }})" class="fa fa-barcode fg-theme"></i>
	            </td>
	        </tr>
		@endforeach
	    
	</tbody>

	<tfoot width="100%">
		<tr>
		    <td>
				<div class="row">
					<div class="col-md-8" >  Total Descarga: </div>
					<div class="col-md-4" id="totalventas" class="td_total_text" style="text-align:right; padding-right:50px;" >
						{{ f_num::get($deuda) }} 
					</div>
				</div>
		    </td>
	    </tr>
	</tfoot>

</table>

@endif

@if (count(@$detalle) > 0)

<table width="100%">

    <thead >
        <tr>
            <th width="10%">Cantidad</th>
            <th width="70%">Descripcion</th>
            <th width="10%">Precio</th>
            <th width="10%">Totales</th>
            <th width="5%">Eliminar</th>
        </tr>
    </thead>

	<tbody>
	
        <?php $deuda = 0; ?>

		@foreach(@$detalle as $q)
		    <?php
			    $deuda = $deuda + $q->total;        
		        $precio = number_format($q->precio,2,'.',',');
		        $total = number_format($q->total,2,'.',',');
	        ?>
	        <tr>
	            <td field="cantidad" cod="{{ $q->id }}" class="edit" width="10%"> {{ $q->cantidad }} </td>          
	            <td width="70%"> {{ $q->descripcion }} </td>
	            <td field="precio" cod="{{ $q->id }}" class="edit" width="10%"> {{ $precio }} </td>
	            <td width="10%"> {{ $total }} </td>
	            <td width="5%"><i onclick="RemoveSaleItem(this, {{ $q->id }}, {{ $q->producto_id }}, {{ $q->cantidad }});" class="fa fa-trash-o pointer btn-link theme-c"> </i></td>
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
					<div class="col-md-4" id="totalventas" class="td_total_text" style="text-align:center" >
						{{ $deuda }} 
						{{ Form::hidden('saldo_venta', $deuda2) }}
					</div>
				</div>
		    </td>
	    </tr>
	</tfoot>

</table>

@endif

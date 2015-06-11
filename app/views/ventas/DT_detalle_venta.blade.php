<table class="DT_table_div" width="100%">

    <tr>
        <td class="center" width="10%">Cantidad</td>
        <td class="center" width="70%">Descripcion</td>
        <td class="center" width="10%">Precio</td>
        <td class="center" width="10%">Totales</td>
    </tr>

	<tbody >

        <?php $deuda = 0; ?>

		@foreach($detalle as $q)
		    <?php
			    $deuda = $deuda + $q->total;        
		        $precio = number_format($q->precio,2,'.',',');
		        $total = number_format($q->total,2,'.',',');
	        ?>
	        <tr>
	            <td field="cantidad" cod="{{ $q->id }}" class="edit" width="10%"> {{ $q->cantidad }} </td>          
	            <td width="70%"> {{ $q->descripcion }} </td>
	            <td field="precio" cod="{{ $q->id }}" class="edit right" width="10%"> {{ $precio }} </td>
	            <td width="10%" class="right"> {{ $total }} </td>
	        </tr>
		@endforeach
	    
	</tbody>

	<tfoot width="100%">
		<?php
		    $deuda = number_format($deuda,2,'.',',');
        ?>
		<tr>
		    <td></td>
		    <td class="center">Total a cancelar</td>
		    <td></td>
		    <td class="right">{{ $deuda }} </td>
	    </tr>
	</tfoot>

</table>
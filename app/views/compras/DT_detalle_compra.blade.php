<table class="DT_table_div" width="100%">

    <tr class="DT_table_div_detail">
        <td class="center" width="10%">Cantidad</td>
        <td class="center" width="70%">Descripcion</td>
        <td class="center" width="10%">Precio</td>
        <td class="center" width="10%">Totales</td>
    </tr>

	<tbody >

		@foreach($detalle as $q)
		    <?php
			    $deuda = $deuda + $q->total;        
		        $precio = f_num::get($q->precio);
		        $total = f_num::get($q->total);
	        ?>
	        <tr>
	            <td field="cantidad" cod="{{ $q->id }}" class="edit" width="10%"> {{ $q->cantidad }} </td>          
	            <td width="70%"> {{ $q->descripcion }} </td>
	            <td field="precio" cod="{{ $q->id }}" class="edit align_right" width="10%"> {{ $precio }} </td>
	            <td width="10%" class="align_right"> {{ $total }} </td>
	        </tr>
		@endforeach
	    
	</tbody>

	<tfoot width="100%">

	</tfoot>

</table>

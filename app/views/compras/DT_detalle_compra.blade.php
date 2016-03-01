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
	        ?>
	        <tr>
	            <td field="cantidad" cod="{{ $q->id }}" class="edit" width="10%"> {{ $q->cantidad }} </td>          
	            <td width="70%"> {{ $q->descripcion }} </td>
	            <td field="precio" cod="{{ $q->id }}" class="edit right" width="10%"> {{ f_num::get5($q->precio) }} </td>
	            <td width="10%" cright"> {{ f_num::get5($q->total) }} </td>
	        </tr>
		@endforeach
	    
	</tbody>

	<tfoot width="100%">

	</tfoot>

</table>

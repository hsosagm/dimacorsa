<table class="DT_table_div" width="100%">
	<tr>
		<th colspan="4">Usuario que recibio: {{ (@$usuario_recibio == ' ')? "Indefinido":@$usuario_recibio; }}</th>
	</tr>
    <tr>
        <td class="center" width="10%">Cantidad</td>
        <td class="center" width="75%">Descripcion</td>
        <td class="center" width="10%">Precio</td>
        <td class="center" width="10%">Totales</td>
    </tr>
	<tbody >
        <?php $deuda = 0; ?>
		@foreach($detalle as $q)
		    <?php
			    $deuda = $deuda + $q->total;        
		        $precio = f_num::get($q->precio);
		        $total = f_num::get($q->total);
	        ?>
	        <tr>
	            <td class="edit" width="10%"> {{ $q->cantidad }} </td>          
	            <td width="70%"> {{ $q->descripcion }} </td>
	            <td class="right" width="10%"> {{ $precio }} </td>
	            <td width="10%" class="right"> {{ $total }} </td>
	        </tr>
		@endforeach
	</tbody>
	<tfoot width="100%">
		<tr>
		    <td></td>
		    <td class="center">Total traslado</td>
		    <td></td>
		    <td class="right">{{ f_num::get($deuda); }} </td>
	    </tr>
	</tfoot>
</table>

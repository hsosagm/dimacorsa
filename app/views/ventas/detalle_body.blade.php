<table>

    <thead>
        <tr>
            <th class="hide">id</th>
            <th width="50">Cantidad</th>
            <th width="580">Descripcion</th>
            <th width="70">Precio</th>
            <th width="70">Totales</th>
            <th width="70">Eliminar</th>
        </tr>
    </thead>

	<body>
		@foreach($detalle as $q)
		    <?php
			    $deuda = $deuda + $q->total;        
		        $precio = number_format($q->precio,2,'.',',');
		        $total = number_format($q->total,2,'.',',');
	        ?>
	        <tr>
	            <td class="hide"> {{ $q->producto_id }} </td>
	            <td field="cantidad" cod="' . $q->producto_id . '" class="edit" width="60"> {{ $q->cantidad }} </td>          
	            <td width="580"> {{ $q->descripcion }} </td>
	            <td field="precio" cod="' . $q->producto_id . '" class="edit" width="75"> {{ $precio }} </td>
	            <td width="75"> {{ $total }} </td>
	            <td width="50"><i id="fv_item_delete" class="fa fa-trash-o pointer"></i></td>
	        </tr>
		@endforeach

	    <?php
		    $deuda2 = $deuda;
		    $deuda = number_format($deuda,2,'.',',');
        ?>
		<tr style="border: solid 1px black">
		    <td colspan="3" id="totalventas" class="td_total_text" style="text-align:center"> Total a cancelar</td>
		    <td id="total_ventas" class="td_total"> {{ $deuda }} </td>
		    <td class="hide"><input id="saldo_venta" type="text" value="{{ $deuda2 }}" /></td>
		    <td class="td_tabla" colspan="2" ></td>
	    </tr>
	</body>

</table>
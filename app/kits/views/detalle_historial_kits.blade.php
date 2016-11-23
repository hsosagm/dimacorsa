<table class="DT_table_div" width="100%">
    <tr>
        <td class="center" width="10%">Cantidad</td>
        <td class="center" width="70%">Descripcion</td>
        <td class="center" width="10%">Precio</td>
        <td class="center" width="10%">Totales</td>
    </tr>
	<tbody>
        @php($total = 0)
		@foreach($detalle as $q)
		    @php($total += $q->total)
	        <tr>
	            <td width="10%"> {{ $q->cantidad }} </td>
	            <td width="70%"> {{ $q->descripcion }} </td>
	            <td class="right" width="10%"> {{ f_num::get($q->precio) }} </td>
	            <td class="right" width="10%"> {{ f_num::get($q->total) }} </td>
	        </tr>
		@endforeach
	</tbody>
	<tr>
		<td></td>
		<td class="center">Total</td>
		<td></td>
		<td class="right">{{ f_num::get($total) }} </td>
	</tr>
</table>

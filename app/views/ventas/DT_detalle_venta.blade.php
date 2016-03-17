<table class="DT_table_div" width="100%">
    <tr>
        <td class="center" width="10%">Cantidad</td>
        <td class="center" width="70%">Descripcion</td>
        <td class="center" width="10%">Precio</td>
        <td class="center" width="10%">Totales</td>
    </tr>
	<tbody >
        @php($deuda = 0)
		@foreach($detalle as $q)
		    @php($deuda = $deuda + $q->total)
	        <tr>
	            <td width="10%"> {{ $q->cantidad }} </td>
	            <td width="70%"> {{ $q->descripcion }} </td>
	            <td class="right" width="10%"> {{ f_num::get($q->precio) }} </td>
	            <td width="10%" class="right"> {{ f_num::get($q->total) }} </td>
	        </tr>
		@endforeach
	</tbody>
	<tr>
		<td></td>
		<td class="center">Total a cancelar</td>
		<td></td>
		<td class="right">{{ f_num::get($deuda) }} </td>
	</tr>
	<tr>
		<td colspan="2"></td>
		<td class="right">Metodo P.</td>
		<td class="right">Monto</td>
	</tr>
	@foreach($pagos as $pg)
	    <tr>
	    	<td colspan="2"></td>
	        <td class="right"> {{ $pg->metodo_pago->descripcion }} </td>
	        <td class="right"> {{ f_num::get($pg->monto) }} </td>
	    </tr>
	@endforeach
</table>

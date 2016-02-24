 <table class="DT_table_div" width="100%">
 	<tr>
 		<td colspan="2">
 			<strong>{{ $adelanto->descripcion }}</strong>
 		</td>
 	</tr>
    <tr>
        <td class="center" width="80%">Metodo Pago</td>
        <td class="center" width="20%">Monto</td>
    </tr>
	<tbody>
	    @php($pago = 0)

		@foreach($adelanto->pagos as $q)
		    @php($pago = $pago + $q->monto)
	        <tr>
	            <td width="80%"> {{ $q->metodoPago->descripcion }} </td>
	            <td class="right" width="20%"> {{ f_num::get($q->monto) }} </td>
	        </tr>
		@endforeach
	</tbody>

	<tfoot width="100%">
		<tr>
		    <td class="center"><strong>Total adelanto</strong></td>
		    <td class="right"><strong>{{ f_num::get($pago) }}</strong></td>
	    </tr>
	</tfoot>
</table>

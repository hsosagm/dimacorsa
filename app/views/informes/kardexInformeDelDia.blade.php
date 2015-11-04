<table width="100%" class="table table-theme table-striped" id="informeKardex">
    <thead>
        <tr>
    		<th>Fecha</th>
    		<th>Producto</th>
    		<th>Transaccion</th>
    		<th>Evento</th>
    		<th>Cantidad</th>
    		<th>Existencia</th>
    		<th>Costo Unitario</th>
    		<th>Costo Promedio</th>
    		<th>Costo del Movimiento</th>
    		<th>Total Acumulado</th>
    	</tr>
    </thead>
	<tbody>
        @foreach($kardex as $data)
			<tr>
				<td> {{ $data->fecha }} </td>
				<td> {{ $data->producto }} </td>
				<td> {{ $data->transaccion }} </td>
				<td> {{ $data->evento }} </td>
				<td> {{ $data->cantidad }} </td>
				<td> {{ $data->existencia }} </td>
				<td align="right"> {{ f_num::get($data->costo) }} </td>
				<td align="right"> {{ f_num::get($data->costo_promedio) }} </td>
				<td align="right"> {{ f_num::get($data->total_movimiento) }} </td>
				<td align="right"> {{ f_num::get($data->total_acumulado) }} </td>
			</tr>
    	@endforeach
	</tbody>

</table>

<script type="text/javascript">
    $("#iSearch").val("");
    $("#iSearch").unbind();
    $("#table_length4").html("");
    $('#informeKardex').dataTable();
    setTimeout(function() {
        $('#informeKardex_length').prependTo("#table_length4");
        $('#iSearch').keyup(function(){
            $('#informeKardex').dataTable().fnFilter( $(this).val() );
        })
    }, 300);
</script>

<style type="text/css">
    #informeKardex th:nth-child(1)  { width: 15% !important; }
    #informeKardex th:nth-child(2)  { width: 22% !important; }
    #informeKardex th:nth-child(3)  { width: 8% !important; }
    #informeKardex th:nth-child(4)  { width: 6% !important; }
    #informeKardex th:nth-child(5)  { width: 5% !important; }
    #informeKardex th:nth-child(6)  { width: 5% !important; }
    #informeKardex th:nth-child(7)  { width: 9% !important; }
    #informeKardex th:nth-child(8)  { width: 10% !important; }
    #informeKardex th:nth-child(9)  { width: 10% !important; }
    #informeKardex th:nth-child(10) { width: 10% !important; }
</style>

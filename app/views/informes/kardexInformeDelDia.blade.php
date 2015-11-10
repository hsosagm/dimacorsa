<div class="row">
        <div  id="kardex_legth" class="pull-left"></div>
        <div  class="pull-left" padding-left="20px">
            <input type="text" name="name" id="iSearchKardex">
        </div>
</div>

<br>

<table width="100%" class="table table-theme table-striped" id="informeKardex">
    <thead>
        <tr>
    		<th>Fecha</th>
    		<th>Producto</th>
    		<th>Transac.</th>
    		<th>Evento</th>
    		<th>Cant.</th>
    		<th>Exist.</th>
    		<th>C. Unit.</th>
    		<th>C. Pro.</th>
    		<th>C. Mov.</th>
    		<th>Acumulado</th>
    	</tr>
    </thead>
	<tbody>
        @foreach($kardex as $data)
			<tr>
				<td style="font-size:11px !important"> {{ $data->fecha }} </td>
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
    $("#iSearchKardex").val("");
    $("#iSearchKardex").unbind();
    $("#kardex_legth").html("");
    $('#informeKardex').dataTable();
    setTimeout(function() {
        $('#informeKardex_length').prependTo("#kardex_legth");
        $('#iSearchKardex').keyup(function(){
            $('#informeKardex').dataTable().fnFilter( $(this).val() );
        })
    }, 300);
</script>

<style type="text/css">
    #informeKardex th:nth-child(1)  { width: 10% !important; }
    #informeKardex th:nth-child(2)  { width: 29% !important; }
    #informeKardex th:nth-child(3)  { width: 7% !important; }
    #informeKardex th:nth-child(4)  { width: 5% !important; }
    #informeKardex th:nth-child(5)  { width: 5% !important; }
    #informeKardex th:nth-child(6)  { width: 5% !important; }
    #informeKardex th:nth-child(7)  { width: 9% !important; }
    #informeKardex th:nth-child(8)  { width: 10% !important; }
    #informeKardex th:nth-child(9)  { width: 10% !important; }
    #informeKardex th:nth-child(10) { width: 10% !important; }
</style>

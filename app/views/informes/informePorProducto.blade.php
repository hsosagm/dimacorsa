<div class="row">
    <div  id="ventas_legth2" class="pull-left"></div>
    <div  class="pull-left" padding-left="20px">
        <input type="text" name="name" id="iSearchVentas">
    </div>
</div>

<br>

<table class="table table-theme" id="informeVentas" width="100%">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>P. Costo</th>
            <th>Ganancia</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($detalle_ventas as $dt)
            <tr>
                <td> {{ $dt->created_at }} </td>
                <td> {{ $dt->producto->descripcion }} </td>
                <td> {{ $dt->cantidad }} </td>
                <td class="right"> {{ f_num::get($dt->precio - $dt->ganancias) }} </td>
                <td class="right"> {{ f_num::get($dt->ganancias) }} </td>
                <td class="right"> {{ f_num::get(($dt->precio - $dt->ganancias) * $dt->cantidad) }} </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script type="text/javascript">
    $("#iSearchVentas").val("");
    $("#iSearchVentas").unbind();
    $("#ventas_legth2").html("");
    $('#informeVentas').dataTable();
    setTimeout(function() {
        $('#informeVentas_length').prependTo("#ventas_legth2");
        $('#iSearchVentas').keyup(function(){
            $('#informeVentas').dataTable().fnFilter( $(this).val() );
        })
    }, 300);
</script>

<style type="text/css">
    #informeVentas th:nth-child(1) { width: 15% !important; }
    #informeVentas th:nth-child(2) { width: 40% !important; }
    #informeVentas th:nth-child(3) { width: 8% !important; }
    #informeVentas th:nth-child(4) { width: 11% !important; }
    #informeVentas th:nth-child(5) { width: 11% !important; }
    #informeVentas th:nth-child(6) { width: 15% !important; }
</style>

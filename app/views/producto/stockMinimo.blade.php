
<div class="panel_heading master-table short_calendar ">
    <div id="table_length3" class="pull-left"></div>

    <div class="pull-right">
        <button onclick="$('#graph_container').hide()" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
    </div>
</div>

<table width="100%" id="StockMinimo" class="table table-theme">
    <thead>
        <tr>
            <th>Descripcion</th>
            <th>Marca</th>
            <th>Categoria</th>
            <th>Existencia</th>
            <th>Exist. Minima</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stockMinimo as $sm)
            <tr id="{{ $sm->producto_id }}">
                <td> {{ $sm->descripcion }} </td>
                <td> {{ $sm->marca }} </td>
                <td> {{ $sm->categoria }} </td>
                <td> {{ $sm->existencia }} </td>
                <td> {{ $sm->existencia_minima }} </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script type="text/javascript">
    $("#iSearch").val("");
    $("#iSearch").unbind();
    $("#table_length3").html("");
    $('#StockMinimo').dataTable();
    setTimeout(function() {
        $('#StockMinimo_length').prependTo("#table_length3");
        $('#iSearch').keyup(function(){
            $('#StockMinimo').dataTable().fnFilter( $(this).val() );
        })
    }, 300);
</script>

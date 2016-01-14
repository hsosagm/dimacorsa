<div class="row" style="padding: 10px;">
    <div class="col-md-11">
        {{ Form::open(array('v-on="submit: getActualizarConsultasPorFecha"')) }}
        <input type="hidden" value="{{@$producto_id}}" name="producto_id">
        <table class="master-table">
            <tr class="col-md-3">
                <td class="col-md-6"> Fecha Inicial <br><input type="text"  name="fecha_inicial" data-value="{{$fecha_inicial}}"></td>
                <td class="col-md-1"></td>
            </tr>
            <tr class="col-md-3">
                <td class="col-md-6">Fecha Final <br><input type="text"  name="fecha_final" data-value="{{$fecha_final}}"></td>
                <td class="col-md-1"></td>
            </tr>

            <tr class="col-md-4">
                <td class="col-md-7" style="padding-right: 12px ! important;">
                    Tienda <br> 
                    {{ Form::select('tienda_id', Tienda::lists('nombre', 'id'), @$tienda_id, array('id'=>'kardexTiendaId', "style" => 'border: 1px solid rgb(200, 200, 200) ! important; background: white none repeat scroll 0% 0%; height: 25px;'));}}
                </td>
                <td class="col-md-4" align="right" style="vertical-align: bottom;">
                    <button class="btn btn-theme form-control" type="submit" > Actualizar !</button>
                </td>
            </tr>
            <tr class="col-md-1">
            </tr>
        </table> 
        {{Form::close()}}
    </div>
    <div class="col-md-1">
        <i  class="fa fa-file-excel-o fa-lg" v-on="click: exportarKardexExcel($event, {{@$producto_id}}, '{{$fecha_inicial}}', '{{$fecha_final}}')"> </i>
        <i class="fa fa-file-pdf-o fa-lg" v-on="click: exportarKardexPdf($event, {{@$producto_id}}, '{{$fecha_inicial}}', '{{$fecha_final}}')"> </i>
    </div>
</div>
 
<table class="dt-table table-striped table-theme" id="dataTableKardex" width="100%">
    <tbody style="background: #ffffff;">
        <tr>
            <td style="font-size: 14px; color:#1b7be2;" colspan="7" class="dataTables_empty">Cargando datos del servidor...</td>
        </tr>
    </tbody>
</table>
<script type="text/javascript">

    $("#iSearch").val("");
    $("#iSearch").unbind();
    $('.bread-current').text("");

    setTimeout(function(){
        $("#iSearch").focus();
        $('#dataTableKardex_length').hide();
        oTable = $('#dataTableKardex').dataTable();
        $('#iSearch').keyup(function(){
            oTable.fnFilter( $(this).val() );
        })
    }, 300);

    $(document).ready(function() {
        $('#dataTableKardex').dataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ archivos por pagina",
                "zeroRecords": "No se encontro ningun archivo",
                "info": "Mostrando la pagina _PAGE_ de _PAGES_",
                "infoEmpty": "No hay archivos disponibles",
                "infoFiltered": "- ( filtrado de _MAX_ archivos )"
            },
            "aoColumnDefs": [
                {"sClass": "width15",                         "sTitle": "Fecha",                "aTargets": [0]},
                {"sClass": "width25",                         "sTitle": "Tienda/Usuario",       "aTargets": [1]},
                {"sClass": "width10",                         "sTitle": "Transaccion",          "aTargets": [2]},
                {"sClass": "width10 ",                        "sTitle": "Evento",               "aTargets": [3]},
                {"sClass": "width5  ",                        "sTitle": "Cantidad",             "aTargets": [4]},
                {"sClass": "width5  ",                        "sTitle": "Existencia",           "aTargets": [5]},
                {"sClass": "width10 right formato_precio",    "sTitle": "Costo Unitario",       "aTargets": [6]},
                {"sClass": "width10 right formato_precio",    "sTitle": "Costo Promedio",       "aTargets": [7]},
                {"sClass": "width10 right formato_precio",    "sTitle": "Costo del Movimiento", "aTargets": [8]},
                {"sClass": "width10 right formato_precio",    "sTitle": "Total Acumulado",      "aTargets": [9]},
            ],
            "fnDrawCallback": function( oSettings ) {
                $("td[class*='formato_precio']").each(function() {
                    $(this).html(formato_precio($(this).html()));
                });
            },
            "bJQueryUI": false,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "admin/kardex/DtKardexPorFecha/{{$consulta}}",
            "fnServerParams": function (aoData) {
                aoData.push({ "name": "fecha_inicial", "value": "{{@$fecha_inicial}}" });
                aoData.push({ "name": "fecha_final",  "value": "{{@$fecha_final}}" });
                aoData.push({ "name": "producto_id",  "value": "{{@$producto_id}}" });
                aoData.push({ "name": "tienda_id",  "value": "{{@$tienda_id}}" });
            },
        });
    });

    $('input[name="fecha_inicial"]').pickadate({
      max: true,
      selectYears: true,
      selectMonths: true
    });

    $('input[name="fecha_final"]').pickadate({
      max: true,
      selectYears: true,
      selectMonths: true
    });

    $('[data-action=collapse_head]').find('i').removeClass('fa-angle-down').addClass('fa-angle-up');

    $("#kardexTiendaId").prepend('<option value=0>Mostrar todas</option>');

</script>

@if (@$tienda_id <= 0)
    <script>
        $("#kardexTiendaId").prop('selectedIndex', 0);
    </script>
@endif

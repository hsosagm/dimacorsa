<?php $grafica = Input::get('grafica'); ?>
<table class="dt-table table-striped table-theme" id="example">
        <tbody style="background: #ffffff;">
            <tr>
                <td style="font-size: 14px; color:#1b7be2;" colspan="7" class="dataTables_empty">Cargando datos del servidor...</td>
            </tr>
        </tbody>
    </table>
<script>
$(document).ready(function() {
    $("#iSearch").val("");
    $("#iSearch").unbind();
    $("#table_length3").html("");

    setTimeout(function() {
        $('#example_length').prependTo("#table_length3");
        if ( "{{$grafica}}" != "true") {
            graph_container.x = 2;
        }
        else{
             graph_container.x = 3;
        }

        $('#iSearch').keyup(function(){
            $('#example').dataTable().fnFilter( $(this).val() );
        })
    }, 300);

    $('#example').dataTable({

        "language": {
            "lengthMenu": "Mostrar _MENU_ archivos por pagina",
            "zeroRecords": "No se encontro ningun archivo",
            "info": "Mostrando la pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay archivos disponibles",
            "infoFiltered": "- ( filtrado de _MAX_ archivos )"
        },

        "aoColumnDefs": [
            {"sClass": "width15",                                        "sTitle": "Fecha",   "aTargets": [0]},
            {"sClass": "width25",                                        "sTitle": "Vendedor","aTargets": [1]},
            {"sClass": "width35",                                        "sTitle": "Cliente", "aTargets": [2]},
            {"sClass": "width10 right formato_precio",                   "sTitle": "Total",   "aTargets": [3]},
            {"sClass": "width10 right formato_precio",                   "sTitle": "Saldo",   "aTargets": [4]},
            {"bVisible": false,                                                              "aTargets": [5]},
            {"sClass": "width5 icons center", "orderable": false,             "sTitle": "",        "aTargets": [6],
                "mRender": function(  data, type, full ) {
                    $v  = '<a href="javascript:void(0);" title="Ver detalle" onclick="showSalesDetail(this)" class="fa fa-plus-square show_detail font14">';
                    return $v;
                }
            }
        ],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
            $("td[class*='formato_precio']").each(function() {
                $(this).html(formato_precio($(this).html()));
            });
        },

        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            if ( aData[5] == 0){
                jQuery(nRow).addClass('red');
            }
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "admin/cierre/consultas/DtVentasDelMesPorUsuario",
        "fnServerParams": function (aoData) {
           aoData.push({ "name": "user_id", "value": "{{Input::get('user_id')}}" });
           aoData.push({ "name": "fecha", "value": "{{Input::get('fecha')}}" });
       },
    });

});

</script>

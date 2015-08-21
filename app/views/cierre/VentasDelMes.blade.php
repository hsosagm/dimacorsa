<?php $fecha = Input::get('fecha'); ?>
<?php $grafica = Input::get('grafica'); ?>

@if(Input::has('grafica'))
    <table class="dt-table table-striped table-theme" id="example">
        <tbody style="background: #ffffff;">
            <tr>
                <td style="font-size: 14px; color:#1b7be2;" colspan="7" class="dataTables_empty">Cargando datos del servidor...</td>
            </tr>
        </tbody>
    </table>
@endif

<script type="text/javascript">
    $(document).ready(function() {
        
        if ( "{{$grafica}}" != "true") {
            proccess_table('Ventas del mes');
        }else{
            $("#iSearch").val("");
            $("#iSearch").unbind();
            $("#table_length").html("");

            setTimeout(function() {
                $('#example_length').prependTo("#table_length");
                graph_container.x = 3;
                
                $('#iSearch').keyup(function(){
                    $('#example').dataTable().fnFilter( $(this).val() );
                })
            }, 300);
        }

        $('#example').dataTable({

            "language": {
                "lengthMenu": "Mostrar _MENU_ archivos por pagina",
                "zeroRecords": "No se encontro ningun archivo",
                "info": "Mostrando la pagina _PAGE_ de _PAGES_",
                "infoEmpty": "No hay archivos disponibles",
                "infoFiltered": "- ( filtrado de _MAX_ archivos )"
            },
            
            "aoColumnDefs": [
            {"sClass": "mod_codigo hover width5",                          "sTitle": "Cantidad",              "aTargets": [0]},
            {"sClass": "mod_codigo hover widthL",                           "sTitle": "Descripcion",         "aTargets": [1]},
            {"sClass": "mod_codigo hover widthS formato_precio right",      "sTitle": "P. Costo",            "aTargets": [2]},
            {"sClass": "mod_codigo hover widthS formato_precio right",      "sTitle": "P. Lista",            "aTargets": [3]},
            {"sClass": "mod_codigo hover widthS formato_precio right",      "sTitle": "P. Promedio",         "aTargets": [4]},
            {"sClass": "mod_codigo hover widthS formato_porcentaje right",  "sTitle": "Utilidad / Porcentaje","aTargets": [5]},
            {"sClass": "mod_codigo hover widthS formato_precio right",      "sTitle": "Utilidad / Total",    "aTargets": [6]},
            {"sClass": "widthS icons center",   "sTitle": "",   "aTargets": [7],
            "orderable": false,
            "mRender": function() {
                return '<i class="fa fa-plus-square btn-link theme-c" fecha="{{$fecha}}" onClick="DetalleDeVentasPorProducto(this)"></i>';
            }
        },
        ],
        "order": [[ 0, "desc" ]],

        "fnDrawCallback": function( oSettings ) {

            $("td[class*='formato_precio']").each(function() {
                $(this).html(formato_precio($(this).html()));
            });
            $("td[class*='formato_porcentaje']").each(function() {
                $(this).html(formato_porcentaje($(this).html()));
            });
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "admin/cierre/VentasDelMes_dt?fecha={{Input::get('fecha')}}"
    });

});

</script>
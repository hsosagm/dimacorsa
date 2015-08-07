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

<script>
$(document).ready(function() {
    
     if ( "{{$grafica}}" != "true") {
            proccess_table('Soportes del mes');
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
            {"sClass": "mod_codigo hover widthM",                       "sTitle": "Usuario",     "aTargets": [0]},
            {"sClass": "mod_codigo hover widthM",                       "sTitle": "Fecha",       "aTargets": [1]},
            {"sClass": "mod_codigo hover widthL",                       "sTitle": "Descripcion", "aTargets": [2]},
            {"sClass": "mod_codigo hover right widthS formato_precio",  "sTitle": "Monto",       "aTargets": [3]},
            {"sClass": "mod_codigo hover widthS",                       "sTitle": "Metodo Pago","aTargets": [4]},
        ],
        "fnDrawCallback": function( oSettings ) {
            $("td[class*='formato_precio']").each(function() {
                $(this).html(formato_precio($(this).html()));
            });
        },
        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "admin/cierre/SoportePorFecha_dt?fecha={{Input::get('fecha')}}"
    });

});
</script>
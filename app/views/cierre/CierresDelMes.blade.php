
<script>
$(document).ready(function() {

    proccess_table('Cierrres del mes');

    $('#example').dataTable({

        "language": {
            "lengthMenu": "Mostrar _MENU_ archivos por pagina",
            "zeroRecords": "No se encontro ningun archivo",
            "info": "Mostrando la pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay archivos disponibles",
            "infoFiltered": "- ( filtrado de _MAX_ archivos )"
        },
        
        "aoColumnDefs": [
            {"sClass": "mod_codigo hover width15",              "sTitle": "Tienda",      "aTargets": [0]},
            {"sClass": "mod_codigo hover width20",              "sTitle": "Usuario",     "aTargets": [1]},
            {"sClass": "mod_codigo hover width40",              "sTitle": "Nota",        "aTargets": [2]},
            {"sClass": "mod_codigo hover width15",              "sTitle": "Fecha",       "aTargets": [3]},
            {"sClass": "width10 icons center",                          "sTitle": "",            "aTargets": [4],
                "orderable": false,
                "mRender": function() {
                    return '<i class="fa fa-plus-square btn-link theme-c" onClick="VerDetalleDelCierreDelDia(this)"></i><a href="javascript:void(0);" title="Imprimir Cierre" onclick="ExportarCierreDelDiaPdf(this)" class="fa fa-file-pdf-o font14" style="padding-left:15px"><a href="javascript:void(0);" title="Ver Cierre" onclick="CierreDelDiaPorFecha(this)" class="fa fa-search font14" style="padding-left:10px">';
                }

            },
        ],
        "order": [[ 3, "desc" ]],
        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "admin/cierre/CierresDelMes_dt?fecha={{Input::get('fecha')}}"
    });

});
</script>
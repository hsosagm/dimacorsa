<script>
$(document).ready(function() {

    proccess_table('Cortes de Caja del mes');

    $('#example').dataTable({

        "language": {
            "lengthMenu": "Mostrar _MENU_ archivos por pagina",
            "zeroRecords": "No se encontro ningun archivo",
            "info": "Mostrando la pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay archivos disponibles",
            "infoFiltered": "- ( filtrado de _MAX_ archivos )"
        },
        
        "aoColumnDefs": [
            {"sClass": "mod_codigo hover width10",              "sTitle": "Caja",        "aTargets": [0]},
            {"sClass": "mod_codigo hover width15",              "sTitle": "Usuario",     "aTargets": [1]},
            {"sClass": "mod_codigo hover width40",              "sTitle": "Nota",        "aTargets": [2]},
            {"sClass": "mod_codigo hover width15",              "sTitle": "Fecha Inicio","aTargets": [3]},
            {"sClass": "mod_codigo hover width15",              "sTitle": "Fecha Final", "aTargets": [4]},
            {"sClass": "width5 icons center",                   "sTitle": "",            "aTargets": [5],
                "orderable": false,
                "mRender": function(data, type, full) {
                    return '<i title="Ver Corte" onclick="getMovimientosDeCajaDt(this, '+full.DT_RowId+')" class="fa fa-search font14" style="padding-left:10px"> </i>';
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
        "sAjaxSource": "admin/cajas/DtCortesDeCajasPorDia?fecha={{Input::get('fecha')}}"
    });

});
</script>
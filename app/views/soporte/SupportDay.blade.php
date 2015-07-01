
<script>
$(document).ready(function() {

    proccess_table('Soporte del dia');

    $('#example').dataTable({

        "language": {
            "lengthMenu": "Mostrar _MENU_ archivos por pagina",
            "zeroRecords": "No se encontro ningun archivo",
            "info": "Mostrando la pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay archivos disponibles",
            "infoFiltered": "- ( filtrado de _MAX_ archivos )"
        },
        
        "aoColumnDefs": [
            {"sClass": "mod_codigo hover widthS",                  "sTitle": "Tienda",      "aTargets": [0]},
            {"sClass": "mod_codigo hover widthS",                  "sTitle": "Usuario",     "aTargets": [1]},
            {"sClass": "mod_codigo hover widthS",                  "sTitle": "Fecha",       "aTargets": [2]},
            {"sClass": "mod_codigo hover widthS",                  "sTitle": "Descripcion", "aTargets": [3]},
            {"sClass": "mod_codigo hover widthS",                  "sTitle": "Monto", "aTargets": [4]},
            {"sClass": "mod_codigo hover  align_right widthS",     "sTitle": "Metodo Pago",       "aTargets": [5]},
            {"sClass": "widthS icons",   "sTitle": "Acciones",   "aTargets": [6],
                "orderable": false,
                "mRender": function() {
                    return ' <i class="fa fa-trash-o btn-link theme-c" title="Eliminar"  onclick="_delete_dt(this)"></i> ';
                }
            },
        ],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "user/soporte/SupportDay_dt"
    });

});
</script>
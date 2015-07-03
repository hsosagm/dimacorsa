
<script>
$(document).ready(function() {

    proccess_table('Inventario');

    $('#example').dataTable({

        "language": {
            "lengthMenu": "Mostrar _MENU_ archivos por pagina",
            "zeroRecords": "No se encontro ningun archivo",
            "info": "Mostrando la pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay archivos disponibles",
            "infoFiltered": "- ( filtrado de _MAX_ archivos )"
        },
        
        "aoColumnDefs": [
            {"sClass": "mod_codigo hover widthM",              "sTitle": "Fecha",       "aTargets": [0]},
            {"sClass": "mod_codigo hover widthM",              "sTitle": "Fecha Doc.",  "aTargets": [1]},
            {"sClass": "mod_codigo hover widthM",              "sTitle": "Usuario",     "aTargets": [2]},
            {"sClass": "mod_codigo hover widthM",              "sTitle": "Proveedor",   "aTargets": [3]},
            {"sClass": "mod_codigo hover  widthM",             "sTitle": "Factura",     "aTargets": [4]},
            {"sClass": "mod_codigo hover right widthM",        "sTitle": "Total",       "aTargets": [5]},
            {"sClass": "mod_codigo hover right widthM",        "sTitle": "Saldo",       "aTargets": [6]},
            {"sClass": "widthS icons",   "sTitle": "Acciones",   "aTargets": [7],
                "orderable": false,
                "mRender": function() {
                    return ' <i class="fa fa-plus-square btn-link theme-c" onClick="showPurchasesDetail(this)"></i>';
                }
            },
        ],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "admin/compras/Purchase_dt?proveedor_id={{Input::get('proveedor_id')}}"
    });

});
</script>
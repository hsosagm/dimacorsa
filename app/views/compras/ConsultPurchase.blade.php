
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
            {"sClass": "mod_codigo hover widthM",              "sTitle": "Usuario",     "aTargets": [1]},
            {"sClass": "mod_codigo hover widthM",              "sTitle": "Proveedor",   "aTargets": [2]},
            {"sClass": "mod_codigo hover align_right widthM",  "sTitle": "Factura",     "aTargets": [3]},
            {"sClass": "mod_codigo hover align_right widthM",  "sTitle": "Total",       "aTargets": [4]},
            {"sClass": "mod_codigo hover align_right widthM",  "sTitle": "Saldo",       "aTargets": [5]},
            {"sClass": "widthS icons",   "sTitle": "Acciones",   "aTargets": [6],
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
        "sAjaxSource": "admin/datatables/Purchase_dt?proveedor_id={{Input::get('proveedor_id')}}"
    });

});
</script>

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
            {"sClass": "mod_codigo hover align_right widthS",  "sTitle": "Factura",     "aTargets": [3]},
            {"sClass": "mod_codigo hover align_right widthS",  "sTitle": "Total",       "aTargets": [4]},
            {"sClass": "mod_codigo hover align_right widthS",  "sTitle": "Saldo",       "aTargets": [5]},
            {"sClass": "mod_codigo hover align_right widthS",  "sTitle": "Ver Detalle", "aTargets": [6]},
            {"sClass": "mod_codigo hover align_right widthS",  "sTitle": "Ver Factura", "aTargets": [7]},
        ],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "admin/datatables/PurchaseDay_dt"
    });

});
</script>

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
            {"sClass": "widthS icons",   "sTitle": "Acciones",   "aTargets": [6],
                "orderable": false,
                "mRender": function() {
                    return '<a href="javascript:void(0);">Detalle</a> <a href="javascript:void(0);" onClick="VerFacturaDeCompra(this)">Factura</a>';
                }
            }, 
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
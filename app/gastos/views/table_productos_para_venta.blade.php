<script type="text/javascript">

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
            {"sClass": "mod_codigo hover widthM",              "sTitle": "Codigo",       "aTargets": [0]},
            {"sClass": "mod_codigo hover widthM",              "sTitle": "Marca",        "aTargets": [1]},
            {"sClass": "mod_codigo hover widthL",              "sTitle": "Descripcion",  "aTargets": [2]},
            {"sClass": "mod_codigo hover right widthS",        "sTitle": "P publico",    "aTargets": [3]},
            {"sClass": "mod_codigo hover right widthS",        "sTitle": "Existencia",   "aTargets": [4]},
            {"sClass": "mod_codigo hover right widthS",        "sTitle": "Total",        "aTargets": [5]},
        ],
        "order": [[ 4, "desc" ]],
        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
            $( ".DTTT" ).append('<button onclick="add_producto_to_venta()" class="btn btngrey btn_edit" disabled>Agregar a venta</button>');
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "user/ventas/table_productos_para_venta_DT"
    });

});
</script>
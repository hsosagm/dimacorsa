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
            $( ".DTTT" ).append('<button onclick="addProducto()" class="btn btngrey btn_edit" disabled>Agregar producto</button>');
        },
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "user/ventas/table_productos_para_venta_DT"
    });

});

function addProducto()
{
    $("input[name='codigo']").val($('.dataTable tbody .row_selected td:first-child').text());
    $(".dt-container").hide();

    $.ajax({
        type: 'GET',
        url: 'user/ventas/findProducto',
        data: { codigo: $('.dataTable tbody .row_selected td:first-child').text() }
    }).done(function(data) {
        if (!data.success)
            return msg.warning(data);

        kits.producto = data.values;
    })
};
</script>
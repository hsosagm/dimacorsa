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
    $.ajax({
        type: 'GET',
        url: 'admin/kits/findProducto',
        data: { codigo: $('.dataTable tbody .row_selected td:first-child').text() }
    }).done(function(data) {
        if (!data.success)
            return msg.warning('El codigo que buscas no existe..!');

        $(".dt-container").hide();

        if ({{ Input::get('master') }}) {
            kits.producto = data.values;
            return $("input[name=cantidad]").focus();
        }

        kits.producto_detalle = data.values;
        $("input[name=cantidadDetalle]").focus();
    })
};
</script>
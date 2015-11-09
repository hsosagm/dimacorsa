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
            {"sClass": "mod_codigo hover widthS",              "sTitle": "Marca",        "aTargets": [1]},
            {"sClass": "mod_codigo hover widthL",              "sTitle": "Descripcion",  "aTargets": [2]},
            {"sClass": "mod_codigo hover right widthS",        "sTitle": "Cantidad",    "aTargets": [3]},
            {"sClass": "mod_codigo hover right widthS",        "sTitle": "Precio venta",   "aTargets": [4]},
            {"sClass": "mod_codigo hover right widthS",        "sTitle": "Total",        "aTargets": [5]},
        ],

        "fnDrawCallback": function( oSettings ) {
            $(".DTTT").html("");
            $(".DTTT").append('<button onclick="add_producto_to_devolucion()" class="btn btngrey btn_edit" disabled>ADD</button>');
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "user/ventas/devoluciones/productos_para_devolucion_DT",
        "fnServerParams": function (aoData) {
            aoData.push({ "name": "venta_id", "value": "{{$venta_id}}" });
       },
    });

});

</script>
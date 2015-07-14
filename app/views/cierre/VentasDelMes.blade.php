<?php $fecha = Input::get('fecha'); ?>
<script>
$(document).ready(function() {

    proccess_table('Ventas del mes');

    $('#example').dataTable({

        "language": {
            "lengthMenu": "Mostrar _MENU_ archivos por pagina",
            "zeroRecords": "No se encontro ningun archivo",
            "info": "Mostrando la pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay archivos disponibles",
            "infoFiltered": "- ( filtrado de _MAX_ archivos )"
        },
        
        "aoColumnDefs": [
            {"sClass": "mod_codigo hover widthS",                      "sTitle": "Cantidad",            "aTargets": [0]},
            {"sClass": "mod_codigo hover widthL",                      "sTitle": "Descripcion",         "aTargets": [1]},
            {"sClass": "mod_codigo hover widthS formato_precio right", "sTitle": "P. Costo",            "aTargets": [2]},
            {"sClass": "mod_codigo hover widthS formato_precio right", "sTitle": "P. Venta",            "aTargets": [3]},
            {"sClass": "mod_codigo hover widthS formato_precio right", "sTitle": "P. Promedio",         "aTargets": [4]},
            {"sClass": "mod_codigo hover widthS formato_precio right", "sTitle": "Utilidad / Unidad",   "aTargets": [5]},
            {"sClass": "mod_codigo hover widthS formato_precio right", "sTitle": "Utilidad / Total",    "aTargets": [6]},
            {"sClass": "widthS icons",   "sTitle": "Acciones",   "aTargets": [7],
                "orderable": false,
                "mRender": function() {
                    return '<i class="fa fa-plus-square btn-link theme-c" fecha="{{$fecha}}" onClick="DetalleDeVentasPorProducto(this)"></i>';
                }
            },
        ],
        "order": [[ 0, "desc" ]],
        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
            $("td[class*='formato_precio']").each(function() {
                $(this).html(formato_precio($(this).html()));
            });
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "admin/cierre/VentasDelMes_dt?fecha={{Input::get('fecha')}}"
    });

});
</script>
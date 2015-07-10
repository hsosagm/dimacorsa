
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
            {"sClass": "mod_codigo hover widthS",                      "sTitle": "Tienda",      "aTargets": [0]},
            {"sClass": "mod_codigo hover widthM",                      "sTitle": "Usuario",     "aTargets": [1]},
            {"sClass": "mod_codigo hover widthS",                      "sTitle": "Fecha",       "aTargets": [2]},
            {"sClass": "mod_codigo hover  widthM",                     "sTitle": "Metodo Pago", "aTargets": [3]},
            {"sClass": "mod_codigo hover right widthS formato_precio", "sTitle": "Monto",       "aTargets": [4]},
            {"sClass": "mod_codigo hover  widthL",                     "sTitle": "Observaciones","aTargets": [5]},
            {"sClass": "widthS icons",   "sTitle": "Acciones",   "aTargets": [6],
                "orderable": false,
                "mRender": function() {
                    return '<i class="fa fa-plus-square btn-link theme-c" onClick="showPaymentsDetail(this)"></i> <i style="padding-left:10px" class="fa fa-trash-o btn-link theme-c" onClick="_delete_dt(this)"></i>';
                }
            },
        ],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
            $("td[class*='formato_precio']").each(function() {
                $(this).html(formato_precio($(this).html()));
            });
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "admin/compras/HistorialDeAbonos?proveedor_id={{Input::get('proveedor_id')}}"
    });

});
</script>


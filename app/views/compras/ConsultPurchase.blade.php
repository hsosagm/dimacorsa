@include('proveedor_partials.head_content_table')
<script>
$(document).ready(function() {
    $('#example').dataTable({
        "language": {
            "lengthMenu": "Mostrar _MENU_ archivos por pagina",
            "zeroRecords": "No se encontro ningun archivo",
            "info": "Mostrando la pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay archivos disponibles",
            "infoFiltered": "- ( filtrado de _MAX_ archivos )"
        },
        "aoColumnDefs": [
            {"sClass": "mod_codigo hover width15",                      "sTitle": "Fecha",       "aTargets": [0]},
            {"sClass": "mod_codigo hover width10",                      "sTitle": "F. Doc.",     "aTargets": [1]},
            {"sClass": "mod_codigo hover width20",                      "sTitle": "Usuario",     "aTargets": [2]},
            {"sClass": "mod_codigo hover width20",                      "sTitle": "Proveedor",   "aTargets": [3]},
            {"sClass": "mod_codigo hover  width10",                     "sTitle": "Factura",     "aTargets": [4]},
            {"sClass": "mod_codigo hover right width10 formato_precio", "sTitle": "Total",       "aTargets": [5]},
            {"sClass": "mod_codigo hover right width10 formato_precio", "sTitle": "Saldo",       "aTargets": [6]},
            {"sClass": "width5 center icons",   "sTitle": "",   "aTargets": [7],
                "orderable": false,
                "mRender": function() {
                    return ' <i class="fa fa-plus-square btn-link theme-c" onClick="showPurchasesDetail(this)"></i>';
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
        "sAjaxSource": "admin/compras/Purchase_dt?proveedor_id={{Input::get('proveedor_id')}}"
    });
});
</script>
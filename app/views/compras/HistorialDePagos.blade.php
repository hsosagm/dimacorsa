
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
            {"sClass": "mod_codigo hover widthM",                      "sTitle": "Tienda",      "aTargets": [0]},
            {"sClass": "mod_codigo hover widthM",                      "sTitle": "Usuario",     "aTargets": [1]},
            {"sClass": "mod_codigo hover widthM",                      "sTitle": "Fecha",       "aTargets": [2]},
            {"sClass": "mod_codigo hover widthM",                      "sTitle": "Factura",     "aTargets": [3]},
            {"sClass": "mod_codigo hover widthS",                      "sTitle": "M.P.",        "aTargets": [4]},
            {"sClass": "mod_codigo hover right widthS formato_precio", "sTitle": "Monto",       "aTargets": [5]},
        ],
        "order": [[ 2, "desc" ]],
        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
            $("td[class*='formato_precio']").each(function() {
                $(this).html(formato_precio($(this).html()));
            });
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "admin/compras/HistorialDePagos?proveedor_id={{Input::get('proveedor_id')}}"
    });

});
</script>

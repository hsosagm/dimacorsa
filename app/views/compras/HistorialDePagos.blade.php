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
                {"sClass": "mod_codigo hover widthM",                      "sTitle": "Usuario",     "aTargets": [0]},
                {"sClass": "mod_codigo hover widthM",                      "sTitle": "Fecha",       "aTargets": [1]},
                {"sClass": "mod_codigo hover widthM",                      "sTitle": "Factura",     "aTargets": [2]},
                {"sClass": "mod_codigo hover widthS",                      "sTitle": "M.P.",        "aTargets": [3]},
                {"sClass": "mod_codigo hover right widthS formato_precio", "sTitle": "Monto",       "aTargets": [4]},
            ],
            "order": [[ 1, "desc" ]],
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

<script>
$(document).ready(function() {
    proccess_table('Soporte del dia');
    $('#example').dataTable({
        "language": {
            "lengthMenu": "Mostrar _MENU_ archivos por pagina",
            "zeroRecords": "No se encontro ningun archivo",
            "info": "Mostrando la pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay archivos disponibles",
            "infoFiltered": "- ( filtrado de _MAX_ archivos )"
        },
        "aoColumnDefs": [
            {"sClass": "mod_codigo hover widthM",                       "sTitle": "Usuario",     "aTargets": [0]},
            {"sClass": "mod_codigo hover widthM",                       "sTitle": "Fecha",       "aTargets": [1]},
            {"sClass": "mod_codigo hover widthL",                       "sTitle": "Descripcion", "aTargets": [2]},
            {"sClass": "mod_codigo hover right widthS formato_precio",  "sTitle": "Monto",       "aTargets": [3]},
            {"sClass": "mod_codigo hover widthS",                       "sTitle": "Metodo Pago","aTargets": [4]},
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
        "sAjaxSource": "admin/cierre/SoportePorFecha_dt?fecha={{Input::get('fecha')}}"
    });

});
</script>
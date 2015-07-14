<script>
$(document).ready(function() {
    proccess_table('Gastos del dia');
    $('#example').dataTable({
        "language": {
            "lengthMenu": "Mostrar _MENU_ archivos por pagina",
            "zeroRecords": "No se encontro ningun archivo",
            "info": "Mostrando la pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay archivos disponibles",
            "infoFiltered": "- ( filtrado de _MAX_ archivos )"
        },
        "aoColumnDefs": [
            {"sClass": "mod_codigo hover widthS",                  "sTitle": "Tienda",      "aTargets": [0]},
            {"sClass": "mod_codigo hover widthM",                  "sTitle": "Usuario",     "aTargets": [1]},
            {"sClass": "mod_codigo hover widthM",                  "sTitle": "Fecha",       "aTargets": [2]},
            {"sClass": "mod_codigo hover widthL",                  "sTitle": "Descripcion", "aTargets": [3]},
            {"sClass": "mod_codigo hover right widthS",            "sTitle": "Monto",       "aTargets": [4]},
            {"sClass": "mod_codigo hover widthS",                  "sTitle": "M.P.",        "aTargets": [5]},
        ],
        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
        },
        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "admin/cierre/GastosPorFecha_dt?fecha={{Input::get('fecha')}}"
    });
});
</script>
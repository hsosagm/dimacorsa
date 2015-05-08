<script>

$(document).ready(function()
{
    proccess_table('Productos');

    $('#example').dataTable({
        "aoColumnDefs": [
            {"sClass": "widthS",              "sTitle": "Usuario",       "aTargets": [0]},
            {"sClass": "widthS",              "sTitle": "Codigo",        "aTargets": [1]},
            {"sClass": "widthS",              "sTitle": "Columna",        "aTargets": [2]},
            {"sClass": "widthM1",              "sTitle": "Valor anterior",        "aTargets": [3]},
            {"sClass": "widthM1",              "sTitle": "Valor nuevo",        "aTargets": [4]},
            {"sClass": "widthS",              "sTitle": "Fecha",        "aTargets": [5]},
        ],


        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "owner/logs/productos_serverside"
    });

});

</script>
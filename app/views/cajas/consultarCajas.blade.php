<script>
$(document).ready(function() {
    proccess_table('');

    $('#example').dataTable({

        "language": {
            "lengthMenu": "Mostrar _MENU_ archivos por pagina",
            "zeroRecords": "No se encontro ningun archivo",
            "info": "Mostrando la pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay archivos disponibles",
            "infoFiltered": "- ( filtrado de _MAX_ archivos )"
        },

        "aoColumnDefs": [
            {"sClass": "width15",                                        "sTitle": "Tienda",            "aTargets": [0]},
            {"sClass": "width25",                                        "sTitle": "Caja",              "aTargets": [1]},
            {"sClass": "width35",                                        "sTitle": "Usuario",           "aTargets": [2]},
            {"sClass": "width25",                                        "sTitle": "Fecha Asignacion",  "aTargets": [3]},
        ],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
            $( ".DTTT" ).append('<button id="_create" class="btn btngrey " >Crear</button>');
            $( ".DTTT" ).append('<button class="btn btngrey" disabled>Asignar</button>');

            $("td[class*='formato_precio']").each(function() {
                $(this).html(formato_precio($(this).html()));
            });
        },

        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {

        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "admin/cajas/DtConsultarCajas"
    });

});
</script>

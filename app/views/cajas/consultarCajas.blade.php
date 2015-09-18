<script>
$(document).ready(function() {

    proccess_table('Cajas');

    $('#example').dataTable({

        "language": {
            "lengthMenu": "Mostrar _MENU_ archivos por pagina",
            "zeroRecords": "No se encontro ningun archivo",
            "info": "Mostrando la pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay archivos disponibles",
            "infoFiltered": "- ( filtrado de _MAX_ archivos )"
        },
        
        "aoColumnDefs": [
            {"sClass": "width15",                                        "sTitle": "Tienda",   "aTargets": [0]},
            {"sClass": "width35",                                        "sTitle": "Caja",     "aTargets": [1]},
            {"sClass": "width50",                                        "sTitle": "Usuario",  "aTargets": [2]},
        ],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
            $( ".DTTT" ).append('<button id="_create" class="btn btngrey " >Crear</button>');
            
            $("td[class*='formato_precio']").each(function() {
                $(this).html(formato_precio($(this).html()));
            });
        },

        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {                
            if ( aData[6] == 0){
                jQuery(nRow).addClass('blue');
            }               
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "admin/cajas/DtConsultarCajas"
    });

});
</script>
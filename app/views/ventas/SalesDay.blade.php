
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
            {"sClass": "widthM",   "sTitle": "Fecha",      "aTargets": [0]},
            {"sClass": "widthM",   "sTitle": "Vendedor",   "aTargets": [1]},
            {"sClass": "widthM",   "sTitle": "Cliente",    "aTargets": [2]},
            {"sClass": "widthS",   "sTitle": "Factura",    "aTargets": [3]},
            {"sClass": "widthS",   "sTitle": "Total",      "aTargets": [4]},
            {"sClass": "widthS",   "sTitle": "Saldo",      "aTargets": [5]},
            {"sClass": "widthS icons",   "sTitle": "Acciones",   "aTargets": [6],
                "orderable": false,
                "mRender": function() {
                    return '<a href="javascript:void(0);" onclick="showSalesDetail(this)" class="fa fa-plus-square  show_detail">';
                }
            }
        ],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "user/datatables/SalesOfDay"
    });

});

</script>
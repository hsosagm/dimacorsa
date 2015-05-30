
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
            {"sClass": "widthM",       "sTitle": "Fecha",                        "aTargets": [0]},
            {"sClass": "widthM",       "sTitle": "Usuario",                     "aTargets": [1]},
            {"sClass": "widthM",       "sTitle": "Cliente",                      "aTargets": [2]},
            {"sClass": "widthS",       "sTitle": "Numero",                      "aTargets": [3]},
            {"sClass": "widthS",       "sTitle": "Saldo",                        "aTargets": [4]},
            {"sClass": "widthS",       "sTitle": "Completed", "bVisible": false, "aTargets": [5]},
            {"sClass": "widthS icons", "sTitle": "Acciones", "orderable": false, "aTargets": [6],
                "mRender": function() {
                    return '<a href="javascript:void(0);" title="Ver detalle" onclick="showSalesDetail(this)" class="fa fa-plus-square show_detail font14"><a href="javascript:void(0);" title="Abrir venta" onclick="openSale(this)" class="fa fa-pencil-square-o font14" style="padding-left:10px">';
                }
            }
        ],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
        },

        "fnRowCallback": function( nRow, aData ) {                
            if ( aData[5] == 0){
                $(nRow).addClass('red');
            }               
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "user/datatables/SalesOfDay"
    });

});

</script>

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
            {"sClass": "widthM",       "sTitle": "Vendedor",                     "aTargets": [1]},
            {"sClass": "widthM",       "sTitle": "Cliente",                      "aTargets": [2]},
            {"sClass": "widthS",       "sTitle": "Saldo",                        "aTargets": [3]},
            {"sClass": "widthS",       "sTitle": "Completed", "bVisible": false, "aTargets": [4]},
            {"sClass": "widthS icons", "sTitle": "Acciones", "orderable": false, "aTargets": [5],
                "mRender": function() {
                    return '<a href="javascript:void(0);" title="Ver detalle" onclick="showSalesDetail(this)" class="fa fa-plus-square show_detail font14"><a href="javascript:void(0);" title="Abrir venta" onclick="openSale(this)" class="fa fa-pencil-square-o font14" style="padding-left:10px"><a href="javascript:void(0);" title="Imprimir Venta" onclick="ImprimirFacturaVenta_dt(this,{{Auth::user()->id}})" class="fa fa-print font14" style="padding-left:10px">';
                }
            }
        ],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
        },

        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {                
            if ( aData[5] == 0){
                jQuery(nRow).addClass('red');
            }               
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "user/consulta/VentasDelDiaUsuario_dt"
    });

});

</script>
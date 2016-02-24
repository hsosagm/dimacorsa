
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
            {"sClass": "widthM",                                        "sTitle": "Fecha",   "aTargets": [0]},
            {"sClass": "widthM",                                        "sTitle": "Vendedor","aTargets": [1]},
            {"sClass": "widthM",                                        "sTitle": "Cliente", "aTargets": [2]},
            {"sClass": "widthS right formato_precio",                   "sTitle": "Total",   "aTargets": [3]},
            {"sClass": "widthS right formato_precio",                   "sTitle": "Saldo",   "aTargets": [4]},
            {"bVisible": false,                                                              "aTargets": [5]},
            {"bVisible": false,                                                              "aTargets": [6]},
            {"sClass": "width5 icons center", "orderable": false,             "sTitle": "",        "aTargets": [7],
                "mRender": function(  data, type, full ) {
                    $v  = '<a href="javascript:void(0);" title="Ver detalle" onclick="showSalesDetail(this)" class="fa fa-plus-square show_detail font14">';
                    $v += '<a href="javascript:void(0);" title="Abrir venta" onclick="openSale(this)" class="fa fa-pencil-square-o font14" style="padding-left:10px">';

                    return $v;
                }
            }
        ],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
            $("td[class*='formato_precio']").each(function() {
                $(this).html(formato_precio($(this).html()));
            });
        },

        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            if ( aData[5] == 0){
                jQuery(nRow).addClass('red');
            }

            if ( aData[5] == 2){
                jQuery(nRow).addClass('orange');
            }

            if ( aData[6] == 1){
                jQuery(nRow).attr('anulada', true);
                jQuery(nRow).addClass('yellow');
            }
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "user/consulta/VentasDelDiaUsuario_dt",
        "fnServerParams": function (aoData) {
           aoData.push({ "name": "tipo", "value": "{{Input::get('tipo')}}" });
       },
    });

});

</script>
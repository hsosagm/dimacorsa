
<script>
$(document).ready(function() {

    proccess_table('Ventas Por Fecha');

    $('#example').dataTable({

        "language": {
            "lengthMenu": "Mostrar _MENU_ archivos por pagina",
            "zeroRecords": "No se encontro ningun archivo",
            "info": "Mostrando la pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay archivos disponibles",
            "infoFiltered": "- ( filtrado de _MAX_ archivos )"
        },
        
        "aoColumnDefs": [
            {"sClass": "widthS",       "sTitle": "Fecha",                        "aTargets": [0]},
            {"sClass": "widthM",       "sTitle": "Usuario",                      "aTargets": [1]},
            {"sClass": "widthL",       "sTitle": "Cliente",                      "aTargets": [2]},
            {"sClass": "widthS right", "sTitle": "Total",                        "aTargets": [3]},
            {"sClass": "widthS right", "sTitle": "Saldo",                        "aTargets": [4]},
            {"bVisible": false,                                                  "aTargets": [5]},
            {"sClass": "widthS center", "sTitle": "Acciones", "orderable": false, "aTargets": [6],
                "mRender": function() {
                    $v  = '<a href="javascript:void(0);" title="Ver detalle" onclick="showSalesDetail(this)" class="fa fa-plus-square show_detail font14">';
                    
                    $v += '<a href="javascript:void(0);" title="Abrir venta" onclick="openSale(this)" class="fa fa-pencil-square-o font14" style="padding-left:10px">';
                    
                    $v += '<a href="javascript:void(0);" title="Imprimir Venta" onclick="ImprimirFacturaVenta_dt(this,{{Auth::user()->id}})" class="fa fa-print font14" style="padding-left:10px">';
                    
                    $v += '<a href="javascript:void(0);" title="Imprimir Factura" onclick="ImprimirGarantiaVenta_dt(this,{{Auth::user()->id}})" class="fa fa-file-o font14" style="padding-left:10px">';

                    return $v;
                }
            }
        ],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
            $( ".DTTT" ).append( '<button consulta="dia"    onclick="OpenTableSalesForDate(this)">Dia</button>'    );
            $( ".DTTT" ).append( '<button consulta="semana" onclick="OpenTableSalesForDate(this)">Semana</button>' );
            $( ".DTTT" ).append( '<button consulta="mes"    onclick="OpenTableSalesForDate(this)">Mes</button>'    );
        },

        "fnRowCallback": function( nRow, aData ) {                
            if ( aData[5] == 0){
                $(nRow).addClass('red');
            }               
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "user/ventas/SalesForDate?fecha={{Input::get('fecha')}}&consulta={{Input::get('consulta')}}"
    });

});

</script>
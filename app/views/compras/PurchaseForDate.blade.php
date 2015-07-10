
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
            {"sClass": "mod_codigo hover widthM",                             "sTitle": "Fecha",       "aTargets": [0]},
            {"sClass": "mod_codigo hover widthM",                             "sTitle": "Fecha Doc.",  "aTargets": [1]},
            {"sClass": "mod_codigo hover widthM",                             "sTitle": "Usuario",     "aTargets": [2]},
            {"sClass": "mod_codigo hover widthM",                             "sTitle": "Proveedor",   "aTargets": [3]},
            {"sClass": "mod_codigo hover  widthS",                            "sTitle": "Factura",     "aTargets": [4]},
            {"sClass": "mod_codigo hover right widthS formato_precio",        "sTitle": "Total",       "aTargets": [5]},
            {"sClass": "mod_codigo hover right widthS formato_precio",        "sTitle": "Saldo",       "aTargets": [6]},
            {"sClass": "widthS",          "sTitle": "Completed", "bVisible": false,     "aTargets": [7]},
            {"sClass": "widthS icons",   "sTitle": "Acciones",   "aTargets": [8],
                "orderable": false,
                "mRender": function() {
                    return '<i class="fa fa-plus-square btn-link theme-c" onClick="showPurchasesDetail(this)"></i> <a href="javascript:void(0);" title="" onclick="VerFacturaDeCompra(this)" class="fa fa-pencil-square-o font14" style="padding-left:10px">';
                }
            }, 
        ],
        "order": [[ 0, "desc" ]],
        "fnDrawCallback": function( oSettings ) {
             $( ".DTTT" ).html("");
            $( ".DTTT" ).append( '<button consulta="dia"    onclick="OpenTablePurchaseForDate(this)">Dia</button>'    );
            $( ".DTTT" ).append( '<button consulta="semana" onclick="OpenTablePurchaseForDate(this)">Semana</button>' );
            $( ".DTTT" ).append( '<button consulta="mes"    onclick="OpenTablePurchaseForDate(this)">Mes</button>'    );

            $("td[class*='formato_precio']").each(function() {
                $(this).html(formato_precio($(this).html()));
            });
        },
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {                
            if ( aData[7] == 0){
                jQuery(nRow).addClass('red');
            }               
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "admin/compras/PurchaseForDate?fecha={{Input::get('fecha')}}&consulta={{Input::get('consulta')}}"
    });

});
</script>
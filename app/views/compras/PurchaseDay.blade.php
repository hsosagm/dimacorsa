
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
            {"sClass": "mod_codigo hover widthM",              "sTitle": "Fecha",       "aTargets": [0]},
            {"sClass": "mod_codigo hover widthM",              "sTitle": "Usuario",     "aTargets": [1]},
            {"sClass": "mod_codigo hover widthM",              "sTitle": "Proveedor",   "aTargets": [2]},
            {"sClass": "mod_codigo hover align_right widthS",  "sTitle": "Factura",     "aTargets": [3]},
            {"sClass": "mod_codigo hover align_right widthS",  "sTitle": "Total",       "aTargets": [4]},
            {"sClass": "mod_codigo hover align_right widthS",  "sTitle": "Saldo",       "aTargets": [5]},
            {"sClass": "widthS",          "sTitle": "Completed", "bVisible": false,     "aTargets": [6]},
            {"sClass": "widthS icons",   "sTitle": "Acciones",   "aTargets": [7],
                "orderable": false,
                "mRender": function() {
                    return '<a href="javascript:void(0);" title="Ver detalle" onclick="showPurchaseDetail(this)" class="fa fa-plus-square show_detail font14"><a href="javascript:void(0);" title="Abrir venta" onclick="VerFacturaDeCompra(this)" class="fa fa-pencil-square-o font14" style="padding-left:10px">';
                }
            }, 
        ],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
        },
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {                
            if ( aData[6] == 0){
                jQuery(nRow).addClass('red');
            }               
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "admin/datatables/PurchaseDay_dt"
    });

});
</script>
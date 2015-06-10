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
            {"sClass": "widthS",               "sTitle": "Usuario",                      "aTargets": [0]},
            {"sClass": "widthM",               "sTitle": "Fecha",                        "aTargets": [1]},
            {"sClass": "widthS right",         "sTitle": "Numero",                       "aTargets": [2]},
            {"sClass": "widthS right",         "sTitle": "Total",                        "aTargets": [3]},
            {"sClass": "widthS right",         "sTitle": "Saldo",                        "aTargets": [4]},
            {"sClass": "widthS center font14", "sTitle": "Acciones", "orderable": false, "aTargets": [5],
                "mRender": function() {
                    return '<a href="javascript:void(0);" title="Ver detalle" onclick="showSalesDetail(this)" class="fa fa-plus-square show_detail">';
                }
            }
        ],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "user/cliente/DT_salesByCustomer",
        "fnServerParams": function (aoData) {
            aoData.push({ "name": "cliente_id", "value": $("input[name='cliente_id']").val() });
        }
    });

});

</script>
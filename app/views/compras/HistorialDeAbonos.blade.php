@include('proveedor_partials.head_content_table')
<script>
$(document).ready(function() {
    $('#example').dataTable({
        "language": {
            "lengthMenu": "Mostrar _MENU_ archivos por pagina",
            "zeroRecords": "No se encontro ningun archivo",
            "info": "Mostrando la pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay archivos disponibles",
            "infoFiltered": "- ( filtrado de _MAX_ archivos )"
        },
        "aoColumnDefs": [
            {"sClass": "mod_codigo hover width20",                      "sTitle": "Usuario",     "aTargets": [0]},
            {"sClass": "mod_codigo hover width10",                      "sTitle": "Fecha",       "aTargets": [1]},
            {"sClass": "mod_codigo hover  width10",                     "sTitle": "M.P.",        "aTargets": [2]},
            {"sClass": "mod_codigo hover right width5 formato_precio", "sTitle": "Monto",       "aTargets": [3]},
            {"sClass": "mod_codigo hover  width45",                     "sTitle": "Observaciones","aTargets": [4]},
            {"sClass": "width10 icons center",                          "sTitle": "",             "aTargets": [5],
                "orderable": false,
                "mRender": function(data, type, full ) {
                    $v  = '<i class="fa fa-plus-square btn-link theme-c" onClick="showPaymentsDetail(this)"></i> ';

                    $v += '<a href="javascript:void(0);" title="Imprimir Abono" onclick="ImprimirAbonoProveedor(this, '+full.DT_RowId+', '+"'"+'{{@$comprobante->impresora}}'+"'"+')" class="fa fa-print font14" style="padding-left:10px"> </a>';

                    $v += '<i style="padding-left:10px" class="fa fa-trash-o btn-link theme-c" url="admin/compras/payments/" onClick="_delete_dt(this)"></i>';

                    return $v;
                }
            },
        ],
        "order": [[ 1, "desc" ]],
        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
            $("td[class*='formato_precio']").each(function() {
                $(this).html(format_number($(this).html()));
            });
        },
        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "admin/compras/HistorialDeAbonos?proveedor_id={{Input::get('proveedor_id')}}"
    });
});
</script>
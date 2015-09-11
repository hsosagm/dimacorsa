<div class="rounded shadow">
    <div class="panel_heading">
        <div id="table_length" class="pull-left"></div>
        <div class="DTTT btn-group"></div>
        <div class="pull-right">
            <button v-on="click: closeMainContainer" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="no-padding table">
        <table class="dt-table table-striped table-theme" id="example">
            <tbody style="background: #ffffff;">
                <tr>
                    <td style="font-size: 14px; color:#1b7be2;" colspan="6" class="dataTables_empty">Cargando datos del servidor...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function() {

        $('#example').dataTable({

            "language": {
                "lengthMenu": "Mostrar _MENU_ archivos por pagina",
                "zeroRecords": "No se encontro ningun archivo",
                "info": "Mostrando la pagina _PAGE_ de _PAGES_",
                "infoEmpty": "No hay archivos disponibles",
                "infoFiltered": "- ( filtrado de _MAX_ archivos )"
            },

            "order": [[ 1, "desc" ]],
            
            "aoColumnDefs": [
                {"sClass": "widthS",                        "sTitle": "Usuario",                      "aTargets": [0]},
                {"sClass": "widthM",                        "sTitle": "Fecha",                        "aTargets": [1]},
                {"sClass": "widthS right",                  "sTitle": "Numero",                       "aTargets": [2]},
                {"sClass": "widthS right formato_precio",   "sTitle": "Total",                        "aTargets": [3]},
                {"sClass": "widthS right formato_precio",   "sTitle": "Saldo",                        "aTargets": [4]},
                {"sClass": "widthS center font14", "sTitle": "", "orderable": false,                  "aTargets": [5],
                    "mRender": function() {
                        return '<a href="javascript:void(0);" title="Ver detalle" onclick="showSalesDetail(this)" class="fa fa-plus-square show_detail">';
                    }
                }
            ],
  
            "fnDrawCallback": function( oSettings ) {
                $( ".DTTT" ).html("");
                $("td[class*='formato_precio']").each(function() {
                    $(this).html(formato_precio($(this).html()));
                });
            },

            "bJQueryUI": false,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "user/cliente/DT_salesByCustomer",
            "fnServerParams": function (aoData) {
                aoData.push({ "name": "cliente_id", "value": vm.cliente_id });
            }
        });

    });

</script>
<div class="panel_heading">
    <div id="table_length2" class="pull-left"></div>

    <div class="pull-right">
        <button v-on="click: close" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
    </div>
</div>

<div style="min-width: 310px; height: 400px; margin: 0 auto">
    <div style="height: 60px; border: 1px solid #D6D6D6; background: #E9E9E9">
        <h4 style="text-align:center">Devolucion parcial o total de ventas</h4>
    </div>

    <table class="dt-table table-striped table-theme" id="example">
        <tbody style="background: #ffffff;">
            <tr>
                <td style="font-size: 14px; color:#1b7be2;" colspan="7" class="dataTables_empty">Cargando datos del servidor...</td>
            </tr>
        </tbody>
    </table>
</div>
 
<script type="text/javascript">

    $(document).ready(function() {
        $("#iSearch").val("");
        $("#iSearch").unbind();
        $("#table_length2").html("");

        setTimeout(function() {
            $('#example_length').prependTo("#table_length2");
            $('#iSearch').keyup(function(){
                $('#example').dataTable().fnFilter( $(this).val() );
            })
        }, 300);

        $('#example').dataTable({

            "language": {
                "lengthMenu": "Mostrar _MENU_ archivos por pagina",
                "zeroRecords": "No se encontro ningun archivo",
                "info": "Mostrando la pagina _PAGE_ de _PAGES_",
                "infoEmpty": "No hay archivos disponibles",
                "infoFiltered": "- ( filtrado de _MAX_ archivos )"
            },
            "aoColumnDefs": [
                {"sClass": "widthS",                         "sTitle": "Fecha",                        "aTargets": [0]},
                {"sClass": "widthM",                         "sTitle": "Usuario",                      "aTargets": [1]},
                {"sClass": "widthL",                         "sTitle": "Cliente",                      "aTargets": [2]},
                {"sClass": "widthS right formato_precio",    "sTitle": "Total",                        "aTargets": [3]},
                {"sClass": "widthS right formato_precio",    "sTitle": "Saldo",                        "aTargets": [4]},
                {"sClass": "widthS center font14", "orderable": false, "sTitle": "Operaciones", "aTargets": [5],

                    "mRender": function( data, type, full ) {
                        $v  = '<i onclick="showSalesDetail(this)" title="Ver detalle" class="fa fa-plus-square show_detail" style="color:#527DB5"></i>';
                        $v += '<i onclick="returnSale('+full.DT_RowId+')" title="Abrir para devolucion" class="fa fa-check" style="padding-left:20px; color:#52A954"></i>';
                        return $v;
                    }

                },

            ],

            "fnDrawCallback": function( oSettings ) {
                $("td[class*='formato_precio']").each(function() {
                    $(this).html(formato_precio($(this).html()));
                });
            },

            "bJQueryUI": false,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "user/ventas/devoluciones/DT_ventasParaDevoluciones"
        });
    });

    var dv = new Vue({

        el: '#graph_container',

        methods: {
            close: function()
            {
                $('#graph_container').hide()
            }
        }
    });


    function returnSale(venta_id) {
        $.ajax({
            type: "GET",
            url: 'user/ventas/devoluciones/createDevolucion',
            data: { venta_id: venta_id },
        }).done(function(data) {
            if (data.success == true)
            {
                $('.panel-title').text('Formulario Devoluciones');
                $(".forms").html(data.table);
                ocultar_capas();
                return $(".form-panel").show();
            }
            msg.warning(data, 'Advertencia!');
        });
    };

</script>
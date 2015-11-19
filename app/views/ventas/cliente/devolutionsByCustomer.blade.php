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
                {"sClass": "widthM", "sTitle": "Usuario", "aTargets": [0]},
                {"sClass": "widthM center", "sTitle": "Fecha",  "aTargets": [1]},
                {"sClass": "widthM", "sTitle": "Cliente", "aTargets": [2]},
                {"sClass": "widthS right formato_precio", "sTitle": "Total", "aTargets": [3]},
                {"sClass": "width5 icons center", "orderable": false, "sTitle": "Operaciones", "aTargets": [4],
                    "mRender": function(  data, type, full ) {
                        $v  = '<a href="javascript:void(0);" title="Ver detalle" onclick="getDevolucionesDetalle(this)" class="fa fa-plus-square show_detail font14">';
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

            "bJQueryUI": false,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "user/cliente/DT_devolutionsByCustomer",
            "fnServerParams": function (aoData) {
                aoData.push({ "name": "cliente_id", "value": vm.cliente_id });
            }
        });

    });


    function getDevolucionesDetalle(e) {
        if ($(e).hasClass("hide_detail")) {
            $(e).removeClass('hide_detail');
            $('.subtable').hide();
        } else {
            $('.hide_detail').removeClass('hide_detail');

            if ( $( ".subtable" ).length ) {
                $('.subtable').fadeOut('slow', function(){
                    ajaxDetalleDevolucion(e);
                })
            } else {
                ajaxDetalleDevolucion(e);
            }
        }
    };

    function ajaxDetalleDevolucion(e) {
        var id = $(e).closest('tr').attr('id');
        $('.subtable').remove();
        var nTr = $(e).parents('tr')[0];
        $(e).addClass('hide_detail');
        $(nTr).after("<tr class='subtable'> <td colspan=5><div class='grid_detalle_factura'></div></td></tr>");
        $('.subtable').addClass('hide_detail');

        $.ajax({
            type: 'GET',
            url: "user/ventas/devoluciones/getDevolucionesDetail",
            data: { devolucion_id: id },
        }).done(function(data) {
            if (!data.success == true)
                return msg.warning(data, 'Advertencia!');

            $('.grid_detalle_factura').html(data.table);
            $(nTr).next('.subtable').fadeIn('slow');
            $(e).addClass('hide_detail');
        });
    };

</script>
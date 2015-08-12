
global_cliente_id = 0;
function VentasPendientesPorCliente(e, id)
{
    global_cliente_id = id;
    if ($(e).hasClass("hide_detail"))  {
        $(e).removeClass('hide_detail');
        $('.subtable').fadeOut('slow');
    } 
    else {
        $('.hide_detail').removeClass('hide_detail');

        if ( $( ".subtable" ).length ) {
            $('.subtable').fadeOut('slow', function(){
                getVentasPendientesPorCliente(e, 1 , null);
            })
        }
        else {
            getVentasPendientesPorCliente(e, 1 , null);
        }
    }
}

function getVentasPendientesPorCliente(e , page , sSearch) {
    $('.subtable').remove();
    var nTr = $(e).parents('tr')[0];
    $(e).addClass('hide_detail');
    $(nTr).after("<tr class='subtable'> <td colspan=6><div class='grid_detalle_factura'></div></td></tr>");
    $('.subtable').addClass('hide_detail');

    $.ajax({
        type: 'GET',
        url: "user/ventas/getVentasPendientesPorCliente?page=" + page,
        data: { cliente_id: global_cliente_id ,  sSearch:sSearch},
        success: function (data) {
            if (data.success == true) {
                $('.grid_detalle_factura').html(data.table);
                $(nTr).next('.subtable').fadeIn('slow');
                $(e).addClass('hide_detail');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}

function getVentasPendientesPorClientePaginacion(page , sSearch) {
    $.ajax({
        type: 'GET',
        url: "user/ventas/getVentasPendientesPorCliente?page=" + page,
        data: { cliente_id: global_cliente_id , sSearch:sSearch},
        success: function (data) {
            if (data.success == true) {
                $('.grid_detalle_factura').html(data.table);
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}

$(document).on('click', '.pagination_ventas_por_cliente a', function (e) {
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    getVentasPendientesPorClientePaginacion(page,null);
    
    return false;
});

function getVentaConDetalle(e, venta_id)
{
    $.ajax({
        type: 'GET',
        url: "user/ventas/getVentaConDetalle",
        data: {venta_id: venta_id },
        success: function (data) {
            if (data.success == true) {
                $('#modal-body-detalle').html(data.table);
                $('#modal-title-detalle').text( 'Detalle de Venta' );
                $('#bs-modal-detalle').modal('show');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}

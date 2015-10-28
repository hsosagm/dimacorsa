function misDevolucionesDelDia() {
    $.ajax({
        type: "GET",
        url: 'user/ventas/devoluciones/misDevolucionesDelDia',
    }).done(function(data) {
        if (data.success == true)
            return makeTable(data.table, '', 'Devoluciones');

        msg.warning(data, 'Advertencia!');
    });
};

function getDevolucionesDetail(e) {

    if ($(e).hasClass("hide_detail"))
    {
        $(e).removeClass('hide_detail');
        $('.subtable').hide();
    }
    else
    {
        $('.hide_detail').removeClass('hide_detail');

        if ( $( ".subtable" ).length )
        {
            $('.subtable').fadeOut('slow', function(){
                ajaxDetalleDevolucion(e);
            })
        }
        else
        {
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
        success: function (data) {

            if (data.success == true)
            {
                $('.grid_detalle_factura').html(data.table);
                $(nTr).next('.subtable').fadeIn('slow');
                $(e).addClass('hide_detail');
            }
            else
            {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
};

function openDevolucion(e)
{
    if ($.trim($(e).closest('tr').attr('anulada')) == 'true') {
        return msg.warning('no puedes abrir porque la factura fue anulada..', 'Advertencia!')
    }

    $.ajax({
        type: "GET",
        url: "user/ventas/devoluciones/openDevolucion",
        data: { devolucion_id: $(e).closest('tr').attr('id') },
    }).done(function(data) {
    	console.log(data);
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
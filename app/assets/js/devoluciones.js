function devolucionesDelDia()
{
    $.ajax({
        type: "GET",
        url: 'admin/queries/devoluciones',
    }).done(function(data) {
        if (!data.success == true)
            return msg.warning(data, 'Advertencia!');

        makeTable(data.table, '', 'Devoluciones');
    });
};

function misDevolucionesDelDia()
{
    $.ajax({
        type: "GET",
        url: 'user/ventas/devoluciones/misDevolucionesDelDia',
    }).done(function(data) {
        if (!data.success == true)
            return msg.warning(data, 'Advertencia!');

        makeTable(data.table, '', 'Devoluciones');
    });
};

function getDevolucionesDetail(e)
{
    if ($(e).hasClass("hide_detail"))
    {
        $(e).removeClass('hide_detail');
        $('.subtable').hide();
    } else {
        $('.hide_detail').removeClass('hide_detail');

        if ( $( ".subtable" ).length )
        {
            $('.subtable').fadeOut('slow', function(){
                ajaxDetalleDevolucion(e);
            })
        } else {
            ajaxDetalleDevolucion(e);
        }
    }
};

function ajaxDetalleDevolucion(e)
{
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

function openDevolucion(id)
{
    $.ajax({
        type: "GET",
        url: "user/ventas/devoluciones/openDevolucion",
        data: { devolucion_id: id },
    }).done(function(data) {
        if (!data.success == true)
            return msg.warning(data, 'Advertencia!');

        ocultar_capas();
        $('.panel-title').text('Formulario Devoluciones');
        $(".forms").html(data.table);
        $(".form-panel").show();
    });
};

function deleteDevolucion(element, id)
{
    $.confirm({
        confirm: function()
        {
		    $.ajax({
		        type: "POST",
		        url: "user/ventas/devoluciones/deleteDevolucion",
		        data: { devolucion_id: id },
		    }).done(function(data) {
		        if (!data.success == true)
		            return msg.warning(data, 'Advertencia!');

                $(element).closest('tr').hide();
                msg.success('Devolucion eliminada', 'Success!');
		    });
        }
    });
};
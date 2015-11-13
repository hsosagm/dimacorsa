function getTableInformeGeneral() {
    $.ajax({
        type: "GET",
        url: "admin/informeGeneral/getTableInformeGeneral",
    }).done(function(data) {
        if (!data.success)
            return msg.warning(data, 'Advertencia!');

        makeTable(data.table, '', 'InformeGeneral');
    });
};

function getInformeDetail(e, href)
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
                ajaxInformeDetail(e, href);
            })
        } else {
            ajaxInformeDetail(e, href);
        }
    }
};

function ajaxInformeDetail(e, href)
{
    var id = $(e).closest('tr').attr('id');
    $('.subtable').remove();
    var nTr = $(e).parents('tr')[0];
    $(e).addClass('hide_detail');
    $(nTr).after("<tr class='subtable'> <td colspan=5><div class='grid_detalle_factura'></div></td></tr>");
    $('.subtable').addClass('hide_detail');

    $.ajax({
        type: 'GET',
        url: "admin/informeGeneral/"+href,
        data: { informe_general_id: id },
    }).done(function(data) {
        if (!data.success)
            return msg.warning(data, 'Advertencia!');

        $('.grid_detalle_factura').html(data.table);
        $(nTr).next('.subtable').fadeIn('slow');
        $(e).addClass('hide_detail');
    });
};
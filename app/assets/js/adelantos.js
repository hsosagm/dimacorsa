$(function() {
    $(document).on('click', '#delete_adelanto', function(){ delete_adelanto(this); });
});

function getAdelantosAll() {
    $.ajax({
        type: "GET",
        url: 'user/adelantos/getAdelantos',
    }).done(function(data) {
        if (!data.success)
            return msg.warning(data, 'Advertencia!');

        makeTable(data.table, '', 'Adelantos');
    });
};

function imprimirComprobanteAdelanto(e, adelanto_id)
{
    return window.open('user/adelantos/comprobante?adelanto_id='+adelanto_id ,'_blank');
}

function f_adelanto() {
    $.ajax({
        url: "user/adelantos/create",
        type: "GET"
    }).done(function(data) {
        $('.panel-title').text('Formulario Adelanto');
        $(".forms").html(data);
        ocultar_capas();
        $(".form-panel").show();
        $('#cliente').focus();
    });
}

function delete_adelanto() {
    $id = $("input[name='adelanto_id']").val();;
    $url = "user/adelantos/delete_master";

    $.confirm({
        confirm: function() {
            $.ajax({
                type: "POST",
                url: $url,
                data: { id: $id },
                contentType: 'application/x-www-form-urlencoded',
                success: function (data, text) {
                    if (data == 'success') {
                        msg.success('Adelanto eliminado', 'Listo!')
                       $('.bs-modal').modal('hide');
                    }
                    else {
                        msg.warning('Hubo un erro al tratar de eliminar', 'Advertencia!')
                    }
                },
                error: function (request, status, error) {
                    msg.error(request.responseText, 'Error!')
                }
            });
        }
    });
};

function getAdelantosDetail(e, adelanto_id) {
    if ($(e).hasClass("hide_detail")) {
        $(e).removeClass('hide_detail');
        $('.subtable').hide();
    }
    else {
        $('.hide_detail').removeClass('hide_detail');

        if ( $( ".subtable" ).length ) {
            $('.subtable').fadeOut('slow', function(){
                getDetalleAdelantos(e, adelanto_id);
            })
        }
        else {
            getDetalleAdelantos(e, adelanto_id);
        }
    }
}


function getDetalleAdelantos(e, adelanto_id) {
    $id = $(e).closest('tr').attr('id');
    $('.subtable').remove();
    var nTr = $(e).parents('tr')[0];
    $(e).addClass('hide_detail');
    $(nTr).after("<tr class='subtable'> <td colspan=6 ><div class='grid_detalle_factura'></div></td></tr>");
    $('.subtable').addClass('hide_detail');

    $.ajax({
        type: "GET",
        url: 'user/adelantos/getDetalleAdelantos',
        data: {adelanto_id: adelanto_id},
    }).done(function(data) {
        if (data.success == true)
        {
            $('.grid_detalle_factura').html(data.table);
            $(nTr).next('.subtable').fadeIn('slow');
            return $(e).addClass('hide_detail');
        }
        msg.warning(data, 'Advertencia!');
    });
};

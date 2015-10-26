
function f_coti_op() {
    $.ajax({
        url: "user/cotizaciones/create",
        type: "GET"
    }).done(function(data) {
        $('.panel-title').text('Formulario Cotizacion');
        $(".forms").html(data);
        ocultar_capas();
        $(".form-panel").show();
        $('#cliente').focus();
    });
};

function ingresarProductoRapido(e, cotizacion_id) {
    $.ajax({
        url: "user/cotizaciones/ingresarProductoRapido",
        type: "GET",
        data: {cotizacion_id: cotizacion_id},
    }).done(function(data) {
        if (data.success == true) {
            $('.form_producto_rapido').html(data.view);
            if($('.form_producto_rapido').attr('status') == 0) {
                $('.form_producto_rapido').attr('status', '1');
                $(".form_producto_rapido").slideDown('slow');
            }
            else {
                $('.form_producto_rapido').attr('status','0');
                $(".form_producto_rapido").slideUp('slow');
            }
            return;
        }
        msg.warning(data,'Advertencia..!');
    });
};

function  EliminarCotizacion(e, cotizacion_id){
    $.confirm({
        confirm: function(){
            $(e).prop('disabled', true);
            $.ajax({
                url: "user/cotizaciones/EliminarCotizacion",
                type: "POST",
                data: {cotizacion_id: cotizacion_id},
            }).done(function(data) {
                if (data.success == true) {
                    msg.success('Cotizacion eliminada', 'Listo!');
                    return $(".form-panel").hide();
                }
                $(e).prop('disabled', false);
                msg.warning(data,'Advertencia..!');
            });
        }
    });
};

function ImprimirCotizacion(e, cotizacion_id, opcion) {
    if ($.trim(opcion) == 'pdf')
        return window.open('ImprimirCotizacion/'+opcion+'/'+cotizacion_id ,'_blank');

    $.ajax({
        url: 'ImprimirCotizacion/'+opcion+'/'+cotizacion_id,
        type: "GET"
    }).done(function(data) {
        if (data.success == true)
            return msg.success(data.mensaje, 'Listo!');

        msg.warning(data,'Advertencia..!');
    });
};

function getCotizaciones(e){
	$.get( "user/cotizaciones/getCotizaciones", function( data ) {
		makeTable(data, ' ', 'Cotizaciones');
	});
};

function getMisCotizaciones(e){
	$.get( "user/cotizaciones/getMisCotizaciones", function( data ) {
		makeTable(data, ' ', 'Cotizaciones');
	});
};

function showDetalleCotizacion(e) {

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
                getDetalleCotizacion(e);
            })
        }
        else
        {
            getDetalleCotizacion(e);
        }
    }
};


function getDetalleCotizacion(e) {

    $id = $(e).closest('tr').attr('id');
    $('.subtable').remove();
    var nTr = $(e).parents('tr')[0];
    $(e).addClass('hide_detail');
    $(nTr).after("<tr class='subtable'> <td colspan=7><div class='grid_detalle_factura'></div></td></tr>");
    $('.subtable').addClass('hide_detail');

    $.ajax({
        type: 'GET',
        url: "user/cotizaciones/getDetalleCotizacion",
        data: { cotizacion_id: $id},
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

function EditarCotizacion(e, cotizacion_id) {
    $.ajax({
        type: "GET",
        url: "user/cotizaciones/EditarCotizacion",
        data: { cotizacion_id: cotizacion_id},
    }).done(function(data) {
        if (data.success == true)
        {
            $('.panel-title').text('Formulario Cotizaciones');
            $(".forms").html(data.view);
            $(".dt-container").hide();
            $(".dt-container-cierre").hide();
            return $(".form-panel").show();
        }
        msg.warning(data, 'Advertencia!');
    });
}

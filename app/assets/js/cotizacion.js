
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

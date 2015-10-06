
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
}

function ingresarProductoRapido(e, cotizacion_id) {
    $.ajax({
      url: "user/cotizaciones/ingresarProductoRapido",
      type: "GET",
      data: {cotizacion_id: cotizacion_id},
    }).done(function(data) {
        if (data.success == true) {
            $('.form_producto_rapido').html(data.view);
            return $(".form_producto_rapido").slideToggle('slow');
        }
        msg.warning(data,'Advertencia..!');
    });
}

function setIngresarProductoRapido(e) {
    $(e).prop('disabled', true);

    $.ajax({
      url: "user/cotizaciones/ingresarProductoRapido",
      type: "POST",
      data: $('.formProductoRapido').serialize(),
    }).done(function(data) {
        if (data.success == true) {
            $('.body-detail').html(data.table);
            return $(".form_producto_rapido").slideToggle('slow');
        }
        $(e).prop('disabled', false);
        msg.warning(data,'Advertencia..!');
    });
}

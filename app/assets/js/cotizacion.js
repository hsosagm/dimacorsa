
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

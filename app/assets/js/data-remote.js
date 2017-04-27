$(document).on('submit', 'form[data-remote]', function(e) {
    $('input[type=submit]', this).attr('disabled', 'disabled');

    if( $('input[type=checkbox]', this).is(':checked') )
        $('input[type=checkbox]', this).val('1');
    else
        $('input[type=checkbox]', this).val('0');

    var form = $(this);

    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        success: function (data) {
            if ($.trim(data) == 'success')  {
                msg.success(form.data('success'), 'Listo!');
                $('.bs-modal').modal('hide');
                $('.modal-header .close').show();

                if ($.trim($("input[name='compra_id']").val()) != "") {
                    getActualizarDetalleCompra($("input[name='compra_id']").val());
                };

                return $('input[type=submit]', form).removeAttr('disabled');
            }
            msg.warning(data, 'Advertencia!');
            $('input[type=submit]', form).removeAttr('disabled');
        }
    });
    e.preventDefault();
});


$(document).on('submit', 'form[data-remote-md]', function(e) {
    $('button[type=submit]', this).attr('disabled', 'disabled');
    var form = $(this);

    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        success: function (data) {
            if (data.success == true) {
                msg.success(form.data('success'), 'Listo!');
                $('.master-detail-body').slideUp('slow',function() {
                    $(".info_head").html(data.info_head);
                    $('.master-detail-body').html(data.detalle);
                    $('.master-detail-body').slideDown('slow', function() {
                        $('#search_producto').focus();
                    });
                });
                return $('form .form-footer').hide();
            }
            msg.warning(data, 'Advertencia!');
        }
    });
    $('button[type=submit]', this).removeAttr('disabled');
    e.preventDefault();
});


$(document).on('submit', 'form[data-remote-md-2]', function(e) {
    $('input[type=submit]', this).attr('disabled', 'disabled');
    var form = $(this);

    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        success: function (data) {
            $('input[type=submit]', form).removeAttr('disabled');

            if (!data.success)
                return msg.warning(data, 'Advertencia!');

            msg.success(form.data('success'), 'Listo!');
            $('.master-detail-body2').html(data.detalle);
            form.trigger('reset');
        }
    });

    e.preventDefault();
});


$(document).on('submit', 'form[data-remote-cat]', function(e) {
    $('input[type=submit]', this).attr('disabled', 'disabled');
    var nombre = $('input[name=nombre]' , this);
    var form = $(this);

    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        success: function (data) {
            if (data.success == true) {
                msg.success(form.data('success'), 'Listo!');
                $('.categorias-detail').html(data.lista);
                $("input[name='"+data.input+"']").val(data.id);
                $("#buscar"+data.model).val(data.nombre)
                return nombre.val('');
            }
            return msg.warning(data, 'Advertencia!');
        }
    });
    $('input[type=submit]', this).removeAttr('disabled');
    e.preventDefault();
});


$(document).on('submit', 'form[data-chart]', function(e) {
    $('input[type=submit]', this).attr('disabled', 'disabled');
    $start = $('form[data-chart] input[name="start"]').val();
    $end = $('form[data-chart] input[name="end"]').val();
    var form = $(this);

    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: {start: "'" + $start + "'", end: "'" + $end + "'"},
        success: function (data) {
            $('.table').html(data);
        }
    });
    $('input[type=submit]', this).removeAttr('disabled');
    e.preventDefault();
});


$(document).on('enter', 'form[data-remote-md-d]', function(e) {
    if ($.trim($("input[name=cantidad]").val()) == "")
        return $("input[name=cantidad]").focus();
    else if ($.trim($("input[name=precio]").val()) == "")
        return $("input[name=precio]").focus();

    e.preventDefault();
    var form = $(this);

    if (form.attr('status') == 0) {
        form.attr('status', '1');
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function (data) {
                if (data.success == true) {
                    msg.success(form.data('success'), 'Listo!');
                    $('.body-detail').html(data.table);
                    form.trigger('reset');
                    $('#precio-publico').attr('placeholder',"");
                    $('input[name=serials]', form).val('');
                    form.attr('status', '0');
                    $("#search_producto").focus();
                    $(".form_producto_rapido").slideUp('slow');
                    return $('.precio-costo').html(data.p_costo);
                }
                msg.warning(data, 'Advertencia!');
                form.attr('status', '0');
            }
        });
    }
});


$(document).on('enter', 'form[data-remote-md-dc]', function(e) {
    e.preventDefault();
    var form = $(this);
    if (form.attr('status') == 0) {
        form.attr('status', '1');
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function (data) {
                if (data.success == true) {
                    msg.success(form.data('success'), 'Listo!');
                    $('.body-detail').html(data.table);
                    form.trigger('reset');
                    $('#precio-publico').attr('placeholder',"");
                    $('input[name=serials]', form).val('');
                    form.attr('status', '0');
                    $("#search_producto").focus();
                    $(".form_producto_rapido").slideUp('slow');
                    return $('.precio-costo').html(data.p_costo);
                }
                msg.warning(data, 'Advertencia!');
                form.attr('status', '0');
            }
        });
    }
});

//funcion que se utiliza para traslados y descargas debido a que solo se envia la cantidad
$(document).on('enter', 'form[data-remote-md-d2]', function(e) {
    if ($.trim($("input[name=cantidad]").val()) == "")
        return $("input[name=cantidad]").focus();

    e.preventDefault();
    var form = $(this);

    if (form.attr('status') == 0) {
        form.attr('status', '1');
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function (data) {
                if (data.success == true) {
                    msg.success(form.data('success'), 'Listo!');
                    $('.body-detail').html(data.table);
                    form.trigger('reset');
                     $('#precio-publico').attr('placeholder',"");
                    $('input[name=serials]', form).val('');
                    form.attr('status', '0');
                    $("#search_producto").focus();
                    return $('.precio-costo').html(data.p_costo);
                }
                msg.warning(data, 'Advertencia!');
                form.attr('status', '0');
            }
        });
    }
});

$(document).on('submit', 'form[data-remote-md-info]', function(e) {
    $('input[type=submit]', this).attr('disabled', 'disabled');
    var form = $(this);

    if ( form.attr('status') == 0 ) {
        form.attr('status', '1');
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function (data) {
                form.attr('status', '0');
                if (data.success == true) {
                    msg.success(form.data('success'), 'Listo!');
                    $(".info_head").html(data.info_head);;
                    form.trigger('reset');
                    return $('.bs-modal').modal('hide');
                }
                msg.warning(data, 'Advertencia!');
            }
        });
    }
    $('input[type=submit]', this).removeAttr('disabled');
    e.preventDefault();
});

$(document).on('submit', 'form[data-remote-product]', function(e) {
    $('input[type=submit]', this).attr('disabled', 'disabled');
    var form = $(this);

    if( $('input[type=checkbox]', this).is(':checked') )
        $('input[type=checkbox]', this).val('1');
    else
        $('input[type=checkbox]', this).val('0');

    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        success: function (data) {
            if (data.success) {
                msg.success(form.data('success'), 'Listo!');
                $(".contenedor_producto").slideUp('slow');
                $("#search_producto").val(data.id);
                return search_producto_dt();
            }

            if ($.trim(data) == 'success') {
                msg.success(form.data('success'), 'Listo!');
                $(".contenedor_producto").slideUp('slow');
                $("#search_producto").val(codigo);
                return search_producto_dt();
            }
            msg.warning(data, 'Advertencia!');
        }
    });
    $('input[type=submit]', this).removeAttr('disabled');
    e.preventDefault();
});

$(document).on('submit', 'form[data-remote-md-d]', function(e) {
    e.preventDefault();
    var form = $(this);

    if (form.attr('status') == 0) {
        form.attr('status', '1');
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function (data) {
                if (data.success == true) {
                    msg.success(form.data('success'), 'Listo!');
                    $('.body-detail').html(data.table);
                    form.trigger('reset');
                    $('input[name=serials]', form).val('');
                    form.attr('status', '0');
                    $("#search_producto").focus();
                    return $('.precio-costo').html(data.p_costo);
                }
                msg.warning(data, 'Advertencia!');
                form.attr('status', '0');
            }
        });
    }
});

//funcion para ingresar productos al detalle utilizada en compras y ventas
function ingresarProductoAlDetalle(e) {
    $(e).attr('disabled','disabled');
    var form = $("form[data-remote-md-d]");

    if (form.attr('status') == 0) {
        form.attr('status', '1');
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function (data) {
                if (data.success == true) {
                    msg.success(form.data('success'), 'Listo!');
                    $('.body-detail').html(data.table);
                    form.trigger('reset');
                     $('#precio-publico').attr('placeholder',"");
                    $('input[name=serials]', form).val('');
                    form.attr('status', '0');
                    $("#search_producto").focus();
                    $('.precio-costo').html(data.p_costo);
                    return $(e).removeAttr('disabled');
                }
                msg.warning(data, 'Advertencia!');
                $(e).removeAttr('disabled');
                form.attr('status', '0');
            }
        });
    }
};

//funcion para ingresar productos al detalle utilizada en traslados y descargas
function ingresarProductoAlDetalle2(e) {
    $(e).attr('disabled','disabled');
    var form = $("form[data-remote-md-d2]");

    if (form.attr('status') == 0) {
        form.attr('status', '1');
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function (data) {
                if (data.success == true) {
                    msg.success(form.data('success'), 'Listo!');
                    $('.body-detail').html(data.table);
                    form.trigger('reset');
                     $('#precio-publico').attr('placeholder',"");
                    $('input[name=serials]', form).val('');
                    form.attr('status', '0');
                    $("#search_producto").focus();
                    $('.precio-costo').html(data.p_costo);
                    return $(e).removeAttr('disabled');
                }
                msg.warning(data, 'Advertencia!');
                $(e).removeAttr('disabled');
                form.attr('status', '0');
            }
        });
    }
};

function ingresarProductoAlDetalleCotizacion(e) {
    $(e).attr('disabled','disabled');
    var form = $("form[data-remote-md-dc]");

    if (form.attr('status') == 0) {
        form.attr('status', '1');
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function (data) {
                if (data.success == true) {
                    msg.success(form.data('success'), 'Listo!');
                    $('.body-detail').html(data.table);
                    form.trigger('reset');
                     $('#precio-publico').attr('placeholder',"");
                    $('input[name=serials]', form).val('');
                    form.attr('status', '0');
                    $("#search_producto").focus();
                    $('.precio-costo').html(data.p_costo);
                    $(".form_producto_rapido").slideUp('slow');
                    return $(e).removeAttr('disabled');
                }
                msg.warning(data, 'Advertencia!');
                $(e).removeAttr('disabled');
                form.attr('status', '0');
            }
        });
    }
};

$(document).on('submit', 'form[data-remote]', function(e) {

    $('input[type=submit]', this).attr('disabled', 'disabled');


    if( $('input[type=checkbox]', this).is(':checked') ) 
    {
        $('input[type=checkbox]', this).val('1');
    }
    else
    {
        $('input[type=checkbox]', this).val('0');
    }

    var form = $(this);

    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        success: function (data) {

            if (data == 'success')
            {
                msg.success(form.data('success'), 'Listo!');
                $('.bs-modal').modal('hide');
            }
            else
            {
                msg.warning(data, 'Advertencia!');
            }
        },
        error: function(errors){
            msg.error('Hubo un error, intentelo de nuevo', 'Advertencia!');
        }
    });

    $('input[type=submit]', this).removeAttr('disabled');

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
            if (data.success == true)
            {
                msg.success(form.data('success'), 'Listo!');

                $('.master-detail-body').slideUp('slow',function() {
                    $('.master-detail-body').html(data.detalle);
                    $('.master-detail-body').slideDown('slow', function() {
                        $('#search_producto').focus();
                    });
                });

                $('form .form-footer').hide();

                $('#desabilitar_input').attr('disabled', 'disabled'); // ???
            }
            else
            {
                msg.warning(data, 'Advertencia!');
            }
        },
        error: function(errors) {
            msg.error('Hubo un error, intentelo de nuevo', 'Advertencia!');
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
            if (data.success == true)
            {
                msg.success(form.data('success'), 'Listo!');

                $('.master-detail-body2').html(data.detalle);

                form.trigger('reset');
            }
            else
            {
                msg.warning(data, 'Advertencia!');
            }
        },
        error: function(errors) {
            msg.error('Hubo un error, intentelo de nuevo', 'Advertencia!');
         }
    });

    $('input[type=submit]', this).removeAttr('disabled');

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

            if (data.success == true)
            {
                msg.success(form.data('success'), 'Listo!');
                $('.categorias-detail').html(data.lista);
                $('.select_'+data.model).html(data.select);

                if (data.model == 'categorias') 
                {
                    $.confirm({
                        text: "desea Ingresar Sub Categorias para la Categoria "+nombre.val()+"?",
                        confirm: function() {
                            new_sub_categoria();
                            $('.form-select-'+data.model).html(data.select);
                        }
                    });
                }

                nombre.val('');
            }
            else
            {
                msg.warning(data, 'Advertencia!');
            }
        },
        error: function(errors){
            msg.error('Hubo un error, intentelo de nuevo', 'Advertencia!');
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
        },
        error: function(errors){
            msg.error('Hubo un error, intentelo de nuevo', 'Advertencia!');
        }
    });

    $('input[type=submit]', this).removeAttr('disabled');

    e.preventDefault();
});


$(document).on('shift_enter', 'form[data-remote-md-d]', function() {

    var form = $(this);

    if ( form.attr('status') == 0 ) {

        form.attr('status', '1');

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function (data) {
                if (data.success == true)
                {
                    msg.success(form.data('success'), 'Listo!');

                    $('.body-detail').html(data.table);

                    form.trigger('reset');
                }
                else
                {
                    msg.warning(data, 'Advertencia!');
                }
                form.attr('status', '0');
            },
            error: function(errors) {
                msg.error('Hubo un error, intentelo de nuevo', 'Advertencia!');
                form.attr('status', '0');
            }

        });
    }
});

$(function() {
    $(document).on('click', '#cliente_contacto_view_info',  function() { cliente_contacto_view_info(this); });
    $(document).on('click', '#cliente_contacto_view',       function() { cliente_contacto_view(this);      });
    $(document).on('click', '#cliente_contacto_nuevo',      function() { cliente_contacto_nuevo();         });
    $(document).on('click', '#cliente_help',                function() { cliente_help();                   });
    $(document).on('submit','form[data-remote-contact-cn]', function(e){ cliente_contacto_create(e,this);  });
    $(document).on('submit','form[data-remote-contact-ce]', function(e){ cliente_contacto_update(e,this);  });
    $(document).on('submit','form[data-remote-cliente-e]',  function(e){ cliente_update(e,this);           });
    $(document).on('submit','form[data-remote-cliente-e2]',  function(e){ cliente_update_modulo(e,this);   });
    $(document).on('submit','form[data-remote-cliente-en]',  function(e){ cliente_update_modal(e,this);    });
});


function cliente_contacto_view_info(element) {
    $id = $(element).attr('contacto_id');
    $.ajax({
        type: "POST",
        url:  "user/cliente/contacto_info",
        data: {id:$id},
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            $('.contactos-body-'+$id).slideToggle('slow',function() {
                $('.contactos-body-'+$id).html(data);
            });
        }
    });
};


function cliente_contacto_nuevo() {
     $.get( "user/cliente/contacto_nuevo", function( data ) {
        $('.body-contactos').slideUp('slow',function() {
            $('.body-contactos').html(data);
            $('.body-contactos').slideDown('slow', function() { });
        });
    });
};

function cliente_update(e,element) {
    form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');

    $.ajax({
        type: "POST",
        url:  "user/cliente/edit",
        data: form.serialize(),
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            if (data.success == true)  {
                $('#loader').hide();
                msg.success('Cliente Actualizado..!', 'Listo!');
                ventas.cliente = data.info;
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
    e.preventDefault();
    $('input[type=submit]', form).removeAttr('disabled');
};

function cliente_update_modulo(e,element) {
    form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');

    $.ajax({
        type: "POST",
        url:  "user/cliente/edit",
        data: form.serialize(),
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            if (data.success == true)  {
                msg.success('Cliente Actualizado..!', 'Listo!');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
    e.preventDefault();
    $('input[type=submit]', form).removeAttr('disabled');
};

function cliente_update_modal(e,element) {
    form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');

    $.ajax({
        type: "POST",
        url:  "user/cliente/edit",
        data: form.serialize(),
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            if (data.success == true)  {
                msg.success('Cliente Actualizado..!', 'Listo!');
                $('.bs-modal').modal('hide');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
    e.preventDefault();
    $('input[type=submit]', form).removeAttr('disabled');
};


function cliente_contacto_create(e,element) {
    form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');
    formData = form.serialize()+'& cliente_id='+$("input[name='cliente_id']").val();
    $.ajax({
        type: "POST",
        url:  "user/cliente/contacto_create",
        data: formData,
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            if (data.success == true) {
                $('.body-contactos').slideUp('slow');
                $('.body-contactos').html('');
                $('.contactos-lista').html(data.lista);
                form.trigger('reset');
                msg.success('Contacto Creado..!', 'Listo!');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });

    e.preventDefault();
    $('input[type=submit]', form).removeAttr('disabled');
};


function cliente_contacto_view(element) {
    $id = $(element).attr('contacto_id');
    $.ajax({
        type: "POST",
        url:  "user/cliente/contacto_update",
        data: {id:$id},
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            $('.body-contactos').slideUp('slow',function() {
             $('.body-contactos').html(data);
             $('.body-contactos').slideDown('slow', function() {

             });
         })
        }
    });
};

function cliente_contacto_update(e,element) {
    form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');

    $.ajax({
        type: "POST",
        url:  "user/cliente/contacto_update",
        data: form.serialize(),
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            if (data.success == true) {
                $('.body-contactos').slideUp('slow');
                $('.body-contactos').html('');
                $('.contactos-lista').html(data.lista);
                form.trigger('reset');
                msg.success('Contacto Actualizado..!', 'Listo!');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });

    e.preventDefault();
    $('input[type=submit]', form).removeAttr('disabled');
};

function cliente_contacto_delete(element,cliente_contacto_id) {
    $.confirm({
        confirm: function(button) {
            $.ajax({
                type: "POST",
                url:  "user/cliente/contacto_delete",
                data: {cliente_contacto_id:cliente_contacto_id},
                contentType: 'application/x-www-form-urlencoded',
                success: function (data) {
                    if (data.success == true) {
                        $('.contactos-lista').html(data.lista);
                        msg.success('Contacto Eliminado..!', 'Listo!');
                    }
                    else {
                        msg.warning(data, 'Advertencia!');
                    }
                }
            });
        }
    });
};

function cliente_help() {
    $id = $("input[name='cliente_id']").val();
    if($id > 0) {
        $.ajax({
            type: "GET",
            url: "user/cliente/info",
            data: {id: $id},
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                $('.modal-body').html(data);
                $('.modal-title').text('Informacion del Cliente');
                $('.bs-modal').modal('show');
                $(".info-contactos-body").toggle('fast');
            }
        });
    }
};

function generate_dt(data) {
    vm.clearPanelBody();
    $('.table').html(data);
    $("#iSearch").unbind().val("").focus();
    $("#table_length").html("");
    $( ".DTTT" ).html("");
    $('.dt-panel').show();
    setTimeout(function() {
        $('#example').dataTable();
        $('#example_length').prependTo("#table_length");
        $('.dt-container').show();
        $('#iSearch').keyup(function() {
            $('#example').dataTable().fnFilter( $(this).val() );
        });
    }, 0);
};

function verDetalleAbonosClietes(e) {

    if ($(e).hasClass("hide_detail"))   {
        $(e).removeClass('hide_detail');
        $('.subtable').fadeOut('slow');
    }
    else  {
        $('.hide_detail').removeClass('hide_detail');

        if ( $( ".subtable" ).length ) {
            $('.subtable').fadeOut('slow', function(){
                obtenerDetalleAbonosClientes(e);
            })
        }
        else {
            obtenerDetalleAbonosClientes(e);
        }
    }
};

function obtenerDetalleAbonosClientes(e) {
    $id = $(e).closest('tr').attr('id');

    $('.subtable').remove();
    var nTr = $(e).parents('tr')[0];
    $(e).addClass('hide_detail');
    $(nTr).after("<tr class='subtable'> <td colspan=8><div class='grid_detalle_factura'></div></td></tr>");
    $('.subtable').addClass('hide_detail');

    $.ajax({
        type: 'GET',
        url: "user/ventas/payments/getDetalleAbono",
        data: { abono_id: $id},
        success: function (data) {
            if (data.success == true) {
                $('.grid_detalle_factura').html(data.table);
                $(nTr).next('.subtable').fadeIn('slow');
                $(e).addClass('hide_detail');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
};

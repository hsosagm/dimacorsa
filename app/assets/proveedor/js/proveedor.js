$(function() {
    $(document).on('click', '#proveedor_help',               function() { proveedor_help();         });
    $(document).on('click', '#contacto_create',              function() { contacto_create();        });
    $(document).on('click', '#contacto_view',                function() { contacto_view(this);      });
    $(document).on('click', '#contacto_view_info',           function() { contacto_view_info(this); });
    $(document).on('click', '#contacto_nuevo',               function() { contacto_nuevo();         });
    $(document).on('submit','form[data-remote-proveedor]',   function(e){ proveedor_new(e,this);    });
    $(document).on('submit','form[data-remote-contact-n]',   function(e){ contacto_create(e,this);  });
    $(document).on('submit','form[data-remote-contact-e]',   function(e){ contacto_update(e,this);  });
    $(document).on('submit','form[data-remote-proveedor-e]', function(e){ proveedor_update(e,this); });

});

function clear_contacto_body() {
    $('.body-contactos').slideUp('slow');
}

function proveedor_new(e,element) {
    form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');

    $.ajax({
            type: "POST",
            url:  "admin/proveedor/create",
            data: form.serialize(),
            success: function (data) {
                if (data.success == true) {
                    $('.bs-modal').slideUp('slow' , function () {
                        msg.success('Proveedor Creado..!', 'Listo!');
                        $('.modal-body').html(data.form);
                        $('.modal-title').text('Crear proveedor');
                        $('.bs-modal').modal('show');
                        $('#tab-proveedor-informacio').removeClass('active')
                        $('#tab-proveedor-informacion').removeClass('active  in')
                        $('#tab-proveedor-contactos').addClass('active  in')
                        $('#tab-proveedor-contacto').addClass('active')
                        contacto_nuevo();
                        $('.bs-modal').slideDown('slow', function() {
                            
                        });
                    });
                }
                else
                    msg.warning(data, 'Advertencia!');
            }
        });
    e.preventDefault();
    $('input[type=submit]', form).removeAttr('disabled');
}

function proveedor_help() {
    $id = $("input[name='proveedor_id']").val();
    if($id > 0) {
        $.ajax({
            type: "GET",
            url: "admin/proveedor/help",
            data: {id: $id},
            success: function (data) {
                $('.modal-body').html(data);
                $('.modal-title').text('Informacion del Proveedor');
                $('.bs-modal').modal('show');
                $(".info-contactos-body").toggle('fast');
            }
        });
    }
}

function contacto_create(e,element) {
    form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');
        formData = form.serialize()+'&proveedor_id='+$("input[name='proveedor_id']").val();
        $.ajax({
            type: "POST",
            url:  "admin/proveedor/contacto_create",
            data: formData,
            success: function (data) {
                if (data.success == true) {
                    $('.body-contactos').slideUp('slow');
                    $('.body-contactos').html('');
                    $('.contactos-lista').html(data.lista);
                    form.trigger('reset');
                    msg.success('Contacto Creado..!', 'Listo!');
                }
                else
                    msg.warning(data, 'Advertencia!');
            }
        });
    e.preventDefault();
    $('input[type=submit]', form).removeAttr('disabled');
}

function contacto_view(element) {
    $id = $(element).attr('contacto_id');
    $.ajax({
        type: "POST",
        url:  "admin/proveedor/contacto_update",
        data: {id:$id},
        success: function (data) {
            $('.body-contactos').slideUp('slow',function(){
                $('.body-contactos').html(data);
                $('.body-contactos').slideDown('slow', function() {});
            })
        }
    });
}

function contacto_view_info(element) {
    $id = $(element).attr('contacto_id');
    $.ajax({
        type: "POST",
        url:  "admin/proveedor/contacto_info",
        data: {id:$id},
        success: function (data) {
            $('.contactos-body-'+$id).slideToggle('slow',function(){
                $('.contactos-body-'+$id).html(data);
            });
        }
    });
}

function contacto_nuevo() {
    $.get( "admin/proveedor/contacto_nuevo", function( data ) {
        $('.body-contactos').slideUp('slow',function(){
            $('.body-contactos').html(data);
            $('.body-contactos').slideDown('slow', function() {
                
            });
        });
    });
}

function contacto_update(e,element) {
    form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');
        $.ajax({
            type: "POST",
            url:  "admin/proveedor/contacto_update",
            data: form.serialize(),
            success: function (data) {
                if (data.success == true) {
                    $('.body-contactos').slideUp('slow');
                    $('.body-contactos').html('');
                    $('.contactos-lista').html(data.lista);
                    form.trigger('reset');
                    msg.success('Contacto Actualizado..!', 'Listo!');
                }
                else
                    msg.warning(data, 'Advertencia!');
            }
        });
    e.preventDefault();
    $('input[type=submit]', form).removeAttr('disabled');
}

function proveedor_update(e,element) {
    form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');

    $.ajax({
        type: "POST",
        url:  "admin/proveedor/edit",
        data: form.serialize(),
        success: function (data) {
            if (data == 'success') 
                msg.success('Proveedor Actualizado..!', 'Listo!');
            else
                msg.warning(data, 'Advertencia!');
        }
    });
    e.preventDefault();
    $('input[type=submit]', form).removeAttr('disabled');
}

function proveedor_contacto_delete(element,proveedor_contacto_id) {
    $.confirm({
        confirm: function(button) {
            $.ajax({
                type: "POST",
                url:  "admin/proveedor/contacto_delete",
                data: {proveedor_contacto_id:proveedor_contacto_id},
                success: function (data) {
                    if (data.success == true) {
                        $('.contactos-lista').html(data.lista);
                        msg.success('Contacto Eliminado..!', 'Listo!');
                    }
                    else
                        msg.warning(data, 'Advertencia!');
                }
            });
        }
    });
}

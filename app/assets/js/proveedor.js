$(function() {
    $(document).on('click', '#proveedores',                  function() { proveedores();            });
    $(document).on('click', '#proveedor_edit',               function() { proveedor_edit();         });
    $(document).on('click', '#proveedor_create',             function() { proveedor_create();       });
    $(document).on('click', '#proveedor_help',               function() { proveedor_help();         });
    $(document).on('click', '#contacto_create',              function() { contacto_create();        });
    $(document).on('click', '#contacto_view',                function() { contacto_view(this);      });
    $(document).on('click', '#contacto_view_info',           function() { contacto_view_info(this); });
    $(document).on('click', '#contacto_nuevo',               function() { contacto_nuevo();         });
    $(document).on('submit','form[data-remote-proveedor]',   function(e){ proveedor_new(e,this);    });
    $(document).on('submit','form[data-remote-proveedor-n]', function(e){ proveedor_nuevo(e,this);    });
    $(document).on('submit','form[data-remote-contact-n]',   function(e){ contacto_create(e,this);  });
    $(document).on('submit','form[data-remote-contact-e]',   function(e){ contacto_update(e,this);  });
    $(document).on('submit','form[data-remote-proveedor-e]', function(e){ proveedor_update(e,this); });
    $(document).on('submit','form[data-remote-proveedor-ce]', function(e){ proveedor_actualizar(e,this); });

});

function proveedores() {
    $.get( "admin/proveedor/index", function( data ) {
        makeTable(data, 'admin/proveedor/', 'Proveedor');
        $('#example').addClass('tableSelected');
    });
};

function clear_contacto_body() {
    $('.body-contactos').slideUp('slow');
};

function proveedor_nuevo(e,element) {
     form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');

    $.ajax({
        type: "POST",
        url:  "admin/proveedor/_create",
        data: form.serialize(),
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            if (data.success == true)  {
                $(".contenedor_edicion_compras").slideUp('slow');
                $(".contenedor_edicion_compras").removeClass('open_crear')
                $("input[name='proveedor_id']").val(data.proveedor_id);
                $("#proveedor_id").val(data.nombre);
                $(".search-proveedor-info").html('<strong>Direccion:  '+data.direccion+'</strong><br>');
                $(".proveedor-credito").html('Saldo Total: <strong> Q '+data.saldo_total+'</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Saldo Vencido: <strong> Q '+data.saldo_vencido+'</strong>');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
    e.preventDefault();
};

function proveedor_new(e,element) {
    form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');

    $.ajax({
        type: "POST",
        url:  "admin/proveedor/create",
        data: form.serialize(),
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            if (data.success == true)  {
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
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
    e.preventDefault();
    $('input[type=submit]', form).removeAttr('disabled');
};

function proveedor_help() {
    $id = $("input[name='proveedor_id']").val();
    if($id > 0) {
        $.ajax({
            type: "GET",
            url: "admin/proveedor/help",
            data: {id: $id},
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                $('.modal-body').html(data);
                $('.modal-title').text('Informacion del Proveedor');
                $('.bs-modal').modal('show');
                $(".info-contactos-body").toggle('fast');
            }
        });
    }
};

function proveedor_create() {
    $.get( "admin/proveedor/_create", function( data ) {
        if ($(".contenedor_edicion_compras").hasClass('open_crear'))
            $(".contenedor_edicion_compras").removeClass('open_crear')
        else
            $(".contenedor_edicion_compras").addClass('open_crear');;

        if ($(".contenedor_edicion_compras").hasClass('open_actualizar')) {
            $(".contenedor_edicion_compras").removeClass('open_actualizar')
            $(".contenedor_edicion_compras").slideToggle('slow');
        };
        $(".contenedor_edicion_compras").html(data);
        $(".contenedor_edicion_compras").slideToggle('slow');
    });
};

function proveedor_edit() {
    $id = $("input[name='proveedor_id']").val();
    if($id > 0) {
        $.ajax({
            type: "POST",
            url: "admin/proveedor/_edit",
            data: {id: $id},
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                if ($(".contenedor_edicion_compras").hasClass('open_actualizar'))
                    $(".contenedor_edicion_compras").removeClass('open_actualizar')
                else
                    $(".contenedor_edicion_compras").addClass('open_actualizar');;

                if ($(".contenedor_edicion_compras").hasClass('open_crear')) {
                    $(".contenedor_edicion_compras").removeClass('open_crear')
                    $(".contenedor_edicion_compras").slideToggle('slow');
                };
                $(".contenedor_edicion_compras").html(data);
                $(".contenedor_edicion_compras").slideToggle('slow');
            }
        });
    }
};

function contacto_create(e,element) {
    form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');
    formData = form.serialize()+'&proveedor_id='+$("input[name='proveedor_id']").val();
    $.ajax({
        type: "POST",
        url:  "admin/proveedor/contacto_create",
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

function contacto_view(element) {
    $id = $(element).attr('contacto_id');
    $.ajax({
        type: "POST",
        url:  "admin/proveedor/contacto_update",
        data: {id:$id},
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            $('.body-contactos').slideUp('slow',function(){
               $('.body-contactos').html(data);
               $('.body-contactos').slideDown('slow', function() {
               });
           })
        }
    });
};

function contacto_view_info(element) {
    $id = $(element).attr('contacto_id');
    $.ajax({
        type: "POST",
        url:  "admin/proveedor/contacto_info",
        data: {id:$id},
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            $('.contactos-body-'+$id).slideToggle('slow',function(){
                $('.contactos-body-'+$id).html(data);
            });
        }
    });
};

function contacto_nuevo() {
   $.get( "admin/proveedor/contacto_nuevo", function( data ) {
        $('.body-contactos').slideUp('slow',function() {
            $('.body-contactos').html(data);
            $('.body-contactos').slideDown('slow', function() {
            });
        });
    });
};

function contacto_update(e,element) {
    form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');

    $.ajax({
        type: "POST",
        url:  "admin/proveedor/contacto_update",
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

function proveedor_update(e,element)
{
    form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');

    $.ajax({
        type: "POST",
        url:  "admin/proveedor/edit",
        data: form.serialize(),
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            if (data == 'success') {
                msg.success('Proveedor Actualizado..!', 'Listo!');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
    e.preventDefault();
    $('input[type=submit]', form).removeAttr('disabled');
};

function proveedor_actualizar(e,element)
{
    form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');

    $.ajax({
        type: "POST",
        url:  "admin/proveedor/_edit",
        data: form.serialize(),
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            if (data.success == true ) {
                msg.success('Proveedor Actualizado..!', 'Listo!');
                $(".contenedor_edicion_compras").slideUp('slow');
                $(".contenedor_edicion_compras").removeClass('open_actualizar')
                $("input[name='proveedor_id']").val(data.proveedor_id);
                $("#proveedor_id").val(data.nombre);
                $(".search-proveedor-info").html('<strong>Direccion:  '+data.direccion+'</strong><br>');
                $(".proveedor-credito").html('Saldo Total: <strong> Q '+data.saldo_total+'</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Saldo Vencido: <strong> Q '+data.saldo_vencido+'</strong>');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
    e.preventDefault();
    $('input[type=submit]', form).removeAttr('disabled');
};

function proveedor_contacto_delete(element,proveedor_contacto_id)
{
    $.confirm({
        confirm: function(button) {
            $.ajax({
                type: "POST",
                url:  "admin/proveedor/contacto_delete",
                data: {proveedor_contacto_id:proveedor_contacto_id},
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

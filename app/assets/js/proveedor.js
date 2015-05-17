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
    $(document).on('submit','form[data-remote-contact-n]',   function(e){ contacto_create(e,this);  });
    $(document).on('submit','form[data-remote-contact-e]',   function(e){ contacto_update(e,this);  });
    $(document).on('submit','form[data-remote-proveedor-e]', function(e){ proveedor_update(e,this); });

});

function proveedores() {
    $.get( "admin/proveedor/index", function( data ) {
        makeTable(data, 'admin/proveedor/', 'Proveedor');
    });
};

function clear_contacto_body()
{
    $('.body-contactos').slideUp('slow');
}

function proveedor_new(e,element)
{
    form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');

    $.ajax({
            type: "POST",
            url:  "admin/proveedor/create",
            data: form.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                if (data.success == true) 
                {
                    $('.form-footer', form).hide();
                    $('.proveedor-body').html(data.contacto);
                    msg.success('Proveedor Creado..!', 'Listo!');
                }
                else
                {
                    msg.warning(data, 'Advertencia!');
                }
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });

    e.preventDefault();
    $('input[type=submit]', form).removeAttr('disabled');
}

function proveedor_help() {
    $id = $("input[name='proveedor_id']").val();
    if($id > 0)
    {
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
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }
};
 
function proveedor_create() {
    $.get( "admin/proveedor/create", function( data ) {
        $('.modal-body').html(data);
        $('.modal-title').text('Crear Proveedor');
        $('.bs-modal').modal('show');
    });
};


function proveedor_edit() {

    $id = $("input[name='proveedor_id']").val();
    if($id > 0)
    {
        $.ajax({
            type: "POST",
            url: "admin/proveedor/edit",
            data: {id: $id},
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                $('.modal-body').html(data);
                $('.modal-title').text('Editar proveedor');
                $('.bs-modal').modal('show');
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }
};

function contacto_create(e,element)
{
     form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');
        formData = form.serialize()+'&proveedor_id='+$("input[name='proveedor_id']").val();
        $.ajax({
            type: "POST",
            url:  "admin/proveedor/contacto_create",
            data: formData,
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                if (data.success == true) 
                {
                    $('.body-contactos').slideUp('slow');
                    $('.body-contactos').html('');
                    $('.contacto_select').html(data.lista);
                    form.trigger('reset');
                    msg.success('Contacto Creado..!', 'Listo!');
                }
                else
                {
                    msg.warning(data, 'Advertencia!');
                }
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });

     e.preventDefault();
    $('input[type=submit]', form).removeAttr('disabled');
}

function contacto_view(element)
{
    $id = $("select[name='contacto_id']").val();
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
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
}

function contacto_view_info(element)
{
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
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
}

function contacto_nuevo()
{
     $.get( "admin/proveedor/contacto_nuevo", function( data ) {

        $('.body-contactos').slideUp('slow',function(){
            $('.body-contactos').html(data);
            $('.body-contactos').slideDown('slow', function() {
                
            });
        });
    });
}

function contacto_update(e,element)
{
     form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');

        $.ajax({
            type: "POST",
            url:  "admin/proveedor/contacto_update",
            data: form.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                if (data.success == true) 
                {
                    $('.body-contactos').slideUp('slow');
                    $('.body-contactos').html('');
                    $('.contacto_select').html(data.lista);
                    form.trigger('reset');
                    msg.success('Contacto Actualizado..!', 'Listo!');
                }
                else
                {
                    msg.warning(data, 'Advertencia!');
                }
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });

     e.preventDefault();
    $('input[type=submit]', form).removeAttr('disabled');
}

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
                if (data == 'success') 
                {
                    msg.success('Proveedor Actualizado..!', 'Listo!');
                }
                else
                {
                    msg.warning(data, 'Advertencia!');
                }
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });

     e.preventDefault();
    $('input[type=submit]', form).removeAttr('disabled');
}

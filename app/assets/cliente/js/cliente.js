$(function() {
    $(document).on('click', '#clientes_table',              function() { clientes_table();                 });
    $(document).on('click', '#cliente_edit',                function() { cliente_edit();                   });
    $(document).on('click', '#cliente_create',              function() { cliente_create();                 });
    $(document).on('click', '#cliente_contacto_view_info',  function() { cliente_contacto_view_info(this); });
    $(document).on('click', '#cliente_contacto_view',       function() { cliente_contacto_view(this);      });
    $(document).on('click', '#cliente_contacto_nuevo',      function() { cliente_contacto_nuevo();         });
    $(document).on('click', '#cliente_help',                function() { cliente_help();                   });
    $(document).on('submit','form[data-remote-cliente]',    function(e){ cliente_new(e,this);              });
    $(document).on('submit','form[data-remote-contact-cn]', function(e){ cliente_contacto_create(e,this);  });
    $(document).on('submit','form[data-remote-contact-ce]', function(e){ cliente_contacto_update(e,this);  });
    $(document).on('submit','form[data-remote-cliente-e]',  function(e){ cliente_update(e,this);           });
});

function clientes_table() {
    $.get( "user/cliente/index", function( data ) {
        makeTable(data, 'user/cliente/', 'Clientes');
    });
};

function cliente_create() {

    $.get( "user/cliente/create", function( data ) {
        $('.modal-body').html(data);
        $('.modal-title').text('Crear cliente');
        $('.bs-modal').modal('show');
    });
};

function cliente_contacto_view_info(element)
{
    $id = $(element).attr('contacto_id');
     $.ajax({
            type: "POST",
            url:  "user/cliente/contacto_info",
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

function cliente_edit() {

    $id = $("input[name='cliente_id']").val();
    if($id > 0)
    {
        $.ajax({
            type: "POST",
            url: "user/cliente/edit",
            data: {id: $id},
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                $('.modal-body').html(data);
                $('.modal-title').text('Editar cliente');
                $('.bs-modal').modal('show');
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }
};


function cliente_new(e,element)
{
    form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');

    $.ajax({
            type: "POST",
            url:  "user/cliente/create",
            data: form.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                if (data.success == true) 
                {
                    $('.bs-modal').slideUp('slow' , function () {
                        msg.success('Cliente Creado..!', 'Listo!');
                        $('.bs-modal').modal('hide');
                    });
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

function cliente_contacto_nuevo()
{
     $.get( "user/cliente/contacto_nuevo", function( data ) {

        $('.body-contactos').slideUp('slow',function(){
            $('.body-contactos').html(data);
            $('.body-contactos').slideDown('slow', function() {
                
            });
        });
    });
}

function cliente_update(e,element)
{
     form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');

        $.ajax({
            type: "POST",
            url:  "user/cliente/edit",
            data: form.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                if (data == 'success') 
                {
                    msg.success('Cliente Actualizado..!', 'Listo!');
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


function cliente_contacto_create(e,element)
{
     form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');
        formData = form.serialize()+'& cliente_id='+$("input[name='cliente_id']").val();
        $.ajax({
            type: "POST",
            url:  "user/cliente/contacto_create",
            data: formData,
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                if (data.success == true) 
                {
                    $('.body-contactos').slideUp('slow');
                    $('.body-contactos').html('');
                    $('.contactos-lista').html(data.lista);
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


function cliente_contacto_view(element)
{
    $id = $(element).attr('contacto_id');
     $.ajax({
            type: "POST",
            url:  "user/cliente/contacto_update",
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

function cliente_contacto_update(e,element)
{
     form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');

        $.ajax({
            type: "POST",
            url:  "user/cliente/contacto_update",
            data: form.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                if (data.success == true) 
                {
                    $('.body-contactos').slideUp('slow');
                    $('.body-contactos').html('');
                    $('.contactos-lista').html(data.lista);
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

function cliente_help() {
    $id = $("input[name='cliente_id']").val();
    if($id > 0)
    {
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
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }
};

function clear_contacto_body()
{
    $('.body-contactos').slideUp('slow');
}


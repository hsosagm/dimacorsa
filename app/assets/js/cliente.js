$(function() {
    $(document).on('click', '#cliente_edit', function() { cliente_edit(); });
    $(document).on('click', '#cliente_create', function() { cliente_create(); });
});


function cliente_create() {

    $.get( "user/cliente/create", function( data ) {
        $('.modal-body').html(data);
        $('.modal-title').text('Crear cliente');
        $('.bs-modal').modal('show');
    });
};


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
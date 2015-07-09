$(function() {
    $(document).on('click', '#f_adelanto', function(){ f_adelanto(this); });
    $(document).on('click', '#delete_adelanto', function(){ delete_adelanto(this); });
});

function f_adelanto() {
    $.get( "user/adelantos/create", function( data ) {
        $('.modal-body').html(data);
        $('.modal-title').text('Ingresar Adelanto');
        $('.bs-modal').modal('show');
    });
}

function delete_adelanto() {
    $id = $("input[name='adelanto_id']").val();;
    $url = "user/adelantos/delete";
    
    $.confirm({
        confirm: function() {
            $.ajax({
                type: "POST",
                url: $url,
                data: { id: $id },
                contentType: 'application/x-www-form-urlencoded',
                success: function (data, text) {
                    if (data == 'success') {
                        msg.success('Adelanto eliminado', 'Listo!')
                       $('.bs-modal').modal('hide');
                    } 
                    else {
                        msg.warning('Hubo un erro al tratar de eliminar', 'Advertencia!')
                    }
                },
                error: function (request, status, error) {
                    msg.error(request.responseText, 'Error!')
                }
            });
        }
    });
};

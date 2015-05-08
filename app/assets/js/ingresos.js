
$(function() {
    $(document).on('click', '#f_ingreso', function(){ f_ingreso(this); });
    $(document).on('click', '#delete_ingreso', function(){ delete_ingreso(this); });
});


function f_ingreso() {
    $.get( "user/ingresos/create", function( data ) {
        $('.modal-body').html(data);
        $('.modal-title').text('Ingresar Ingreso');
        $('.bs-modal').modal('show');
    });
}

function delete_ingreso() {
    $id = $("input[name='ingreso_id']").val();;
    $url = "user/ingresos/delete";
    
    $.confirm({
        confirm: function(){
            $.ajax({
                type: "POST",
                url: $url,
                data: { id: $id },
                contentType: 'application/x-www-form-urlencoded',
                success: function (data, text) {
                    if (data == 'success') {
                        msg.success('Ingreso eliminado', 'Listo!')
                       $('.bs-modal').modal('hide');
                    } else 
                    {
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

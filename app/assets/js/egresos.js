
$(function() {
    $(document).on('click', '#delete_egreso', function(){ delete_egreso(this); });
});

function f_egreso() {
    $.get( "user/egresos/create", function( data ) {
        $('.modal-body').html(data);
        $('.modal-title').text('Ingresar egreso');
        $('.bs-modal').modal('show');
    });
};

function delete_egreso() {
    $id = $("input[name='egreso_id']").val();;
    $url = "user/egresos/delete_master";

    $.confirm({
        confirm: function(){
            $.ajax({
                type: "POST",
                url: $url,
                data: { id: $id },
                contentType: 'application/x-www-form-urlencoded',
                success: function (data, text) {
                    if (data == 'success') {
                        msg.success('Egreso eliminado', 'Listo!')
                       $('.bs-modal').modal('hide');
                    }
                    else {
                        msg.warning('Hubo un erro al tratar de eliminar', 'Advertencia!')
                    }
                }
            });
        }
    });
};

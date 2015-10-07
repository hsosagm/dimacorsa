$(function() {
    $(document).on('click', '#delete_gasto', function(){ delete_gasto(this); });
});


function f_gastos() {
    $.get( "user/gastos/create", function( data ) {
        $('.modal-body').html(data);
        $('.modal-title').text('Ingresar Gasto');
        $('.bs-modal').modal('show');
    });
};

function delete_gasto() {
    $id = $("input[name='gasto_id']").val();;
    $url = "user/gastos/delete_master";

    $.confirm({
        confirm: function(){
            $.ajax({
                type: "POST",
                url: $url,
                data: { id: $id },
                contentType: 'application/x-www-form-urlencoded',
                success: function (data, text) {
                    if ($.trim(data) == 'success') {
                        msg.success('Gasto eliminado', 'Listo!')
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

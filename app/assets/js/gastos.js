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
    $.confirm({
        confirm: function() {
            $.ajax({
                type: "POST",
                url: "user/gastos/delete_master",
                data: { id: $("input[name='gasto_id']").val() },
            }).done(function(data) {
                if (data == 'success') {
                    msg.success('Gasto eliminado', 'Listo!');
                   return $('.bs-modal').modal('hide');
                }

                msg.warning('Hubo un erro al tratar de eliminar', 'Advertencia!');
            });
        }
    });
};
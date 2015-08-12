$(function() {
    $(document).on('click', '#delete_soporte', function(){ delete_soporte(this); });
});


function f_soporte() {
    $.get( "user/soporte/create", function( data ) {
        $('.modal-body').html(data);
        $('.modal-title').text('Ingresar soporte');
        $('.bs-modal').modal('show');
    });
}

function delete_soporte() {
    $id = $("input[name='soporte_id']").val();;
    $url = "user/soporte/delete_master";

    $.confirm({
        confirm: function(){
            $.ajax({
                type: "POST",
                url: $url,
                data: { id: $id },
                contentType: 'application/x-www-form-urlencoded',
                success: function (data, text) {
                    if (data == 'success') {
                        msg.success('Soporte eliminado', 'Listo!')
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

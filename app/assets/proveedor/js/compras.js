
$(function() {
    $(document).on('click', '.master_opcion_abonar', function() { master_opcion_abonar(this);});
});

function master_opcion_abonar(element)
{
	$(element).attr('disabled', 'disabled');
	compra_id = $(element).attr('id');
    proveedor_id = $("input[name='proveedor_id']").val();

    $.ajax({
        type: 'GET',
        url: 'admin/proveedor/AbonarCompra',
        data: { compra_id: compra_id , proveedor_id:proveedor_id},
        success: function (data) {
            if (data.success == true)
            {   
                $('.modal-body').html(data.detalle);
                $('.modal-title').text('Abonar a Proveedor');
                $('.bs-modal').modal('show');
            }
            else
            { 
                msg.warning(data, 'Advertencia!');
            }
        },
        error: function(errors){
            msg.error('Hubo un error, intentelo de nuevo', 'Advertencia!');
        }
    });
     $(element).removeAttr('disabled');
    return false;
}

function EliminarDetalleAbono(id , compra_id)
{
    var url = "admin/proveedor/EliminarDetalleAbono";

    $.ajax({
        type: 'POST',
        url: url,
        data: { id: id , compra_id: compra_id },
        success: function (data) {
            if (data.success == true) 
            {
                msg.success('Eliminado', 'Listo!');
                $('.modal-body').html(data.detalle);
                $('.modal-title').text('Abonar a Proveedor');
                $('.bs-modal').modal('show');
            }
            else
            {
                msg.warning(data, 'Advertencia!');
            }
        },
        error: function(errors){
            msg.error('Hubo un error, intentelo de nuevo', 'Advertencia!');
        }
    });
    
}

function EliminarAbonoCompra(id)
{
    var url = "admin/proveedor/EliminarAbonoCompra";
    $.confirm({
        confirm: function(){
            $.ajax({
                type: 'POST',
                url: url,
                data: { id: id },
                success: function (data) {
                    if (data == "success")
                    {
                        msg.success('Eliminado', 'Listo!');
                        $('.bs-modal').modal('hide');
                    }
                    else
                    {
                        msg.warning(data, 'Advertencia!');
                    }
                },
                error: function(errors){
                    msg.error('Hubo un error, intentelo de nuevo', 'Advertencia!');
                }
            });
        }
    });
}


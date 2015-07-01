
$(function() {
    $(document).on('click', '.master_opcion_abonar', function() { master_opcion_abonar(this);});
});

function AbonarCompraPendienteDePago(element)
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


function showPaymentsDetail(e){

 if ($(e).hasClass("hide_detail")) 
    {
        $(e).removeClass('hide_detail');
        $('.subtable').fadeOut('slow');
    } 
    else 
    {
        $('.hide_detail').removeClass('hide_detail');

        if ( $( ".subtable" ).length )
        {
            $('.subtable').fadeOut('slow', function(){
                getPaymentsDetail(e);
            })
        }
        else
        {
            getPaymentsDetail(e);
        }
    }
}

function getPaymentsDetail(e)
{
    $id = $(e).closest('tr').attr('id');

    $('.subtable').remove();
    var nTr = $(e).parents('tr')[0];
    $(e).addClass('hide_detail');
    $(nTr).after("<tr class='subtable'> <td colspan=8><div class='grid_detalle_factura'></div></td></tr>");
    $('.subtable').addClass('hide_detail');

    $.ajax({
        type: 'GET',
        url: "admin/compras/showPaymentsDetail",
        data: { id: $id},
        success: function (data) {
            if (data.success == true)
            {
                $('.grid_detalle_factura').html(data.table);
                $(nTr).next('.subtable').fadeIn('slow');
                $(e).addClass('hide_detail');
            }
            else
            {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}

function showPurchasesDetail(e) {

    if ($(e).hasClass("hide_detail")) 
    {
        $(e).removeClass('hide_detail');
        $('.subtable').fadeOut('slow');
    } 
    else 
    {
        $('.hide_detail').removeClass('hide_detail');

        if ( $( ".subtable" ).length )
        {
            $('.subtable').fadeOut('slow', function(){
                getPurchaseDetail(e);
            })
        }
        else
        {
            getPurchaseDetail(e);
        }
    }
}


function getPurchaseDetail(e) {

    $id = $(e).closest('tr').attr('id');

    $('.subtable').remove();
    var nTr = $(e).parents('tr')[0];
    $(e).addClass('hide_detail');
    $(nTr).after("<tr class='subtable'> <td colspan=8><div class='grid_detalle_factura'></div></td></tr>");
    $('.subtable').addClass('hide_detail');

    $.ajax({
        type: 'GET',
        url: "admin/compras/showPurchaseDetail",
        data: { id: $id},
        success: function (data) {
            if (data.success == true)
            {
                $('.grid_detalle_factura').html(data.table);
                $(nTr).next('.subtable').fadeIn('slow');
                $(e).addClass('hide_detail');
            }
            else
            {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}

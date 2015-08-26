
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

/*
    usada de esta manera para mostrar la tabla al nomas cargar el modulo de proveedores
*/
getComprasPedientesDePago();

/***************************/

function getComprasPedientesDePago()
{
   $.ajax({
        type: 'GET',
        url: "admin/compras/getComprasPedientesDePago",
        success: function (data) {
            if (data.success == true) {
                vm.proveedor_id = '';
                $("#infoSaldosTotales").html(data.infoSaldosTotales);
                setTimeout(function() {
                    $('#example_length').prependTo("#table_length");
                    $('.dt-container').show();
                    $('#iSearch').keyup(function() {
                        $('#example').dataTable().fnFilter( $(this).val() );
                    })
                }, 300);
                
                $("#iSearch").val("");
                $("#iSearch").unbind();
                $('.table').html("");
                $("#table_length").html("");
                $( ".DTTT" ).html("");
                $('.dt-panel').show();
                ocultar_capas();
                $('.table').html(data.table);
                $('#example').DataTable( {
                    "order": [[ 3, "desc" ]]
                } );
                return $("#iSearch").focus();
            }
            msg.warning('Hubo un error intentelo de nuevo', 'Advertencia!');
        }
    }); 
}

global_proveedor_id = 0;
function ComprasPendientesPorProveedor(e, id)
{
    global_proveedor_id = id;
    if ($(e).hasClass("hide_detail"))  {
        $(e).removeClass('hide_detail');
        $('.subtable').fadeOut('slow');
    } 
    else {
        $('.hide_detail').removeClass('hide_detail');

        if ( $( ".subtable" ).length ) {
            $('.subtable').fadeOut('slow', function(){
                getComprasPendientesPorProveedor(e, 1 , null);
            })
        }
        else {
            getComprasPendientesPorProveedor(e, 1 , null);
        }
    }
}

function getComprasPendientesPorProveedor(e , page , sSearch) {
    $('.subtable').remove();
    var nTr = $(e).parents('tr')[0];
    $(e).addClass('hide_detail');
    $(nTr).after("<tr class='subtable'> <td colspan=6><div class='grid_detalle_factura'></div></td></tr>");
    $('.subtable').addClass('hide_detail');

    $.ajax({
        type: 'GET',
        url: "admin/compras/getComprasPendientesPorProveedor?page=" + page,
        data: { proveedor_id: global_proveedor_id ,  sSearch:sSearch},
        success: function (data) {
            if (data.success == true) {
                $('.grid_detalle_factura').html(data.table);
                $(nTr).next('.subtable').fadeIn('slow');
                $(e).addClass('hide_detail');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}

function getComprasPendientesPorProveedorPaginacion(page , sSearch) {
    $.ajax({
        type: 'GET',
        url: "admin/compras/getComprasPendientesPorProveedor?page=" + page,
        data: { proveedor_id: global_proveedor_id , sSearch:sSearch},
        success: function (data) {
            if (data.success == true) {
                $('.grid_detalle_factura').html(data.table);
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}

$(document).on('click', '.pagination_compras_por_proveedor a', function (e) {
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    getComprasPendientesPorProveedorPaginacion(page,null);
    return false;
});

function getCompraConDetalle(e, compra_id)
{
    $.ajax({
        type: 'GET',
        url: "admin/compras/getCompraConDetalle",
        data: {compra_id: compra_id },
        success: function (data) {
            if (data.success == true) {
                $('#modal-body-detalle').html(data.table);
                $('#modal-title-detalle').text( 'Detalle de Venta' );
                $('#bs-modal-detalle').modal('show');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}

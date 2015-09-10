
function showPaymentsDetail (e){

    if ($(e).hasClass("hide_detail")) {
        $(e).removeClass('hide_detail');
        $('.subtable').fadeOut('slow');
    } 
    else {
        $('.hide_detail').removeClass('hide_detail');

        if ( $( ".subtable" ).length ) {
            $('.subtable').fadeOut('slow', function(){
                getPaymentsDetail(e);
            })
        }
        else
            getPaymentsDetail(e);
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
            if (data.success == true) {
                $('.grid_detalle_factura').html(data.table);
                $(nTr).next('.subtable').fadeIn('slow');
                $(e).addClass('hide_detail');
            }
            else
                msg.warning(data, 'Advertencia!');
        }
    });
}

function showPurchasesDetail(e) {
    if ($(e).hasClass("hide_detail"))  {
        $(e).removeClass('hide_detail');
        $('.subtable').fadeOut('slow');
    } 
    else  {
        $('.hide_detail').removeClass('hide_detail');
        if ( $( ".subtable" ).length ) {
            $('.subtable').fadeOut('slow', function(){
                getPurchaseDetail(e);
            })
        }
        else 
            getPurchaseDetail(e);
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
            if (data.success == true) {
                $('.grid_detalle_factura').html(data.table);
                $(nTr).next('.subtable').fadeIn('slow');
                $(e).addClass('hide_detail');
            }
            else
                msg.warning(data, 'Advertencia!');
        }
    });
}

$(document).on('click', '.pagination_compras_por_proveedor a', function (e) {
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    vm.getComprasPendientesPorProveedorPaginacion(page,null);
    return false;
});


$(document).on('click', '.pagination_seleccion a', function (e) {
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    vm.GetPurchasesForPaymentsBySelection(page,null);
});

$(document).on("click", ".SST .select", function() {
    if ( $(this).closest("tr").hasClass( "row_selected" ) )   {
        $(this).closest("tr").removeClass("row_selected");
        total = parseFloat($('.total_selected').val()) - parseFloat($(this).attr('total'));
         $("#total_selected").html(accounting.formatMoney(total,"", 2, ",", "."));
        $('.total_selected').val(total);
    }

    else {
        $(this).closest("tr").addClass('row_selected');
        total = parseFloat($(this).attr('total')) + parseFloat($('.total_selected').val());
        $("#total_selected").html(accounting.formatMoney(total,"", 2, ",", "."));
        $('.total_selected').val(total);
    }
});

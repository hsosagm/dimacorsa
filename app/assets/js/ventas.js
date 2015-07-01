$(function() {
    $(document).on('click', '.f_ven_op', function(){ f_ven_op(this); });
});

function f_ven_op() {
    $.get( "user/ventas/create", function( data ) {
        $('.panel-title').text('Formulario Ventas');
        $(".forms").html(data);
        $(".dt-container").hide();
        $(".form-panel").show();
    });
}

function RemoveSale() {

    $.confirm({
        confirm: function() {
			$.ajax({
				type: 'POST',
				url: 'user/ventas/RemoveSale',
				data: {id: $("input[name=venta_id]").val()},
				success: function (data) {
		            if (data.success == true)
		            {
		                msg.success('Venta eliminada', 'Listo!');
		                $(".form-panel").hide();
		            }
		            else
		            {
		                msg.warning(data, 'Advertencia!');
		            }
					$(".forms").html(data); // ??
				},
				error: function(errors) {
					msg.error('Hubo un error, intentelo de nuevo', 'Advertencia!');
				}
			});
        }
    }); 
}

function OpenModalSalesPayments($venta_id)
{
    $.ajax({
        type: 'GET',
        url: "user/ventas/ModalSalesPayments",
        data: { venta_id: $venta_id },
        success: function (data) {
	        if (data.success == true) 
	        {
	            $('.modal-body').html(data.detalle);
	            $('.modal-title').text('Ingreso de Pagos');
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


$(document).on('submit', 'form[data-remote-sales-payment]', function(e) {

    var form = $(this);

    $('input[type=submit]', form).prop('disabled', true);

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function (data) {
  
                if (data.success == true)
                {
                    msg.success('Pago ingresado', 'Listo!');
                    $('.modal-body').html(data.detalle);
                }
                else
                {
                    msg.warning(data, 'Advertencia!');
                    $('input[type=submit]', form).prop('disabled', false);
                }
            }

        });

    e.preventDefault();
});


function RemoveSalePayment($id, $venta_id) {

    $.ajax({
        type: "POST",
        url: "user/ventas/RemoveSalePayment",
        data: { id:$id, venta_id:$venta_id },
        success: function (data) {
            if (data.success == true)
            {
                msg.success('Pago eliminado', 'Listo!');
                $('.modal-body').html(data.detalle);
                $('.modal-title').text('Ingreso de Pagos');
            }
            else
            {
                msg.warning(data, 'Advertencia!');
            }
        }

    });
}


function FinalizeSale(element, $id) {

    $(element).prop("disabled", true);

    $.ajax({
        type: 'POST',
        url: "user/ventas/FinalizeSale",
        data: { venta_id: $id},
        success: function (data) {
            if (data.success == true)
            {
                $('.bs-modal').modal('hide');
                msg.success('Venta finalizada', 'Listo!');
                $(".form-panel").hide();
            }
            else
            {
                msg.warning(data, 'Advertencia!');
                $(element).prop("disabled", false);
            }
        }
    });
}


function OpenTableSalesOfDay(e)
{
    $(e).prop("disabled", true);

    $.ajax({
        type: 'GET',
        url: "user/ventas/OpenTableSalesOfDay",
        success: function (data) {
            if (data.success == true)
            {
                makeTable(data.table, '', 'Ventas del Dia');
            }
            else
            {
                msg.warning('Hubo un error intentelo de nuevo', 'Advertencia!');
            }
        }
    }); 
}


function showSalesDetail(e) {

    if ($(e).hasClass("hide_detail")) 
    {
        $(e).removeClass('hide_detail');
        $('.subtable').hide();
    } 
    else 
    {
        $('.hide_detail').removeClass('hide_detail');

        if ( $( ".subtable" ).length )
        {
            $('.subtable').fadeOut('slow', function(){
                getSalesDetail(e);
            })
        }
        else
        {
            getSalesDetail(e);
        }
    }
}


function getSalesDetail(e) {

    $id = $(e).closest('tr').attr('id');
    $('.subtable').remove();
    var nTr = $(e).parents('tr')[0];
    $(e).addClass('hide_detail');
    $(nTr).after("<tr class='subtable'> <td colspan=7><div class='grid_detalle_factura'></div></td></tr>");
    $('.subtable').addClass('hide_detail');

    $.ajax({
        type: 'GET',
        url: "user/ventas/showSalesDetail",
        data: { venta_id: $id},
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


function openSale(e)
{
    $id = $(e).closest('tr').attr('id');

    $.ajax({
        type: 'GET',
        url: "user/ventas/openSale",
        data: { venta_id: $id},
        success: function (data) {
            if (data.success == true)
            {
                $('.panel-title').text('Formulario Ventas');
                $(".forms").html(data.table);
                $(".dt-container").hide();
                $(".form-panel").show();
            }
            else
            {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}


function CreditSales(e)
{
    $(e).prop("disabled", true);

    $.ajax({
        type: 'GET',
        url: "user/ventas/getCreditSales",
        success: function (data) {
            if (data.success == true)
            {
                generate_dt_local(data.table);
                msg.success('Listo', 'Ok!');
            }
            else
            {
                msg.warning('Hubo un error intentelo de nuevo', 'Advertencia!');
            }
        }
    }); 
}


function ImprimirVentaModal(e,id)
{
    $.ajax({
        type: 'GET',
        url: "user/ventas/ImprimirVentaModal",
        data: { venta_id: id},
        success: function (data) {
            if (data.success == true)
            {
                $('.modal-body').html(data.form);
                $('.modal-title').text('Imprimir Venta');
                $('.bs-modal').modal('show');
            }

            else
            {
                msg.warning('Hubo un error intentelo de nuevo', 'Advertencia!');
            }
        }
    });       
}

var FacturaWindow;

function ImprimirFacturaVenta(e,id)
{
    FacturaWindow = open('user/ventas/ImprimirFacturaVenta/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');


}

function ImprimirFacturaVenta_dt(e,user)
{
    id = $(e).closest('tr').attr('id');
    var md5 = $.md5('encript'+user); 

     FacturaWindow = open('user/ventas/ImprimirFacturaVenta/dt/'+md5+'/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');

}

function ImprimirGarantiaVenta(e,id)
{
     FacturaWindow = open('user/ventas/ImprimirGarantiaVenta/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

function ImprimirGarantiaVenta_dt(e,user)
{
    id = $(e).closest('tr').attr('id');
    var md5 = $.md5('encript'+user); 

     FacturaWindow = open('user/ventas/ImprimirGarantiaVenta/dt/'+md5+'/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');

}

function OpenModalSalesItemSerials(e)
{
     $serial = $("input[name='serials']").val();
    $.ajax({
        type: "GET",
        url: "user/OpenModalSalesItemSerials",
        data: {serial: $serial},
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            $('.modal-body').html(data);
            $('.modal-title').text('Seriales');
            $('.bs-modal').modal('show');
        },
        error: function (request, status, error) {
            alert(request.responseText);
        }
    });
}

function CerrarVentana(Windows) 
{
    Windows.close();              
}
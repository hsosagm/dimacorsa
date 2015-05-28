$(function() {
    $(document).on('click', '.f_ven_op', function(){ f_ven_op(this); });
    $(document).on('click', '#RemoveSale', function(){ RemoveSale(this); });
    $(document).on('click', '#RemoveSaleItem', function(){ RemoveSaleItem(this); });
    $(document).on('click', '#OpenModalSalesPayments', function(){ OpenModalSalesPayments(this); });
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

function RemoveSaleItem(element, $id, $producto_id, $cantidad) {

    $.confirm({
        confirm: function() {
			$.ajax({
				type: 'POST',
				url: 'user/ventas/RemoveSaleItem',
				data: { id:$id, producto_id:$producto_id, cantidad:$cantidad },
				success: function (data) {
		            if (data.success == true)
		            {
		                msg.success('Producto eliminado', 'Listo!');
	                    $(element).closest("tr").hide("slow");
		            }
		            else
		            {
		                msg.warning(data, 'Advertencia!');
		            }
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

    $button = $('button[type=submit]', this);

    $button.attr('disabled', 'disabled');

    var form = $(this);

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
                    $button.removeAttr('disabled');
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
        data: { id: $id},
        success: function (data) {
            if (data.success == true)
            {
                $('.bs-modal').modal('hide');
                msg.success('Venta finalizada', 'Listo!');
                $(element).prop("disabled", false);
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


function showSalesDetail(e) {

    $id = $(e).closest('tr').attr('id');
    $('.subtable').remove();
    var nTr = $(e).parents('tr')[0];
    $(nTr).after("<tr class='subtable hide'> <td colspan=8><div class='grid_detalle_factura'></div></td></tr>");

    $.ajax({
        type: 'GET',
        url: "user/ventas/showSalesDetail",
        data: { id: $id},
        success: function (data) {
            $('.grid_detalle_factura').html(data);
            $(nTr).next('.subtable').slideDown('slow'); 
        }
    });
}
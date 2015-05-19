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
        url: "user/ventas/OpenModalSalesPayments",
        data: { venta_id: $venta_id },
        success: function (data) {
	        if (data.success == true) 
	        {
	            $('.modal-body').html(data.detalle);
	            $('.modal-title').text('Ingresar Tipos');
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
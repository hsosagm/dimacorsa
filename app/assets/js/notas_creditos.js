function getFormSeleccionarTipoDeNotaDeCredito() {
    $.ajax({
        type: 'GET',
        url: 'user/notaDeCredito/getFormSeleccionarTipoDeNotaDeCredito',
    }).done(function(data) {
        $('.modal-body').html(data);
        $('.modal-title').text( 'Nota de credito' );
        $('.bs-modal').modal('show');
    });
};


function postFormSeleccionarTipoDeNotaDeCredito() {
    if ( $('input[name="nota_credito"]:checked').val() == 'notaDeCreditoPorDevolucion' ) {
        $.ajax({
            type: 'GET',
            url: 'user/ventas/devoluciones/getVentasParaDevoluciones',
        }).done(function(data) {
            if (data.success == true)
            {
                $('.bs-modal').modal('hide');
                clean_panel();
                $('#graph_container').show();
                return $('#graph_container').html(data.view);
            }
            return msg.warning(data, 'Advertencia!');
        });

        return;
    }

    $.ajax({
        type: "GET",
        url: '/user/notaDeCredito/create',
    }).done(function(data) {
        $('.modal-body').html(data);
        $('.modal-title').text( 'Crear Nota de Credito');
        $('.bs-modal').modal('show');
    });
};


function getConsultarNotasDeCreditoCliente(e, cliente_id){
	$.ajax({
		type: "GET",
		url: 'user/consulta/getConsultarNotasDeCreditoCliente',
		data:{cliente_id: cliente_id},
	}).done(function(data) {
		if (data.success == true)
		{
			makeTable(data, '/user/notaDeCredito/', '');
			return $(".dt-container").attr('z-index', '1200');
		}
		msg.warning(data, 'Advertencia!');
	});
};

function EliminarDetalleNotaCreditoAdelanto(e, adelanto_nota_credito_id) {
    $(e).prop('disabled', true)

    $.ajax({
        type: "POST",
        url: 'user/notaDeCredito/eliminarDetalle',
        data:{adelanto_nota_credito_id: adelanto_nota_credito_id},
    }).done(function(data) {
        if (data.success == true)
        {
            msg.success('Detalle Eliminado..', 'Listo!');
            return $('.body-detail').html(data.table);
        }
        msg.warning(data, 'Advertencia!');
        $(e).prop('disabled', false)
    });
};

function crearClienteNotaCredito() {
    if ($('.formCrearCliente').attr('status') == 0) {
        $('.formCrearCliente').attr('status', 1);
        $('.formCrearCliente').slideDown('slow');
    }
    else {
        $('.formCrearCliente').attr('status', 0);
        $('.formCrearCliente').slideUp('slow');
    }
    $('.formActualizarCliente').attr('status',0);
    $('.formActualizarCliente').slideUp('slow');
};

function actualizarClienteNotaCredito() {
    if ($('.formActualizarCliente').attr('status') == 0) {
        
        $('.formActualizarCliente').attr('status', 1);
        $('.formActualizarCliente').slideDown('slow');
    }
    else {
        $('.formActualizarCliente').attr('status', 0);
        $('.formActualizarCliente').slideUp('slow');
    }
    $('.formCrearCliente').attr('status',0);
    $('.formCrearCliente').slideUp('slow');
};

function guardarClienteNuevoNotaCredito(e) {
    $(e).prop('disabled', true)

    $.ajax({
        type: "POST",
        url: '/user/cliente/create',
        data: $('#formCrearCliente').serialize(),
    }).done(function(data) {
        if (data.success == true) {
            $('#cliente').val(data.info.nombre+' '+data.info.direccion);
            $('#cliente_id').val(data.info.id);
            $('.notaNotaCredito').focus();
            $('.formCrearCliente').attr('status', 0);
            $('.formCrearCliente').slideUp('slow');
            $('.formCrearCliente').trigger('reset');
            return msg.success('Cliente Guardado..', 'Listo!');
        }

        msg.warning(data, 'Advertencia!');
        $(e).prop('disabled', false)
    });
};

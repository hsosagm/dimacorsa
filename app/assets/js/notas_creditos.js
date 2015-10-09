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

function actualizarClienteNotaCredito(e, opcion) {
    if($('#cliente_id_nota').val() > 0) {
        if ($('.formActualizarCliente').attr('status') == 0) {
            $.ajax({
                type: "GET",
                url: '/user/cliente/_edit',
                data: {cliente_id: $('#cliente_id_nota').val(), opcion:opcion },
            }).done(function(data) {
                if (data.success == true) {
                    $('.formActualizarCliente').html(data.view);
                    $('.formActualizarCliente').attr('status', 1);
                    return $('.formActualizarCliente').slideDown('slow');
                }
                msg.warning(data, 'Advertencia!');
            });
        }
        else {
            $('.formActualizarCliente').attr('status', 0);
            $('.formActualizarCliente').slideUp('slow');
        }
        $('.formCrearCliente').attr('status',0);
        return $('.formCrearCliente').slideUp('slow');
    }

    msg.warning('Seleccione un cliente para modificar..', 'Advertencia!');
};

function ingresarAdelantoMetodoDePago(e) {
    $(e).attr('disabled','disabled');
    var form = $('#adelantoMetodoDePagoForm');
    if (form.attr('status') == 0) {
        form.attr('status', '1');

        $.ajax({
            type: form.attr('method'),
            url:  form.attr('action'),
            data: form.serialize(),
        }).done(function(data) {
            if (data.success == true) {
                $('.body-detail').html(data.table);
                form.trigger('reset');
                form.attr('status', '0');
                return msg.success(form.data('success'), 'Listo!');
            }
            msg.warning(data, 'Advertencia!');
            $(e).removeAttr('disabled');
            form.attr('status', '0');
        });
    }
};

function guardarClienteNuevoNotaCredito(e) {
    $(e).prop('disabled', true)

    $.ajax({
        type: "POST",
        url: '/user/cliente/create',
        data: $('#formCrearCliente').serialize(),
    }).done(function(data) {
        if (data.success == true) {
            $('#cliente_nota').val(data.info.nombre+' '+data.info.direccion);
            $('#cliente_id_nota').val(data.info.id);
            $('.notaNotaCredito').focus();
            $('.formCrearCliente').attr('status', 0);
            $('.formCrearCliente').slideUp('slow');
            $('.formCrearCliente').trigger('reset');
            msg.success('Cliente Guardado..', 'Listo!');
            return data;
        }
        msg.warning(data, 'Advertencia!');
        $(e).prop('disabled', false)
        return data;
    });
};

function guardarClienteActualizadoNotaCredito(e) {
    $(e).prop('disabled', true)
    $.ajax({
        type: "POST",
        url: '/user/cliente/edit',
        data: $('#formEditCliente').serialize(),
    }).done(function(data) {
        if (data.success == true) {
            $('#cliente_nota').val(data.info.nombre+' '+data.info.direccion);
            $('#cliente_id_nota').val(data.info.id);
            $('.notaNotaCredito').focus();
            $('.formActualizarCliente').attr('status', 0);
            $('.formActualizarCliente').slideUp('slow');
            $('.formActualizarCliente').trigger('reset');
            msg.success('Cliente Actualizado..', 'Listo!');
            return data.info;
        }
        msg.warning(data, 'Advertencia!');
        $(e).prop('disabled', false)
        return data;
    });
};

function guardarClienteNuevoDetalleNotaCredito(e) {
    $(e).prop('disabled', true)

    $.ajax({
        type: "POST",
        url: '/user/cliente/create',
        data: $('#formCrearCliente').serialize(),
    }).done(function(data) {
        if (data.success == true) {
            var nombre = data.info.nombre+' '+data.info.direccion;
            $('#cliente_nota').val(nombre);
            $('#cliente_id_nota').val(data.info.id);
            $('.formCrearCliente').attr('status', 0);
            $('.formCrearCliente').slideUp('slow');
            $('.formCrearCliente').trigger('reset');

            $.ajax({
                type: "POST",
                url: '/user/notaDeCredito/updateClienteId',
                data: {cliente_id: data.info.id , nota_credito_id: $("input[name='nota_credito_id']").val() },
            }).done(function(data) {
                if (data.success == true) {
					$(".infoCliente").html(nombre);
                }
            });
            return msg.success('Cliente Guardado..', 'Listo!');
        }
        msg.warning(data, 'Advertencia!');
        $(e).prop('disabled', false)
    });
};

function guardarClienteActualizadoDetalleNotaCredito(e) {
    $(e).prop('disabled', true)
    $.ajax({
        type: "POST",
        url: '/user/cliente/edit',
        data: $('#formEditCliente').serialize(),
    }).done(function(data) {
        if (data.success == true) {
            var nombre = data.info.nombre+' '+data.info.direccion;
            $('#cliente_nota').val(nombre);
            $('#cliente_id_nota').val(data.info.id);
            $('.formActualizarCliente').attr('status', 0);
            $('.formActualizarCliente').slideUp('slow');
            $('.formActualizarCliente').trigger('reset');

            $.ajax({
                type: "POST",
                url: '/user/notaDeCredito/updateClienteId',
                data: {cliente_id: data.info.id , nota_credito_id: $("input[name='nota_credito_id']").val() },
            }).done(function(data) {
                if (data.success == true) {
					$(".infoCliente").html(nombre);
                }
            });

            msg.success('Cliente Actualizado..', 'Listo!');
            return data.info;
        }
        msg.warning(data, 'Advertencia!');
        $(e).prop('disabled', false)
        return data;
    });
};

function eliminarNotaDeCretidoAdelanto(){

}

function imprimirNotaDeCretidoAdelanto(){
    
}

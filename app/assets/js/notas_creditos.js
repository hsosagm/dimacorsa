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
                $(".form-panel").hide();
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
        $('.modal-title').text( 'Crear Nota de credito por delanto');
        $('.bs-modal').modal('show');
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

function guardarClienteNuevoNotaCredito(e) {
    $(e).prop('disabled', true)

    $.ajax({
        type: "POST",
        url: '/user/cliente/create',
        data: $('#formCrearCliente').serialize(),
    }).done(function(data) {
        if (data.success == true) {
            $('#cliente_nota').val(data.info.nombre+' '+data.info.direccion);
            $('.cliente_informacion').html(data.info.nombre+' '+data.info.direccion);
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
            $('.cliente_informacion').html(data.info.nombre+' '+data.info.direccion);
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

function eliminarNotaDeCredito(e, nota_credito_id) {
    $.confirm({
		text: "Esta seguro que desea eliminar la nota de credito?",
		title: "Confirmacion",
		confirm: function(){
            $.ajax({
                type: "POST",
                url: 'admin/notaDeCredito/eliminarNotaDeCredito',
                data: { nota_credito_id: nota_credito_id },
            }).done(function(data) {
                if (data.success) {
                    $('#example').dataTable().fnStandingRedraw();
                    return msg.success('Nota de credito eliminado con exito..', 'Listo!');
                }

                msg.warning(data, 'Advertencia!');
            });
        }
    });
};


function getConsultarNotasDeCreditoCliente(cliente_id, venta_id) {
    $.ajax({
        type: "GET",
        url: 'user/notaDeCredito/getConsultarNotasDeCreditoCliente',
        data: { venta_id: venta_id, cliente_id: cliente_id },
    }).done(function(data) {
        if (data.success) {
            $('#graph_container').html(data.table);
            $("#graph_container").css( "zIndex", 1500);
            return $('#graph_container').show();
        }

        msg.warning(data, 'Advertencia!');
    });
};

function verDetalleNotaDeCredito(e, nota_credito_id) {
     if ($(e).hasClass("hide_detail")) {
        $(e).removeClass('hide_detail');
        $('.subtable').hide();
    }
    else {
        $('.hide_detail').removeClass('hide_detail');

        if ( $( ".subtable" ).length ) {
            $('.subtable').fadeOut('slow', function(){
                getDetalleNotaDeCredito(e, nota_credito_id);
            })
        }
        else {
            getDetalleNotaDeCredito(e, nota_credito_id);
        }
    }
}


function getDetalleNotaDeCredito(e, nota_credito_id) {
    $id = $(e).closest('tr').attr('id');
    $('.subtable').remove();
    var nTr = $(e).parents('tr')[0];
    $(e).addClass('hide_detail');
    $(nTr).after("<tr class='subtable'> <td colspan=6 ><div class='grid_detalle_factura'></div></td></tr>");
    $('.subtable').addClass('hide_detail');

    $.ajax({
        type: "GET",
        url: 'user/notaDeCredito/getDetalleNotaDeCredito',
        data: {nota_credito_id: nota_credito_id},
    }).done(function(data) {
        if (data.success == true)
        {
            $('.grid_detalle_factura').html(data.table);
            $(nTr).next('.subtable').fadeIn('slow');
            return $(e).addClass('hide_detail');
        }
        msg.warning(data, 'Advertencia!');
    });
};

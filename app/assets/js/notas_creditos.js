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
}
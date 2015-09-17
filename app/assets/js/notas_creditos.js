
function crearNotaDeCredito() {
    $.get( '/user/notaDeCredito/create', function( data ) {
        $('.modal-body').html(data);
        $('.modal-title').text( 'Crear Nota de Credito');
        $('.bs-modal').modal('show');
    });
}

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
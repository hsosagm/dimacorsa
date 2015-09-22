function getConsultarCajas(e) {
    $.get( "admin/cajas/getConsultarCajas", function( data ) {
        makeTable(data, '/admin/cajas/', '');
    });
}

function getAsignarCajaUsuario() {
	$.get( '/user/cajas/asignar', function( data ) {
        $('.modal-body').html(data);
        $('.modal-title').text( 'Asignar Caja');
        $('.bs-modal').modal('show');
        $('.modal-header .close').hide();
    });
}

function setAsignarCajaUsuario() {
	$.ajax({
		type: "POST",
		url: '/user/cajas/asignar',
		data:{caja_id: $('.caja_id').val()},
	}).done(function(data) {
		if (data.success == true)
		{
			$('.bs-modal').modal('hide');
        	$('.modal-header .close').show();
        	msg.success('Caja Asignada', 'Listo!')
        	return $('#home').html(data.caja);
		}
		msg.warning(data, 'Advertencia!');
	});
}

function getMovimientosDeCaja() {
	$.ajax({
		type: "POST",
		url: '/user/cajas/getMovimientosDeCaja',
	}).done(function(data) {
		if (data.success == true)
		{
			clean_panel();
        	$('#graph_container').show();
        	return $('#graph_container').html(data.view);
		}
		msg.warning(data, 'Advertencia!');
	});
}

function corteDeCaja() {
	$.get( "user/cajas/corteDeCaja", function( data ) {
    	if ( data.success == true ) {
			$('.modal-body').html(data.form);
			$('.modal-title').text('Cierre del Dia');
			return $('.bs-modal').modal('show');
    	};
	});	
}
function getConsultarCajas(e) {
    $.get( "admin/cajas/getConsultarCajas", function( data ) {
        makeTable(data, '/admin/cajas/', '');
        return $('#example').addClass('tableSelected');
    });
};

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
};
 
function corteDeCaja() {
	$.get( "user/cajas/corteDeCaja", function( data ) {
    	if ( data.success == true ) {
			$('.modal-body').html(data.form);
			$('.modal-title').text('Corte de Caja');
			return $('.bs-modal').modal('show');
    	};
	});
};

function cortesDeCajaPorDia()
{
    $.ajax({
		type: "GET",
		url: 'admin/cajas/cortesDeCajaPorDia',
	}).done(function(data) {
		if (data.success == true)
		{
			clean_panel();
        	$('#graph_container').show();
        	return $('#graph_container').html(data.view);
		}
		msg.warning(data, 'Advertencia!');
	});
};

function getMovimientosDeCajaDt(e, cierre_caja_id) {
	$.ajax({
		type: "POST",
		url: '/admin/cajas/getMovimientosDeCajaDt',
		data:{cierre_caja_id: cierre_caja_id}
	}).done(function(data) {
		if (data.success == true)
		{
			clean_panel();
        	$('#graph_container').show();
        	return $('#graph_container').html(data.view);
		}
		msg.warning(data, 'Advertencia!');
	});
};

function asignarDt() {
    $caja_id  = $('.dataTable tbody .row_selected').attr('id');

    $.ajax({
		type: "GET",
		url: 'admin/cajas/asignarDt',
        data: {caja_id: $caja_id},
	}).done(function(data) {
		if (data.success == true)
		{
            $('.modal-body').html(data.view);
            $('.modal-title').text('Asingnar Caja');
            return $('.bs-modal').modal('show');
		}
		msg.warning(data, 'Advertencia!');
	});
};

function desAsignarDt () {
    $caja_id  = $('.dataTable tbody .row_selected').attr('id');
    $.confirm({
        text: "Esta seguro que desea liberar la caja?",
        title: "Confirmacion",
        confirm: function(){
            $.ajax({
        		type: "POST",
        		url: 'admin/cajas/desAsignarDt',
                data: {caja_id: $caja_id},
        	}).done(function(data) {
        		if (data.success == true)
        		{
                    $('#example').dataTable().fnStandingRedraw();
                    return msg.success('Caja liberada..!', 'Listo.!!');
        		}
        		msg.warning(data, 'Advertencia!');
        	});
        }
    });
}


function retirarEfectivoDeCaja() {
    $.ajax({
		type: "GET",
		url: 'user/cajas/retirarEfectivoDeCaja',
	}).done(function(data) {
		if (data.success == true)
		{
            $('.modal-body').html(data.view);
            $('.modal-title').text('Asingnar Caja');
            return $('.bs-modal').modal('show');
		}
		msg.warning(data, 'Advertencia!');
	});
};

function retirarDineroDeCajapdf() {
    $('.bs-modal').modal('hide');
    window.open('retirarDineroDeCajaPdf?monto='+$('#montoRetirarCaja').val(), '_blank');
};

function resumenDeActividadActualDeCajas() {
    $.ajax({
        type: "GET",
        url: '/admin/cajas/resumenDeActividadActualDeCajas',
    }).done(function(data) {
        if (data.success == true)
        {
            clean_panel();
            $('#graph_container').show();
            return $('#graph_container').html(data.view);
        }
        msg.warning(data, 'Advertencia!');
    });
};

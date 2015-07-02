$(function() {
	$(document).on('click', '#CierreDelDia', function(){ CierreDelDia(this); });
});

function CierreDelDia()
{
	$.get( "admin/cierre/CierreDelDia", function( data ) {
		$('.modal-body').html(data);
		$('.modal-title').text('Cierre del Dia');
		$('.bs-modal').modal('show');
	});

}

function CierreDelMes()
{
	$.get( "admin/cierre/CierreDelMes", function( data ) {
		generate_dt_local(data);
		$('.dt-container').show();
	});

}

function imprimir_cierre()
{
	$.get( "admin/cierre/CierreDelDia", function( data ) {
		$('#print_barcode').html(data);
		$("#print_barcode").show();
		$.print("#print_barcode");
		$("#print_barcode").hide();
	});
}

function cierre() {
	$.get( "admin/cierre/cierre", function( data ) {
    	if ( data.success == true ) {
			$('.modal-body').html(data.form);
			$('.modal-title').text('Cierre del Dia');
			return $('.bs-modal').modal('show');
    	};
    	return msg.error('El cierre ya ha sido realizado por' + " " + data.user, 'Error!');
	});	
}

function CierreDelDiaPorFecha()
{
	fecha = $(".datepicker .calendar .days .selected").attr('date');

    $.ajax({
        type: "GET",
        url: 'admin/cierre/CierreDelDiaPorFecha',
        data: { fecha:fecha },
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) 
        {
           	$('.modal-body').html(data);
			$('.modal-title').text('Cierre del Dia');
			$('.bs-modal').modal('show');
        }
    });

}

function CierreDelMesPorFecha()
{
	fecha = $(".datepicker .calendar .days .selected").attr('date');

    $.ajax({
        type: "GET",
        url: 'admin/cierre/CierreDelMesPorFecha',
        data: { fecha:fecha },
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) 
        {
           	generate_dt_local(data);
			$('.dt-container').show();
        }
    });

}
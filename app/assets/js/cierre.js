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
		$('.modal-body').html(data);
		$('.modal-title').text('Cierre del Dia');
		$('.bs-modal').modal('show');
	});	
}
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
		$('.modal-body').html(data);
		$('.modal-title').text('Cierre del Mes');
		$('.bs-modal').modal('show');
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


function fopen_traslado() {
	$.get( "admin/traslados/create", function( data ) {
		$('.panel-title').text('Formulario Traslados');
		$(".forms").html(data);
		$(".dt-container").hide();
		$(".form-panel").show();
	});
}
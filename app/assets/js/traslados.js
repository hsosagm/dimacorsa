
function fopen_traslado() {
	$.get( "admin/traslados/create", function( data ) {
		$('.panel-title').text('Formulario Traslados');
		$(".forms").html(data);
		$(".dt-container").hide();
		$(".form-panel").show();
	});
}

function eliminarTraslado(e , traslado_id) {
	$(e).prop('disabled', true);
	$.confirm({
		confirm: function(){
			$.ajax({
				type: "POST",
				url: 'admin/traslados/eliminarTraslado',
				data: { traslado_id: traslado_id },
				contentType: 'application/x-www-form-urlencoded',
				success: function (data) {
					msg.success('Traslado eliminado', 'Listo!')
					$(".form-panel").slideUp('slow');
				}
			});
		}
	});
}

function finalizarTraslado(e , traslado_id) {
	$(e).prop('disabled', true);
	$.confirm({
		text: "esta seguro que desea finalizar el Traslado?",
    	title: "Confirmacion",
		confirm: function(){
			$.ajax({
				type: "POST",
				url: 'admin/traslados/finalizarTraslado',
				data: { traslado_id: traslado_id },
				contentType: 'application/x-www-form-urlencoded',
				success: function (data) {
					if ($.trim(data) == 'success'){
						msg.success('Traslado Finalizado', 'Listo!')
						$(".form-panel").slideUp('slow');
					}
				}
			});
		}
	});
}

function getTrasladosEnviados(e){
	$.get( "admin/traslados/getTrasladosEnviados", function( data ) {
        makeTable(data, ' ', 'Traslados Enviados');
    });
}

function getTrasladosRecibidos(e){
	$.get( "admin/traslados/getTrasladosRecibidos", function( data ) {
        makeTable(data, ' ', 'Traslados Recibidos');
    });
}
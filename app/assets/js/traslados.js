
function fopen_traslado() {
	$.get( "admin/traslados/create", function( data ) {
		$('.panel-title').text('Formulario Traslados');
		$(".forms").html(data);
		$(".dt-container").hide();
		$(".form-panel").show();
	});
} 

function eliminarTraslado(e , traslado_id) {
	$.confirm({
		confirm: function(){
			$.ajax({
				type: "POST",
				url: 'admin/traslados/eliminarTraslado',
				data: { traslado_id: traslado_id },
				success: function (data) {
					msg.success('Traslado eliminado', 'Listo!')
					$(".form-panel").slideUp('slow');
				}
			});
		}
	});
}

function finalizarTraslado(e , traslado_id) {
	$.confirm({
		text: "esta seguro que desea finalizar el Traslado?",
		title: "Confirmacion",
		confirm: function(){
			$.ajax({
				type: "POST",
				url: 'admin/traslados/finalizarTraslado',
				data: { traslado_id: traslado_id },
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

function recibirTraslado(e , traslado_id) {
	$.confirm({
		text: "esta seguro que desea recibir el Traslado?",
		title: "Confirmacion",
		confirm: function(){
			$.ajax({
				type: "POST",
				url: 'admin/traslados/recibirTraslado',
				data: { traslado_id: traslado_id },
				success: function (data) {
					if ($.trim(data) == 'success'){
						msg.success('Traslado Recibido', 'Listo!')
						$(".form-panel").slideUp('slow');
					}
				}
			});
		}
	});
}

function abrirTraslado(e){
	$id = $(e).closest('tr').attr('id');
	
	$.ajax({
		type: "POST",
		url: 'admin/traslados/abrirTraslado',
		data: { traslado_id: $id },
		success: function (data) {
			if (data.success == true){
				$('.panel-title').text('Formulario Traslados');
				$(".forms").html(data.form);
				$(".dt-container").hide();
				return $(".form-panel").show();
			}

			return msg.warning(data,'Advertencia.!');
		}
	});
}

function abrirTrasladoDeRecibido(e){
	$id = $(e).closest('tr').attr('id');
	
	$.ajax({
		type: "POST",
		url: 'admin/traslados/abrirTrasladoDeRecibido',
		data: { traslado_id: $id },
		success: function (data) {
			if (data.success == true){
				$('.panel-title').text('Formulario Traslados');
				$(".forms").html(data.form);
				$(".dt-container").hide();
				return $(".form-panel").show();
			}

			return msg.warning(data,'Advertencia.!');
		}
	});
}

function verDetalleTraslado(e) {
    if ($(e).hasClass("hide_detail")) {
        $(e).removeClass('hide_detail');
        $('.subtable').hide();
    } 
    else {
        $('.hide_detail').removeClass('hide_detail');

        if ( $( ".subtable" ).length ) {
            $('.subtable').fadeOut('slow', function(){
                getDetalleTraslado(e);
            })
        }
        else {
            getDetalleTraslado(e);
        }
    }
}

function getDetalleTraslado(e) {
    $id = $(e).closest('tr').attr('id');
    $('.subtable').remove();
    var nTr = $(e).parents('tr')[0];
    $(e).addClass('hide_detail');
    $(nTr).after("<tr class='subtable'> <td colspan=6 ><div class='grid_detalle_factura'></div></td></tr>");
    $('.subtable').addClass('hide_detail');

    $.ajax({
        type: 'GET',
        url: "admin/traslados/getDetalleTraslado",
        data: { traslado_id: $id},
        success: function (data) {
            if (data.success == true) {
                $('.grid_detalle_factura').html(data.table);
                $(nTr).next('.subtable').fadeIn('slow');
                $(e).addClass('hide_detail');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
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
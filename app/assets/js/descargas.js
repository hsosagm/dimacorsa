
function fopen_descarga() {
	$.get( "admin/descargas/create", function( data ) {
		$('.panel-title').text('Formulario Descargas');
		$(".forms").html(data);
		$(".dt-container").hide();
		$(".form-panel").show();
	});
}

function EliminarDescarga(e , descarga_id) {
	$(e).prop('disabled', true);
	$.confirm({
		confirm: function(){
			$.ajax({
				type: "POST",
				url: 'admin/descargas/delete',
				data: { descarga_id: descarga_id },
				contentType: 'application/x-www-form-urlencoded',
				success: function (data) {

					msg.success('Descarga eliminada', 'Listo!')
					$(".form-panel").slideUp('slow');

				},
				error: function (request, status, error) {
					msg.error(request.responseText, 'Error!')
					$(e).prop('disabled', false);
				}
			});
		}
	});

}

function showDownloadsDetail(e) {

    if ($(e).hasClass("hide_detail")) 
    {
        $(e).removeClass('hide_detail');
        $('.subtable').hide();
    } 
    else 
    {
        $('.hide_detail').removeClass('hide_detail');

        if ( $( ".subtable" ).length )
        {
            $('.subtable').fadeOut('slow', function(){
                getDownloadsDetail(e);
            })
        }
        else
        {
            getDownloadsDetail(e);
        }
    }
}


function getDownloadsDetail(e) {

    $id = $(e).closest('tr').attr('id');
    $('.subtable').remove();
    var nTr = $(e).parents('tr')[0];
    $(e).addClass('hide_detail');
    $(nTr).after("<tr class='subtable'> <td colspan=7><div class='grid_detalle_factura'></div></td></tr>");
    $('.subtable').addClass('hide_detail');
    $.ajax({
        type: 'GET',
        url: "admin/descargas/showgDownloadsDetail",
        data: { descarga_id: $id},
        success: function (data) {

            if (data.success == true)
            {
                $('.grid_detalle_factura').html(data.table);
                $(nTr).next('.subtable').fadeIn('slow');
                $(e).addClass('hide_detail');
            }
            else
            {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}

function OpenDownload(e)
{
	$id = $(e).closest('tr').attr('id');

	$.ajax({
        type: 'GET',
        url: "admin/descargas/OpenDownload",
        data: { descarga_id: $id},
        success: function (data) {

            if (data.success == true)
            {
            	$('.panel-title').text('Formulario Descargas');
				$(".forms").html(data.detalle);
				$(".dt-container").hide();
				$(".form-panel").show();
            }
            else
            {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}

function FinalizarDescarga() {
	$(".form-panel").slideUp('slow');	
}

/*
	categorias.js
	*/

	$(function() {
		$(document).on('click', '#new_categoria', function() { new_categoria(); });
	});

	function new_categoria()
	{
		$.get( 'admin/categorias/create' , function( data ) {
			$('.modal-body-categorias').html(data);
			$('.modal-title-categorias').text('Crear Categorias');
			$('.bs-modal-categorias').modal('show');
		});
	}

	function categoria_edit(e , categoria_id)
	{
		$.ajax({
			type: "GET",
			url: 'admin/categorias/edit',
			data: { categoria_id: categoria_id },
			contentType: 'application/x-www-form-urlencoded',
			success: function (data, text) {
				$('.edit_categorias').slideUp('slow',function(){
					$('.edit_categorias').html(data);
					$('.edit_categorias').slideDown('slow', function() {
					});
				})
				
			},
			error: function (request, status, error) {
				msg.error(request.responseText, 'Error!')
			}
		});

	}

	function cancelar_edicion_categoria()
	{
		$('.edit_categorias').slideUp('slow');
	}

	function guardar_edicion_categoria(element)
	{	
	    var form = $('form[data-remote-cat-e]');
	    $(element).prop('disabled', true);

	    $.ajax({
	        type: form.attr('method'),
	        url: form.attr('action'),
	        data: form.serialize(),
	        success: function (data) {

	            if (data.success == true)
	            {
	                msg.success(form.data('success'), 'Listo!');
	                $('.categorias-detail').html(data.lista);
	                $('.select_'+data.model).html(data.select);
	                $('.edit_categorias').slideUp('slow');
	            }
	            else
	            {
	                msg.warning(data, 'Advertencia!');
	                $(element).prop('disabled', false);
	            }
	        },
	        error: function(errors){
	            msg.error('Hubo un error, intentelo de nuevo', 'Advertencia!');
	        }
	    });
	    return false;
	}
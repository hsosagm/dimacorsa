/* marcas.js */

$(function() {
	$(document).on('click', '#new_marca', function() { new_marca(); });
});

function new_marca()
{
	$.get( 'admin/marcas/create' , function( data ) {
		$('.modal-body-categorias').html(data);
		$('.modal-title-categorias').text('Crear Marcas');
		$('.bs-modal-categorias').modal('show');
	});
}

function marca_edit(e , marca_id)
{
	$.ajax({
		type: "GET",
		url: 'admin/marcas/edit',
		data: { marca_id: marca_id },
		contentType: 'application/x-www-form-urlencoded',
		success: function (data, text) {
			$('.edit_categorias').slideUp('slow',function() {
				$('.edit_categorias').html(data);
				$('.edit_categorias').slideDown('slow', function() {
				});
			})
			
		},
	});
}

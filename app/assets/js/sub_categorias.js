/*
	sub_categorias.js
*/

$(function() {
    $(document).on('click', '#new_sub_categoria', function() { new_sub_categoria(); });
});

function new_sub_categoria()
{
    $.get( 'admin/sub_categorias/create' , function( data ) {
        $('.modal-body-categorias').html(data);
        $('.modal-title-categorias').text('Crear Sub Categorias');
        $('.bs-modal-categorias').modal('show');
    });
}

function sub_categoria_edit(e , sub_categoria_id)
	{
		$.ajax({
			type: "GET",
			url: 'admin/sub_categorias/edit',
			data: { sub_categoria_id: sub_categoria_id },
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
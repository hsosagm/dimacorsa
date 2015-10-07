/* sub_categorias.js */

$(function() {
	$(document).on('click', '#new_sub_categoria', function() { new_sub_categoria(); });
});

function new_sub_categoria()
{
	$categoria_id = $("input[name='categoria_id']").val();
	if($categoria_id > 0) {
		$.get( 'admin/sub_categorias/create?categoria_id='+$categoria_id , function( data ) {
			$('.modal-body-categorias').html(data);
			$('.modal-title-categorias').text('Crear Sub Categorias');
			$('.bs-modal-categorias').modal('show');
		});
	}
	else {
		msg.warning('Seleccione una categoria..', 'Advertencia!');
	}
};

function sub_categoria_edit(e , sub_categoria_id)
{
	$.ajax({
		type: "GET",
		url: 'admin/sub_categorias/edit',
		data: { sub_categoria_id: sub_categoria_id },
		contentType: 'application/x-www-form-urlencoded',
		success: function (data, text) {
			$('.edit_categorias').slideUp('slow',function() {
				$('.edit_categorias').html(data);
				$('.edit_categorias').slideDown('slow', function() {
				});
			})
		}
	});
};

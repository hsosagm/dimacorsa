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

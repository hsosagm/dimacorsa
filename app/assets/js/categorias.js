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

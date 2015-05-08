/*
	marcas.js
*/

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

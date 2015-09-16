
function crearNotaDeCredito() {
    $.get( '/user/notaDeCredito/create', function( data ) {
        $('.modal-body').html(data);
        $('.modal-title').text( 'Crear Nota de Credito');
        $('.bs-modal').modal('show');
    });
}

function configurar_impresoras()
{
    buscarImpresoras();
	$.get( "admin/configuracion/impresora", function( data ) {
        $('.modal-body').html(data);
        $('.modal-title').text('Configuracion de Impresora');
        $('.bs-modal').modal('show');
    });  
}
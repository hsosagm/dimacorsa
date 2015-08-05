
function configurar_impresoras()
{
    buscarImpresoras();
	$.get( "admin/configuracion/impresora", function( data ) {
        $('.dt-container-cierre').html(data);
        $('.dt-container').hide();
        $('.dt-container-cierre').show();
    });  
} 
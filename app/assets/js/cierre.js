$(function() {
    $(document).on('click', '#CierreDelDia', function(){ CierreDelDia(this); });
});

function CierreDelDia()
{
	$.get( "admin/cierre/CierreDelDia", function( data ) {
        $('.modal-body').html(data);
        $('.modal-title').text('Cierre del Dia');
        $('.bs-modal').modal('show');
    });
}

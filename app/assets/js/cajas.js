function getConsultarCajas(e) {
    $.get( "admin/cajas/getConsultarCajas", function( data ) {
        makeTable(data, '/admin/cajas/', '');
    });
}
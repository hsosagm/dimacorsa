function clear_contacto_body()
{
    $('.body-contactos').slideUp('slow');
}


$(document).on('click', '.pagination_ventas_por_cliente a', function (e) {
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    vm.getVentasPendientesPorClientePaginacion(page,null);

    return false;
});


$(document).on('click', '.pagination_ventas_por_usuario a', function (e) {
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    vm.getDetalleVentasPendientesPorUsuarioPaginacion(page,null);

    return false;
});

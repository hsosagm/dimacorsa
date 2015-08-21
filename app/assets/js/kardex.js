/*
var global_producto_id;
var kardexFechaInicial;
var kardexFechaFinal;
var kardexElement;

function kardexProductoActualizar() {
    kardexFechaInicial  = $("#fecha_inicial_hidden").val();
    kardexFechaFinal = $("#fecha_final_hidden").val();
    getKardexProducto(kardexElement, 1 , null);
}

function kardexProducto()
{
    kardexFechaInicial  = null;
    kardexFechaFinal = null;
    global_producto_id = $('.dataTable tbody .row_selected').attr('id');;
    e = $('.dataTable tbody .row_selected');
    kardexElement = e;
    if ($(e).hasClass("hide_detail"))  {
        $(e).removeClass('hide_detail');
        $('.subtable').fadeOut('slow');
    } 
    else {
        $('.hide_detail').removeClass('hide_detail');

        if ( $( ".subtable" ).length ) {
            $('.subtable').fadeOut('slow', function(){
                getKardexProducto(e, 1 , null);
            })
        }
        else {
            getKardexProducto(e, 1 , null);
        }
    }
}

function getKardexProducto(e , page , sSearch) {

    $('.subtable').remove();
    var nTr = e;
    $(e).addClass('hide_detail');
    $(nTr).after("<tr class='subtable'> <td colspan=6><div class='grid_detalle_factura'></div></td></tr>");
    $('.subtable').addClass('hide_detail');

    $.ajax({
        type: 'GET',
        url: "admin/kardex/getKardex?page=" + page,
        data: { producto_id : global_producto_id , fecha_inicial: kardexFechaInicial, fecha_final: kardexFechaFinal ,  sSearch:sSearch},
        success: function (data) {
            if (data.success == true) {
                $('.grid_detalle_factura').html(data.table);
                $(nTr).next('.subtable').fadeIn('slow');
                $(e).addClass('hide_detail');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}

function getKardexProductoPaginacion(page , sSearch) {
    $.ajax({
        type: 'GET',
        url: "admin/kardex/getKardex?page=" + page,
        data: { producto_id : global_producto_id , fecha_inicial: kardexFechaInicial, fecha_final: kardexFechaFinal ,  sSearch:sSearch},
        success: function (data) {
            if (data.success == true) {
                $('.grid_detalle_factura').html(data.table);
                $(e).addClass('hide_detail');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}

$(document).on('click', '.pagination_kardex_producto a', function (e) {
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    getKardexProductoPaginacion(page,null);
    return false;
});*/
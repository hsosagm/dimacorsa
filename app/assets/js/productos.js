 /* productos.js */

$(function() {
    $(document).on("click", "#new_producto",   function(){ new_producto(this); });
    $(document).on("click", "#logs_productos", function(){ logs_productos(this); });
    $(document).on("click", "#_view_existencias",        function(){ _view_existencias(this); });
});

function getInventario() {
    $.ajax({
        type: "GET",
        url: 'user/productos/getInventario',
    }).done(function(data) {
        if (data.success == true)
        {
            clean_panel();
            $('#graph_container').show();
            $('#graph_container').html(data.view);
            return $('#example').addClass('tableSelected');
        }
        msg.warning(data, 'Advertencia!');
    });
};

function logs_productos() {
    $.get( "owner/logs/productos", function( data ) {
        $('.table').html(data);
    });
};

function view_inventario() {
    $.get( "user/productos/inventario", function( data ) {
        makeTable(data, ' ', 'Inventario');
    });
};

function new_producto() {
    $.get( "admin/productos/create", function( data ) {
        $('.producto-title').text('Formulario Producto');
        $(".forms-producto").html(data);
        $(".dt-panel").hide();
        $(".form-panel").hide();
        $(".producto-container").show();
        $(".producto-panel").show();
    });
};

function _view_existencias() {
    $id  = $('.dataTable tbody .row_selected').attr('id');
     $.ajax({
        type: 'GET',
        url: "user/view_existencias",
        data: { id:$id  },
        success: function (data) {
            $('.modal-body').html(data);
            $('.modal-title').text('Existencias');
            $('.bs-modal').modal('show');
        }
    });
};

function inventario() {
    $.get( "admin/inventario/?opcion=1", function( data ) {
        $('.dt-panel').html(data.table);        
        $('.dt-panel').show();        
    });
};

function getStockMinimo() {
    $.ajax({
        url: "admin/inventario/getStockMinimo",
        type: "GET"
    }).done(function(data) {
        if (data.success) {
            clean_panel();
            $('#graph_container').show();
            return $('#graph_container').html(data.table);
        }
        return msg.warning(data, 'Advertencia!');
    });
};

function getKardexDetail(e, transaccion, transaccion_id, evento) {
    var ruta = "";
    if ($.trim(transaccion) == "ventas") 
        ruta = "user/ventas/showSalesDetail?venta_id="+transaccion_id;
    if ($.trim(transaccion) == "descargas") 
        ruta = "admin/descargas/showgDownloadsDetail?descarga_id="+transaccion_id;
    if ($.trim(transaccion) == "compras") 
        ruta = "admin/compras/showPurchaseDetail?id="+transaccion_id;

    if ($.trim(transaccion) == "traslados") {
        if ($.trim(evento) == "ingreso")
            $opcion = 2;
        if ($.trim(evento) == "salida")
            $opcion = 1;

        ruta = "admin/traslados/getDetalleTraslado?traslado_id="+transaccion_id+"&opcion="+$opcion;
    }

    if ($.trim(transaccion) == "devolucion") 
        ruta = "user/ventas/devoluciones/getDevolucionesDetail?devolucion_id="+transaccion_id;
    if ($.trim(transaccion) == "ajuste") 
        return msg.warning("Los ajustes no tienen detalle...", 'Advertencia!');

    if ($(e).hasClass("hide_detail")) {
        $(e).removeClass('hide_detail');
        $('.subtable').hide();
    }
    else {
        $('.hide_detail').removeClass('hide_detail');
        if ( $( ".subtable" ).length )
            $('.subtable').fadeOut('slow', function() { KardexDetalle(e, ruta); })
        else
            KardexDetalle(e, ruta);
    }
};


function KardexDetalle(e, ruta) {
    $('.subtable').remove();
    var nTr = $(e).parents('tr')[0];
    $(e).addClass('hide_detail');
    $(nTr).after("<tr class='subtable'> <td colspan=12><div class='grid_detalle_kardex'></div></td></tr>");
    $('.subtable').addClass('hide_detail');

    $.ajax({
        type: 'GET',
        url: ruta ,
        success: function (data) {
            if (data.success) {
                $('.grid_detalle_kardex').html(data.table);
                $(nTr).next('.subtable').fadeIn('slow');
                return $(e).addClass('hide_detail');
            }
            msg.warning(data, 'Advertencia!');
        }
    });
};
 
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
}

function new_producto() {
    $.get( "admin/productos/create", function( data ) {
        $('.producto-title').text('Formulario Producto');
        $(".forms-producto").html(data);
        $(".dt-panel").hide();
        $(".form-panel").hide();
        $(".producto-container").show();
        $(".producto-panel").show();
    });
}

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
}

function inventario() {
    $.get( "admin/inventario/", function( data ) {
        makeTable(data, 'admin/productos/', 'Producto');
    });
};
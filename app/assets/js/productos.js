 
/*
productos.js
*/

$(function() {
    $(document).on("click", "#Inv_dt_open",    function(){ Inv_dt_open(this); });
    $(document).on("click", "#new_producto",   function(){ new_producto(this); });
    $(document).on("click", "#logs_productos", function(){ logs_productos(this); });
    $(document).on("click", "#search-inventario-user",   function(){ inventario_user(this); });
    $(document).on("click", "#_view_existencias",        function(){ _view_existencias(this); });


});

function Inv_dt_open() {

    $.get( "admin/productos/inventario_dt", function( data ) {
        makeTable(data, 'admin/productos/', 'Producto');
        $('#example').addClass('tableSelected');
    });
};

function inventario_user() {

    $.get( "user/productos/user_inventario", function( data ) {
        makeTable(data, '', 'Producto');
        $('#example').addClass('tableSelected');
    });
};

function logs_productos() {

    $.get( "owner/logs/productos", function( data ) {
        $('.table').html(data);
    });
};

function view_inventario()
{
    $.get( "user/productos/inventario", function( data ) {
        makeTable(data, ' ', 'Inventario');
    });
}

function new_producto()
{
    $.get( "admin/productos/create", function( data ) 
    {
        $('.producto-title').text('Formulario Producto');
        $(".forms-producto").html(data);
        $(".dt-panel").hide();
        $(".form-panel").hide();
        $(".producto-container").show();
        $(".producto-panel").show();
    });
}

function _view_existencias()
{
    $id  = $('.dataTable tbody .row_selected').attr('id');
     $.ajax({
        type: 'GET',
        url: "user/view_existencias",
        data: { id:$id  },
        success: function (data) {
            $('.modal-body').html(data);
            $('.modal-title').text('Existencias');
            $('.bs-modal').modal('show');
        },
        error: function(errors){
            msg.error('Hubo un error, intentelo de nuevo', 'Advertencia!');
        }
    });
}

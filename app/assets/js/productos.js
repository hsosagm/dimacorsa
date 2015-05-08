 
/*
productos.js
*/

$(function() {
    $(document).on("click", "#Inv_dt_open",    function(){ Inv_dt_open(this); });
    $(document).on("click", "#new_producto",   function(){ new_producto(this); });
    $(document).on("click", "#logs_productos", function(){ logs_productos(this); });
    $(document).on("click", "#search-inventario-user",   function(){ inventario_user(this); });
    $(document).on('submit','form[data-remote-product]', function(e){ crear_producto(e,this);  });
    $(document).on("click", "#_view_existencias",        function(){ _view_existencias(this); });


});

function Inv_dt_open() {

    $.get( "admin/datatables/inventario_dt", function( data ) {
        makeTable(data, 'admin/productos/', 'Producto');
    });
};

function inventario_user() {

    $.get( "user/datatables/user_inventario", function( data ) {
        makeTable(data, '', 'Producto');
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

function crear_producto(e,element)
{
   form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');
    codigo = $('input[name=codigo]', form).val();

    if( $('input[type=checkbox]', this).is(':checked') ) 
    {
        $('input[type=checkbox]', this).val('1');
    }
    else
    {
        $('input[type=checkbox]', this).val('0');
    }

    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        success: function (data) {

            if (data == 'success')
            {
                msg.success(form.data('success'), 'Listo!');
                $('.panel-title').text('Formulario Compras');
                 $(".dt-container").hide();
                 $(".producto-container").hide();
                 $(".form-panel").show();

                $("#search_producto").val(codigo);
                search_producto_dt();
            }
            else
            {
                msg.warning(data, 'Advertencia!');
            }
        },
        error: function(errors){
            msg.error('Hubo un error, intentelo de nuevo', 'Advertencia!');
        }
    });

    e.preventDefault();
    $('input[type=submit]', form).removeAttr('disabled');
}

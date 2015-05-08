$(function() {
    $(document).on('click', '.f_ven_op', function(){ f_ven_op(this); });
    $(document).on('f10', '#venta_save_producto', function(){ venta_save_producto(); });
});


function f_ven_op() {

    $.get( "user/ventas/create", function( data ) {
        $('.panel-title').text('Formulario Ventas');
        $(".forms").html(data);
        $(".dt-container").hide();
        $(".form-panel").show();
        status_form_compra = 0;
    });
}


function venta_save_producto()
{
    form = $('form[data-remote-md-d]');
    venta_id = $("input[name='venta_id']").val();
    formData = form.serialize()+'&venta_id='+venta_id;

    $.ajax({
        type: 'POST',
        url: 'user/ventas/detalle',
        data: formData,
        success: function (data) 
        {
            if (data.success == true) 
            {                        
                msg.success('Producto Ingresado..!', 'Listo!');
                $('.body-detail').html(data.table);
                // $('#total-compra').html(data.total);
                // $('#total-final').html(data.total);
                // $("form[data-remote-mdc-d]").trigger('reset');
                // $("input[name='producto_id']").val('');
                // $("input[name='ingreso_series']").val('');
                // $( "#compra-search-producto" ).focus();
            }
            else
            {
                msg.warning(data, 'Advertencia!');
            }
        },
        error: function(errors)
        {
            msg.error('Hubo un error, intentelo de nuevo', 'Advertencia!');
        }
    });
};

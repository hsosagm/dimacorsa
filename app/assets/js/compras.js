$(function() {
    $(document).on('click', '#f_com_op',             function() { f_com_op(this);         });
    $(document).on('click', '#edit_info_compra',     function() { edit_info_compra(this); });
    $(document).on('click', '#serial-compra',        function() { view_serial(this);    });
    $(document).on('click', '#_edit_producto',       function() { _edit_producto(this); });
    $(document).on('click', '#_add_producto',        function() { _add_producto(this); });
    $(document).on('click', '.return_compras',       function() { return_compras(this); });
    $(document).on('enter', "input[name='ingreso_series']",function(){ save_serie_compra(this);});
    $(document).on('submit'  ,'form[data-remote-pago]', function(e)  {  ingresar_pago(e,this);  });
    $(document).on('dblclick','.edit_detalle_compra',   function()   {  edit_detalle_compra(this);  });
    $(document).on('blur' ,'._edit_detalle_compra',     function()   {  desabilitar_edicion_detalle(this); });
    $(document).on('enter','._edit_detalle_compra',     function(e)  {  _edit_detalle_compra(e,this); });
});

function f_com_op() 
{    
    $.get( "admin/compras/create", function( data ) 
    {
        $('.panel-title').text('Formulario Compras');
        $(".forms").html(data);
        $(".dt-container").hide();
        $(".producto-container").hide();
        $(".form-panel").show();
    });
}

function edit_info_compra()
{
   $id  = $("input[name='compra_id']").val();
    $url = 'admin/compras/edit_info';

    $.ajax({
        type: "POST",
        url: $url,
        data: {id: $id},
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            $('.modal-body').html(data);
            $('.modal-title').text( 'Editar Informacion Compra');
            $('.bs-modal').modal('show');
        },
        error: function (request, status, error) {
            alert(request.responseText);
        }
    });
}

function return_compras()
{
    $(".dt-container").hide();
    $(".producto-container").hide();
    $(".form-panel").show();
}

var val_anterior;

function edit_detalle_compra(element)
{
    val_anterior = $(element).text();
    $(element).html('<input type="text" class="_edit_detalle_compra" />');
    $('._edit_detalle_compra').focus();
}

function desabilitar_edicion_detalle(element)
{
    $(element).closest('td').html(val_anterior);
}

function _edit_detalle_compra(e,element)
{
    $detalle_id  = $(element).closest('td').attr('cod');
    $tipo_dato = $(element).closest('td').attr('field');
    $dato = $(element).val();
    $compra_id = $("input[name='compra_id']").val();

    $.ajax({
        type: 'POST',
        url: 'admin/compras/edit_detalle_compra',
        data: { detalle_id:$detalle_id , tipo_dato:$tipo_dato , dato:$dato ,compra_id:$compra_id },
        success: function (data) 
        {
            if (data.success == true) 
            {                        
                msg.success('Detalle Actualizado..!', 'Listo!');
                $('.body-detail').html(data.table);
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
    e.preventDefault(); 
}   

function save_serie_compra(element)
{
    var cod = '';
    $("#SerialTable td").each(function() 
    {
        if ($(this).text() === $("input[name='ingreso_series']").val()) 
        {
            cod = $(this).text();
        }
    });

    if (cod === $("input[name='ingreso_series']").val())
    {
        msg.error('la serie ya ha sido ingresada', 'Advertencia!');
    }
    else
    {
        if ($(element).val().trim() === '') 
        {
            msg.warning('El Campo se encuentra vacio...!', 'Advertencia!');
        }
        else 
        {
            var serie = $(element).val().trim();

            var series = $("input[name='serials']").val();

            if($("input[name='serials']").val().trim()==='')
            {
                series = serie;
            }
            else
            {
                series = series+","+serie;
            }
            var myRow = '<tr><td width="100%">'+serie+'</td><td><i class="fa fa-times btn-link theme-c" id="'+series+'" onclick="DeleteserialsCompra(this)"></i></td></tr>';
            $("input[name='serials']").val(series);

            $("#SerialTable tr:first").after(myRow);
            msg.success('Ingresado..!', 'Listo!');
        }
    }
}

function DeleteCompraInicial()
{
    $.confirm({
        confirm: function(){
            $.ajax({
                type: 'POST',
                url: 'admin/compras/delete',
                data: { id: $("input[name='compra_id']").val() },
                success: function (data) {
                    if (data == 'success')
                    {
                        f_com_op();
                        msg.success('Compra Eliminada..!', 'Listo!');
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
        }
    });
}

function DeleteDetalleAbono($id , $metodo , $td)
{
   $.confirm({
    confirm: function(){
        $.ajax({
            type: 'POST',
            url: 'admin/compras/delete_abono',
            data: { id:$id, metodo:$metodo},
            success: function (data) {
                if (data.success == true) 
                {
                  Ingresar_abono_compra();
                  msg.success('Eliminado', 'Listo!');
                  $('.finalizar-compra').removeAttr('onclick');
                  ('.finalizar-compra').val('Ingresar Monto');
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
    }
});
}

function Ingresar_abono_compra()
{
    $.ajax({
        type: 'GET',
        url: "admin/compras/abono",
        data: { compra_id: $("input[name='compra_id']").val() },
        success: function (data) {
         if (data.success == true) 
         {
            $('.modal-body').html(data.detalle);
            $('.modal-title').text('Ingresar Tipos');
            $('.bs-modal').modal('show');
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
}

function ingresar_pago(e,element)
{
    form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');
    formData = form.serialize() +'&proveedor_id='+$("input[name='proveedor_id']").val()+'&compra_id='+$("input[name='compra_id']").val();

    $.ajax({
        type: "POST",
        url:  "admin/compras/abono",
        data: formData,
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            if (data.success == true) 
            {
             msg.success('Ingresado', 'Listo!');
             Ingresar_abono_compra();
             $('.finalizar-compra').removeAttr('onclick');
         }
         
         else
         {
            msg.warning(data, 'Advertencia!');
        }
    },
    error: function (request, status, error) {
        alert(request.responseText);
    }
});

    e.preventDefault();
    $('input[type=submit]', form).removeAttr('disabled');
}

function FinalizarCompraInicial()
{
    $.ajax({
        type: 'POST',
        url: 'admin/compras/finalizar',
        data: { compra_id: $("input[name='compra_id']").val(),nota: $("input[name='nota']").val() },
        success: function (data) {
            if (data == 'success')
            {
                f_com_op();
                msg.success('Compra Finalizada..!', 'Listo!');
                $('.bs-modal').modal('hide');
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

    return false;
}


function view_serial()
{
    $serial = $("input[name='serials']").val();
    $.ajax({
        type: "GET",
        url: "admin/compras/serial",
        data: {serial: $serial},
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            $('.modal-body').html(data);
            $('.modal-title').text('Seriales');
            $('.bs-modal').modal('show');
        },
        error: function (request, status, error) {
            alert(request.responseText);
        }
    });
}

function  DeleteSerialCompra(element)
{
    var id  = $(element).attr('id');
    $.confirm({
        confirm: function(){
            series=$("input[name='serial']").val().replace(id,'');
            $("input[name='serial']").val(series);
            $(element).closest('tr').hide();
        }
    });
}

function _edit_producto() {

    $id  =  $("input[name='producto_id']").val();
    if ($id > 0)
    {
        $.ajax({
            type: "POST",
            url: "admin/productos/edit",
            data: {id: $id},
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                $('.modal-body').html(data);
                $('.modal-title').text( 'Editar Producto');
                $('.bs-modal').modal('show');
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    };
}; 

function _add_producto () 
{
    new_producto();
}

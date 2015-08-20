$(function() {
    $(document).on('click', '.f_ven_op', function(){ f_ven_op(this); });
    $(document).on("enter", "#serialsDetalleVenta", function(){ guardarSerieDetalleVenta(); });
});

function f_ven_op() {
    $.ajax({
      url: "user/ventas/create",
      type: "GET"
    }).done(function(data) {
        $('.panel-title').text('Formulario Ventas');
        $(".forms").html(data);
        ocultar_capas();
        $(".form-panel").show();
    });
}
 
function RemoveSale() {
    $.confirm({
        confirm: function() {
			$.ajax({
				type: 'POST',
				url: 'user/ventas/RemoveSale',
				data: {id: $("input[name=venta_id]").val()},
				success: function (data) {
		            if (data.success == true)
		            {
		                msg.success('Venta eliminada', 'Listo!');
		                $(".form-panel").hide();
                        return;
		            }
		            msg.warning(data, 'Advertencia!');
				}
			});
        }
    }); 
}

function OpenModalSalesPayments($venta_id)
{
    $.ajax({
        type: 'GET',
        url: "user/ventas/ModalSalesPayments",
        data: { venta_id: $venta_id },
        success: function (data) {
	        if (data.success == true) 
	        {
	            $('.modal-body').html(data.detalle);
	            $('.modal-title').text('Ingreso de Pagos');
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


$(document).on('submit', 'form[data-remote-sales-payment]', function(e) {

    var form = $(this);

    $('input[type=submit]', form).prop('disabled', true);

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function (data) {
  
                if (data.success == true)
                {
                    msg.success('Pago ingresado', 'Listo!');
                    $('.modal-body').html(data.detalle);
                }
                else
                {
                    msg.warning(data, 'Advertencia!');
                    $('input[type=submit]', form).prop('disabled', false);
                }
            }

        });

    e.preventDefault();
});


function RemoveSalePayment($id, $venta_id) {

    $.ajax({
        type: "POST",
        url: "user/ventas/RemoveSalePayment",
        data: { id:$id, venta_id:$venta_id },
        success: function (data) {
            if (data.success == true)
            {
                msg.success('Pago eliminado', 'Listo!');
                $('.modal-body').html(data.detalle);
                $('.modal-title').text('Ingreso de Pagos');
            }
            else
            {
                msg.warning(data, 'Advertencia!');
            }
        }

    });
}


function FinalizeSale(element, $id) {

    $(element).prop("disabled", true);

    $.ajax({
        type: 'POST',
        url: "user/ventas/FinalizeSale",
        data: { venta_id: $id},
        success: function (data) {
            if (data.success == true)
            {
                $('.bs-modal').modal('hide');
                msg.success('Venta finalizada', 'Listo!');
                $(".form-panel").hide();
            }
            else
            {
                msg.warning(data, 'Advertencia!');
                $(element).prop("disabled", false);
            }
        }
    });
}

function showSalesDetail(e) {

    if ($(e).hasClass("hide_detail")) 
    {
        $(e).removeClass('hide_detail');
        $('.subtable').hide();
    } 
    else 
    {
        $('.hide_detail').removeClass('hide_detail');

        if ( $( ".subtable" ).length )
        {
            $('.subtable').fadeOut('slow', function(){
                getSalesDetail(e);
            })
        }
        else
        {
            getSalesDetail(e);
        }
    }
}


function getSalesDetail(e) {

    $id = $(e).closest('tr').attr('id');
    $('.subtable').remove();
    var nTr = $(e).parents('tr')[0];
    $(e).addClass('hide_detail');
    $(nTr).after("<tr class='subtable'> <td colspan=7><div class='grid_detalle_factura'></div></td></tr>");
    $('.subtable').addClass('hide_detail');

    $.ajax({
        type: 'GET',
        url: "user/ventas/showSalesDetail",
        data: { venta_id: $id},
        success: function (data) {

            if (data.success == true)
            {
                $('.grid_detalle_factura').html(data.table);
                $(nTr).next('.subtable').fadeIn('slow');
                $(e).addClass('hide_detail');
            }
            else
            {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}


function openSale(e)
{
    $id = $(e).closest('tr').attr('id');

    $.ajax({
        type: 'GET',
        url: "user/ventas/openSale",
        data: { venta_id: $id},
        success: function (data) {
            if (data.success == true)
            {
                $('.panel-title').text('Formulario Ventas');
                $(".forms").html(data.table);
                $(".dt-container").hide();
                $(".dt-container-cierre").hide();
                $(".form-panel").show();
            }
            else
            {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}


function CreditSales(e)
{
    $(e).prop("disabled", true);

    $.ajax({
        type: 'GET',
        url: "user/ventas/getCreditSales",
        success: function (data) {
            if (data.success == true)
            {
                generate_dt_local(data.table);
            }
            else
            {
                msg.warning('Hubo un error intentelo de nuevo', 'Advertencia!');
            }
        }
    }); 
}

function ImprimirVentaModal(e,id)
{
    $.ajax({
        type: 'GET',
        url: "user/ventas/ImprimirVentaModal",
        data: { venta_id: id},
        success: function (data) {
            if (data.success == true) {
                $('.modal-body').html(data.form);
                $('.modal-title').text('Imprimir Venta');
                $('.bs-modal').modal('show');
            }

            else {
                msg.warning('Hubo un error intentelo de nuevo', 'Advertencia!');
            }
        }
    });       
}

function OpenModalSalesItemSerials(e)
{
     $serial = $("input[name='serials']").val();
    $.ajax({
        type: "GET",
        url: "user/OpenModalSalesItemSerials",
        data: {serial: $serial},
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            $('.modal-body').html(data);
            $('.modal-title').text('Seriales');
            $('.bs-modal').modal('show');
            setTimeout(function(){
                $("input[name='InsertPurchaseItemSerials']").focus();
            }, 500);
        }
    });
}

function imprimirFactura(p)
{
    if (isLoaded()) {
        qz.findPrinter();

        window['qzDoneFinding'] = function() {
            var printer = qz.getPrinter();
            
            if (printer !== null) {
                $.ajax({
                    type: 'GET',
                    url: "user/ventas/imprimirFactura",
                    data: { venta_id: 26011},
                    success: function (data) {

          qz.append("\x1B\x40"); // reset printer
          qz.append("\x1B\x33\x20"); // set line spacing MUST BE x35
          qz.append("\x1B\x6C\x04"); // left margin max x49
          qz.append("\x1B\x6B\x01"); // select typeface - 00 serif - 01 sans serif
          qz.append("\x1B\x74\x01"); // select character table (0-italic, 1-normal)
          qz.append(chr(27) + chr(69) + "\r");
          qz.setEncoding("UTF-8");
          qz.setEncoding("850");
          qz.append('\n\n\n');
          qz.append(data.nit+'\r\n');
          qz.append(data.nombre+'\r\n');
          qz.append(data.direccion+'\r\n');
          qz.append('\n\n');

            var counter = 0;
            $.each(data.detalle, function(i, v) {
                qz.append(v.descripcion+"\n");
                counter++;
            });

            counter = 18 - counter;

            for ( $i = 0; $i < counter; $i++) {
                qz.append('\n');
            };

          qz.append(data.total_letras+"\r");
          qz.append(data.total_num+"\r\n");
          qz.append('\n\n\n\n');
          qz.append("\x1B\x40"); // reset printer
          qz.print();

                    }
                }); 
            }
            else {
                msg.error('La impresora "'+p+'" no se encuentra', 'Error!');
            }
            
            window['qzDoneFinding'] = null;
        };
    }
}

var serialsDetalleVenta = [];

function ingresarSeriesDetalleVenta(e, detalle_venta_id) {
    $.ajax({
        type: "POST",
        url: 'user/ventas/ingresarSeriesDetalleVenta',
        data: {detalle_venta_id: detalle_venta_id },
    }).done(function(data) {
        if (data.success == true) {
            $('.modal-body').html(data.view);
            $('.modal-title').text( 'Ingresar Series');
            return $('.bs-modal').modal('show');
        }
        msg.warning(data, 'Advertencia!');
    });
}

function guardarSerieDetalleVenta () {
    if($.trim($("#serialsDetalleVenta").val()) != ''){
        var ingreso = true;
        $("#listaSeriesDetalleVenta").html("");

        for (var i = 0; i < serialsDetalleVenta.length; i++) {
            $value ="'"+serialsDetalleVenta[i]+"'";
            $tr = '<tr><td>'+serialsDetalleVenta[i]+'</td>';
            $tr += '<td><i class="fa fa-trash fg-red" onclick="eliminarSerialsDetalleVenta(this,'+$value+');"></i></td></tr>';
            $("#listaSeriesDetalleVenta").append($tr);
            if(serialsDetalleVenta[i] == $("#serialsDetalleVenta").val())
                ingreso = false
        };

        if(ingreso == true) {
            serialsDetalleVenta.push($("#serialsDetalleVenta").val());
            $value ="'"+$("#serialsDetalleVenta").val()+"'";
            $tr  = '<tr><td>'+$("#serialsDetalleVenta").val()+'</td>';
            $tr += '<td><i class="fa fa-trash fg-red" onclick="eliminarSerialsDetalleVenta(this,'+$value+');"></i></td></tr>';
            $("#listaSeriesDetalleVenta").append($tr);
            msg.success('Serie ingresada..!', 'Listo!');
        }
        else
            msg.warning('La serie ya fue ingresada..!', 'Advertencia!');

        $("#serialsDetalleVenta").val("");
        $("#serialsDetalleVenta").focus();
    }
    else
        msg.warning('El campo se encuentra vacio..!', 'Advertencia!');
}

function eliminarSerialsDetalleVenta(e, serie) {
    serialsDetalleVenta.splice(serialsDetalleVenta.indexOf(serie), 1);
    $(e).closest('tr').hide();
    $("#serialsDetalleVenta").focus();
}

function guardarSeriesDetalleVenta(e, detalle_venta_id) {
    $(e).prop("disabled", true);
    $.ajax({
        type: "POST",
        url: 'user/ventas/ingresarSeriesDetalleVenta',
        data: {detalle_venta_id: detalle_venta_id, guardar:true, serials: serialsDetalleVenta.join(',') },
    }).done(function(data) {
        if (data.success == true) {
            msg.success('Series Guardadas..!', 'Listo!');
            return $('.bs-modal').modal('hide');
        }
        $(e).prop("disabled", true);
        msg.warning(data, 'Advertencia!');
    });
}

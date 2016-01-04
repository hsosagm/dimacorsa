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
        $('#cliente').focus();
    });
};

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
};

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
        }
    });
};


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
};


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
};

function FinalizarEImprimirGarantia(e, venta_id, impresora_garantia){
    ImprimirGarantia(e, venta_id, impresora_garantia);
};

function FinalizarEImprimirFacturaYGarantia(e, venta_id, impresora_garantia, impresora_factura){
    printInvoice(e, venta_id, impresora_factura);
    setTimeout(function(){
        ImprimirGarantia(e, venta_id, impresora_garantia);
    }, 5000);
};

function FinalizarEImprimirFactura(e, venta_id, impresora_factura) {
    printInvoice(e, venta_id, impresora_factura);
};

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
};


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
};


function openSale(e)
{
    if ($.trim($(e).closest('tr').attr('anulada')) == 'true') {
        return msg.warning('no puedes abrir porque la factura fue anulada..', 'Advertencia!')
    }

    $.confirm({
        text: "esta seguro que desea abrir la venta?",
        title: "Confirmacion",
        confirm: function(){
            $.ajax({
                type: "GET",
                url: "user/ventas/openSale",
                data: { venta_id: $(e).closest('tr').attr('id') },
            }).done(function(data) {
                if (data.success == true)
                {
                    $('.panel-title').text('Formulario Ventas');
                    $(".forms").html(data.table);
                    $(".dt-container").hide();
                    $(".dt-container-cierre").hide();
                    return $(".form-panel").show();
                }
                msg.warning(data, 'Advertencia!');
            });
        }
    });
};


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
};

function getModalImprimirVenta(e,id)
{
    $.ajax({
        type: 'GET',
        url: "user/ventas/getModalImprimirVenta",
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
};

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
};

// for test
function imprimirFactura(p)
{
    if ($.trim($(e).closest('tr').attr('anulada')) == 'true') {
        return msg.warning('no puedes imprimir porque la factura esta anulada..', 'Advertencia!')
    }

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
};

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
            $('.bs-modal').modal('show');
            setTimeout(function(){
                $("#serialsDetalleVenta").focus();
            }, 500);
            return ;
        }
        msg.warning(data, 'Advertencia!');
    });
};

function guardarSerieDetalleVenta () {

    if($.trim($("#serialsDetalleVenta").val().replace("'","")) != ''){
        var ingreso = true;
        $("#listaSeriesDetalleVenta").html("");

        for (var i = 0; i < serialsDetalleVenta.length; i++) {
            $value ="'"+serialsDetalleVenta[i]+"'";
            $tr = '<tr><td>'+serialsDetalleVenta[i]+'</td>';
            $tr += '<td><i class="fa fa-trash fg-red" onclick="eliminarSerialsDetalleVenta(this,'+$value+');"></i></td></tr>';
            $("#listaSeriesDetalleVenta").prepend($tr);
            if(serialsDetalleVenta[i] == $("#serialsDetalleVenta").val().replace("'",""))
                ingreso = false
        };

        if(ingreso == true) {
            serialsDetalleVenta.push($("#serialsDetalleVenta").val());
            $value ="'"+$("#serialsDetalleVenta").val().replace("'","")+"'";
            $tr  = '<tr><td>'+$("#serialsDetalleVenta").val().replace("'","")+'</td>';
            $tr += '<td><i class="fa fa-trash fg-red" onclick="eliminarSerialsDetalleVenta(this,'+$value+');"></i></td></tr>';
            $("#listaSeriesDetalleVenta").prepend($tr);
            msg.success('Serie ingresada..!', 'Listo!');
        }
        else
            msg.warning('La serie ya fue ingresada..!', 'Advertencia!');

        $("#serialsDetalleVenta").val("");
        $("#serialsDetalleVenta").focus();
    }
    else
        msg.warning('El campo se encuentra vacio..!', 'Advertencia!');
};

function eliminarSerialsDetalleVenta(e, serie) {
    serialsDetalleVenta.splice(serialsDetalleVenta.indexOf(serie), 1);
    $(e).closest('tr').hide();
    $("#serialsDetalleVenta").focus();
};

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
};

function enviarVentaACaja(e, venta_id) {
    $(e).prop("disabled", true);
    $.ajax({
        type: "POST",
        url: 'user/ventas/enviarVentaACaja',
        data: { venta_id: venta_id },
    }).done(function(data) {
        if (data.success == true) {
            $('.bs-modal').modal('hide');
            msg.success('Venta Enviada..', 'Listo!');
            return $(".form-panel").hide();
        }
        msg.warning(data, 'Advertencia!');
        $(e).prop("disabled", false);
    });
};


function eliminarAbonoVentaDt(e, abonos_ventas_id) {
    $.confirm({
        text: "Esta seguro de eliminar el abono?",
        title: "Confirmacion",
        confirm: function(){
            $(e).prop("disabled", true);
            $.ajax({
                type: "POST",
                url: 'user/ventas/payments/eliminarAbonoVenta',
                data: {  abonos_ventas_id: abonos_ventas_id  },
            }).done(function(data) {
                if (data == 'success')
                    return msg.success('Abonos Eliminados', 'Listo!');

                msg.warning(data, 'Advertencia!');
                $(e).prop('disabled', false);
            });
        }
    });
}

function getActualizarPagosVentaFinalizada(e, venta_id) {
    $.ajax({
        url: "user/ventas/getActualizarPagosVentaFinalizada",
        type: "GET",
        data:{venta_id: venta_id},
    }).done(function(data) {
        if (data.success != true)
            return msg.warning(data, 'Advertencia!');

        $('.modal-body').html(data.view);
        $('.modal-title').text('Actualizar pagos Venta');
        $('.bs-modal').modal('show');
    });
}

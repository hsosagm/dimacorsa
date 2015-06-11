$(function() {
	$(document).on('submit','form[data-remote-OverdueBalance]', function(e){ OverdueBalancePay(e,this); });
    $(document).on('submit','form[data-remote-FullBalance]'   , function(e){ FullBalancePay(e,this); });
	$(document).on('submit','form[data-remote-PartialBalance]'   , function(e){ PartialBalancePay(e,this); });
    $(document).on('submit','form[data-remote-AbonarCompra]'   , function(e){ IngresarAbonoAlaCompra(e,this); });
});

function OverdueBalancePay(e , element)
{ 
	form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');

    $.ajax({
            type: "POST",
            url:  "admin/compras/payments/OverdueBalancePay",
            data: form.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                if (data.success == true) 
                {
                	msg.success('Saldo vencido abonado con exito..!', 'Listo!');
                	$('.abonosDetalle_detail').html(data.detalle)
                	$('#saldo_total').hide();
                	$('#saldo_parcial').hide();
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

function FullBalancePay(e , element)
{
	form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');

    $.ajax({
            type: "POST",
            url:  "admin/compras/payments/FullBalancePay",
            data: form.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                if (data.success == true) 
                {
                	msg.success('Saldo total abonado con exito..!', 'Listo!');
                	$('.abonosDetalle_detail').html(data.detalle)
                	$('#saldo_vencido').hide();
                	$('#saldo_parcial').hide();
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

function PartialBalancePay(e , element)
{
    form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');

    $.ajax({
            type: "POST",
            url:  "admin/compras/payments/PartialBalancePay",
            data: form.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                if (data.success == true) 
                {
                    msg.success('Saldo parcial abonado con exito..!', 'Listo!');
                    $('.abonosDetalle_detail').html(data.detalle)
                    $('#saldo_vencido').hide();
                    $('#saldo_total').hide();
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


function IngresarAbonoAlaCompra(e , element)
{
    form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');

    $.ajax({
            type: "POST",
            url:  "admin/compras/payments/AbonarCompra",
            data: form.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                if (data.success == true) 
                {
                    msg.success('Compra abonada con exito..!', 'Listo!');
                     $('.modal-body').html(data.detalle);
                     $('.modal-title').text('Abonar a Proveedor');
                     $('.bs-modal').modal('show');
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
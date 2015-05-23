$(function() {
	$(document).on('submit','form[data-remote-OverdueBalance]', function(e){ OverdueBalancePay(e,this); });
	$(document).on('submit','form[data-remote-FullBalance]'   , function(e){ OverdueBalancePay(e,this); });
});

function OverdueBalancePay(e , element)
{
	form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');

    $.ajax({
            type: "POST",
            url:  "admin/proveedor/OverdueBalancePay",
            data: form.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                if (data.success == true) 
                {
                	msg.success('Saldo vencido abonado con exito..!', 'Listo!');
                	$('.OverdueBalance_Details').html(data.detalle)
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
            url:  "admin/proveedor/FullBalancePay",
            data: form.serialize(),
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                if (data.success == true) 
                {
                	msg.success('Saldo total abonado con exito..!', 'Listo!');
                	$('.FullBalance_Details').html(data.detalle)
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

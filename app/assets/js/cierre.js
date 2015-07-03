$(function() {
	$(document).on('click', '#CierreDelDia', function(){ CierreDelDia(this); });
});

function CierreDelDia()
{
	$.get( "admin/cierre/CierreDelDia", function( data ) {
		$('.modal-body').html(data);
		$('.modal-title').text('Cierre del Dia');
		$('.bs-modal').modal('show');
	});

}

function CierreDelMes()
{
	$.get( "admin/cierre/CierreDelMes", function( data ) {
		generate_dt_local(data);
		$('.dt-container').show();
	});

}

function imprimir_cierre()
{
	$.get( "admin/cierre/CierreDelDia", function( data ) {
		$('#print_barcode').html(data);
		$("#print_barcode").show();
		$.print("#print_barcode");
		$("#print_barcode").hide();
	});
}

function cierre() {
	$.get( "admin/cierre/cierre", function( data ) {
    	if ( data.success == true ) {
			$('.modal-body').html(data.form);
			$('.modal-title').text('Cierre del Dia');
			return $('.bs-modal').modal('show');
    	};
    	return msg.error('El cierre ya ha sido realizado por' + " " + data.user, 'Error!');
	});	
}

function CierreDelDiaPorFecha()
{
	fecha = $(".datepicker .calendar .days .selected").attr('date');

    $.ajax({
        type: "GET",
        url: 'admin/cierre/CierreDelDiaPorFecha',
        data: { fecha:fecha },
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) 
        {
           	$('.modal-body').html(data);
			$('.modal-title').text('Cierre del Dia');
			$('.bs-modal').modal('show');
        }
    });

}

function CierreDelMesPorFecha()
{
	fecha = $(".datepicker .calendar .days .selected").attr('date');

    $.ajax({
        type: "GET",
        url: 'admin/cierre/CierreDelMesPorFecha',
        data: { fecha:fecha },
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) 
        {
           	generate_dt_local(data);
			$('.dt-container').show();
        }
    });
}

function CierresDelMes()
{
	fecha = $(".datepicker .calendar .days .selected").attr('date');

    $.ajax({
        type: "GET",
        url: 'admin/cierre/CierresDelMes',
        data: { fecha:fecha },
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) 
        {
			 makeTable(data, '', '');
        }
    });
}

function VerDetalleDelCierreDelDia(e) {

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
                ObtenerDetalleDelCierreDelDia(e);
            })
        }
        else
        {
            ObtenerDetalleDelCierreDelDia(e);
        }
    }
}

function ObtenerDetalleDelCierreDelDia(e) {

    $id = $(e).closest('tr').attr('id');
    $('.subtable').remove();
    var nTr = $(e).parents('tr')[0];
    $(e).addClass('hide_detail');
    $(nTr).after("<tr class='subtable'> <td colspan=5><div class='grid_detalle_factura'></div></td></tr>");
    $('.subtable').addClass('hide_detail');
    $.ajax({
        type: 'GET',
        url: "admin/cierre/VerDetalleDelCierreDelDia",
        data: { cierre_id: $id},
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

function ImprimirCierreDelDia_dt(e,user)
{
    id = $(e).closest('tr').attr('id');
    var md5 = $.md5('encript'+user); 

     window.open('admin/cierre/ImprimirCierreDelDia_dt/'+md5+'/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

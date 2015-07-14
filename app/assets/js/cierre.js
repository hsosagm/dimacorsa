$(function() {
	$(document).on('click', '#CierreDelDia', function(){ CierreDelDia(this); });
});

function CierreDelDia() {
	$.get( "admin/cierre/CierreDelDia", function( data ) {
		$('.dt-container-cierre').html(data);
        $('.dt-container').hide();
        $('.dt-container-cierre').show();
	}); 
}

function CierreDelMes() {
	$.get( "admin/cierre/CierreDelMes", function( data ) {
		$('.dt-container-cierre').html(data);
        $('.dt-container').hide();
        $('.dt-container-cierre').show();
	});
}

function imprimir_cierre() {
	$.get( "admin/cierre/CierreDelDia", function( data ) {
		$('#print_barcode').html(data);
		$("#print_barcode").show();
		$.print("#print_barcode");
		$("#print_barcode").hide();
	});
}

function imprimir_cierre_por_fecha(fecha) {
    $.ajax({
        type: "GET",
        url: 'admin/cierre/CierreDelDiaPorFecha',
        data: { fecha:fecha },
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) {
            $('#print_barcode').html(data);
            $("#print_barcode").show();
            $.print("#print_barcode");
            $("#print_barcode").hide();
        }
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

function CierreDelDiaPorFecha() {
	fecha = $(".datepicker .calendar .days .selected").attr('date');

    $.ajax({
        type: "GET",
        url: 'admin/cierre/CierreDelDiaPorFecha',
        data: { fecha:fecha },
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) {
            $('.dt-container-cierre').html(data);
            $('.dt-container').hide();
            $('.dt-container-cierre').show();
        }
    });
}

function CierreDelMesPorFecha() {
	fecha = $(".datepicker .calendar .days .selected").attr('date');

    $.ajax({
        type: "GET",
        url: 'admin/cierre/CierreDelMesPorFecha',
        data: { fecha:fecha },
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) {
           	$('.dt-container-cierre').html(data);
            $('.dt-container').hide();
            $('.dt-container-cierre').show();
        }
    });
}

function CierresDelMes() {
	fecha = $(".datepicker .calendar .days .selected").attr('date');

    $.ajax({
        type: "GET",
        url: 'admin/cierre/CierresDelMes',
        data: { fecha:fecha },
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) {
			 makeTable(data, '', '');
        }
    });
}

function VerDetalleDelCierreDelDia(e) {
    if ($(e).hasClass("hide_detail")) {
        $(e).removeClass('hide_detail');
        $('.subtable').hide();
    } 

    else {
        $('.hide_detail').removeClass('hide_detail');

        if ( $( ".subtable" ).length ) {
            $('.subtable').fadeOut('slow', function() {
                ObtenerDetalleDelCierreDelDia(e);
            })
        }
        else {
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
            if (data.success == true) {
                $('.grid_detalle_factura').html(data.table);
                $(nTr).next('.subtable').fadeIn('slow');
                $(e).addClass('hide_detail');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}

function ExportarCierreDelDia(tipo,fecha) {
    window.open('admin/cierre/ExportarCierreDelDia/'+tipo+'/'+fecha ,'_blank');
}

var cierre_fecha_enviar = "current_date";
var cierre_metodo_pago_id = 1;

function VentasPorMetodoDePago(page , sSearch) {
    $.ajax({
        type: 'GET',
        url: "user/ventas/VentasPorMetodoDePago?page=" + page,
        data: {sSearch: sSearch , metodo_pago_id : cierre_metodo_pago_id , fecha: cierre_fecha_enviar },
        success: function (data) {
            if (data.success == true) {
                $('#modal-body-cierre').html(data.table);
                $('#modal-title-cierre').text( 'Ventas filtradas por metodo de pago' );
                $('#bs-modal-cierre').modal('show');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}

$(document).on('click', '.pagination_cierre a', function (e) {
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    VentasPorMetodoDePago(page,null);
});

function ocultarMostrarDetalleCierre(e) {
    if($(e).hasClass('fa fa-angle-down'))
        $(e).attr('class', 'fa fa-angle-up');   
    else
        $(e).attr('class', 'fa fa-angle-down');

    $('.cierre_detalle').toggle('slow');
}

function VentasDelMesCierre(e,fecha) {
    $.ajax({
        type: "GET",
        url: 'admin/cierre/VentasDelMes',
        data: { fecha:fecha },
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) {
            makeTable(data, '', '');
        }
    });
}

function SoporteDelMesCierre(e,fecha) {
     $.ajax({
        type: "GET",
        url: 'admin/cierre/SoportePorFecha',
        data: { fecha:fecha  },
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) {
            makeTable(data, '', '');
        }
    });
}

function GastosDelMesCierre(e,fecha) {
    $.ajax({
        type: "GET",
        url: 'admin/cierre/GastosPorFecha',
        data: { fecha:fecha },
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) {
            makeTable(data, '', '');
        }
    });
}

function DetalleDeVentasPorProducto(e)
{
    if ($(e).hasClass("hide_detail"))  {
        $(e).removeClass('hide_detail');
        $('.subtable').fadeOut('slow');
    } 
    else {
        $('.hide_detail').removeClass('hide_detail');

        if ( $( ".subtable" ).length ) {
            $('.subtable').fadeOut('slow', function(){
                getDetalleDeVentasPorProducto(e);
            })
        }
        else {
            getDetalleDeVentasPorProducto(e);
        }
    }
}

function getDetalleDeVentasPorProducto(e) {
    $id = $(e).closest('tr').attr('id');
    $fecha = $(e).attr('fecha');

    $('.subtable').remove();
    var nTr = $(e).parents('tr')[0];
    $(e).addClass('hide_detail');
    $(nTr).after("<tr class='subtable'> <td colspan=8><div class='grid_detalle_factura'></div></td></tr>");
    $('.subtable').addClass('hide_detail');

    $.ajax({
        type: 'GET',
        url: "admin/cierre/DetalleDeVentasPorProducto",
        data: { producto_id: $id , fecha:$fecha},
        success: function (data) {
            if (data.success == true) {
                $('.grid_detalle_factura').html(data.table);
                $(nTr).next('.subtable').fadeIn('slow');
                $(e).addClass('hide_detail');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}
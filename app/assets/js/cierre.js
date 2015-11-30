$(function() {
	$(document).on('click', '#CierreDelDia', function(){ CierreDelDia(this); });
});

function CierreDelDia() {
	$.get( "admin/cierre/CierreDelDia", function( data ) {
		clean_panel();
        $('#graph_container').show();
        $('#graph_container').html(data);
	});
};
 
function CierreDelMes() {
	$.get( "admin/cierre/CierreDelMes", function( data ) {
		clean_panel();
        $('#graph_container').show();
        $('#graph_container').html(data);
	});
};

function cierre() {
	$.get( "admin/cierre/cierre", function( data ) {
    	if ( data.success == true ) {
			$('.modal-body').html(data.form);
			$('.modal-title').text('Cierre del Dia');
			return $('.bs-modal').modal('show');
    	};
    	return msg.error('El cierre ya ha sido realizado por' + " " + data.user, 'Error!');
	});
};

function CierreDelDiaPorFecha(e) {
	$fecha_completa = $(e).closest('tr').find("td").eq(3).html();
    $fecha = $fecha_completa.substring(0, 10);
    $.ajax({
        type: "GET",
        url: 'admin/cierre/CierreDelDiaPorFecha',
        data: { fecha:$fecha },
        success: function (data, text) {
            clean_panel();
            $('#graph_container').show();
            $('#graph_container').html(data);
        }
    });
};

function CierreDelMesPorFecha() {
	fecha = $(".datepicker .calendar .days .selected").attr('date');
    $.ajax({
        type: "GET",
        url: 'admin/cierre/CierreDelMesPorFecha',
        data: { fecha:fecha },
        success: function (data, text) {
           	$('.dt-container-cierre').html(data);
            $('.dt-container').hide();
            $('.dt-container-cierre').show();
        }
    });
};

function CierresDelMes() {
    $.ajax({
        type: "GET",
        url: 'admin/cierre/CierresDelMes',
	}).done(function(data) {
		if (data.success == true)
		{
			clean_panel();
			$('#graph_container').show();
			return $('#graph_container').html(data.view);
		}
		msg.warning(data, 'Advertencia!');
	});
};

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
};

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
};

function ExportarCierreDelDia(tipo,fecha) {
    window.open('admin/cierre/ExportarCierreDelDia/'+tipo+'/'+fecha ,'_blank');
};

var cierre_fecha_enviar = "current_date";
var cierre_metodo_pago_id = 1;
var cierre_producto_id = 1 ;
var cierre_model = "" ;

function asignarInfoEnviar($v_model ,$v_metodo){
    cierre_model= $v_model;
    cierre_metodo_pago_id = $v_metodo;
    cierreConsultasPorMetodoDePago(1 , null);
};

function cierreConsultasPorMetodoDePago(page , sSearch) {
    $.ajax({
        type: 'GET',
        url: "admin/cierre/consultas/ConsultasPorMetodoDePago/"+cierre_model+"?page=" + page,
        data: {sSearch: sSearch , metodo_pago_id : cierre_metodo_pago_id , fecha: cierre_fecha_enviar },
        success: function (data) {
            if (data.success == true) {
                $('#modal-body-cierre').html(data.table);
                $('#modal-title-cierre').text( cierre_model+' filtradas por metodo de pago' );
                $('#bs-modal-cierre').modal('show');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
};

$(document).on('click', '.pagination_cierre a', function (e) {
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    cierreConsultasPorMetodoDePago(page,null);
});

function ocultarMostrarDetalleCierre(e) {
    if($(e).hasClass('fa fa-angle-down'))
        $(e).attr('class', 'fa fa-angle-up');
    else
        $(e).attr('class', 'fa fa-angle-down');

    $('.cierre_detalle').toggle('slow');
};

function VentasDelMesCierre(e,fecha) {
    $.ajax({
        type: "GET",
        url: 'admin/cierre/VentasDelMes',
        data: { fecha:fecha },
        success: function (data, text) {
            makeTable(data, '', '');
        }
    });
};

function SoporteDelMesCierre(e,fecha) {
     $.ajax({
        type: "GET",
        url: 'admin/cierre/SoportePorFecha',
        data: { fecha:fecha  },
        success: function (data, text) {
            makeTable(data, '', '');
        }
    });
};

function GastosDelMesCierre(e,fecha) {
    $.ajax({
        type: "GET",
        url: 'admin/cierre/GastosPorFecha',
        data: { fecha:fecha },
        success: function (data, text) {
            makeTable(data, '', '');
        }
    });
};

function DetalleDeVentasPorProducto(e)
{
    cierre_fecha_enviar = $(e).attr('fecha');
    cierre_producto_id = $(e).closest('tr').attr('id');
    if ($(e).hasClass("hide_detail"))  {
        $(e).removeClass('hide_detail');
        $('.subtable').fadeOut('slow');
    }
    else {
        $('.hide_detail').removeClass('hide_detail');

        if ( $( ".subtable" ).length ) {
            $('.subtable').fadeOut('slow', function(){
                getDetalleDeVentasPorProducto(e, 1 , null);
            })
        }
        else {
            getDetalleDeVentasPorProducto(e, 1 , null);
        }
    }
};

function getDetalleDeVentasPorProducto(e , page , sSearch) {
    $('.subtable').remove();
    var nTr = $(e).parents('tr')[0];
    $(e).addClass('hide_detail');
    $(nTr).after("<tr class='subtable'> <td colspan=9><div class='grid_detalle_factura'></div></td></tr>");
    $('.subtable').addClass('hide_detail');

    $.ajax({
        type: 'GET',
        url: "admin/cierre/DetalleDeVentasPorProducto?page=" + page,
        data: { producto_id: cierre_producto_id , fecha:cierre_fecha_enviar , sSearch:sSearch},
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
};

function getDetalleDeVentasPorProductoPaginacion(page , sSearch) {
    $.ajax({
        type: 'GET',
        url: "admin/cierre/DetalleDeVentasPorProducto?page=" + page,
        data: { producto_id: cierre_producto_id , fecha:cierre_fecha_enviar , sSearch:sSearch},
        success: function (data) {
            if (data.success == true) {
                $('.grid_detalle_factura').html(data.table);
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
};

$(document).on('click', '.pagination_cierre_ventas a', function (e) {
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    getDetalleDeVentasPorProductoPaginacion(page,null);
});

function DetalleVentaCierre(e, venta_id) {
    $.ajax({
        type: 'GET',
        url: "admin/cierre/DetalleVentaCierre",
        data: {venta_id:venta_id },
        success: function (data) {
            if (data.success == true) {
                $('#modal-body-cierre').html(data.table);
                $('#modal-title-cierre').text( 'Detalle de Venta' );
                $('#bs-modal-cierre').modal('show');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
};

function mostrar_view_graficas()
{
    clean_panel();
    $('.dt-container').show();
    $('.table').html($('.graficas_auxiliar').html());
};

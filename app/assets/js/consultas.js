/* Consultas.js */
$(function() 
{
    $(document).on('click', '#OpenTableSupportDay', 		function() { OpenTableSupportDay(this); 		}); 
    $(document).on('click', '#OpenTableExpensesDay', 		function() { OpenTableExpensesDay(this); 		}); 
    $(document).on('click', '#OpenTableExpendituresDay', 	function() { OpenTableExpendituresDay(this); 	}); 
    $(document).on('click', '#OpenTableIncomeDay', 			function() { OpenTableIncomeDay(this); 			}); 
    $(document).on('click', '#OpenTableAdvancesDay',        function() { OpenTableAdvancesDay(this);        }); 
    $(document).on('click', '#OpenTableDownloadsDay',       function() { OpenTableDownloadsDay(this);        }); 
});

function OpenTableSupportDay() {
	$.get( "user/soporte/OpenTableSupportDay", function( data ) {
        makeTable(data, 'user/soporte/', '');
    });
}

function OpenTableExpensesDay() {
	$.get( "user/gastos/OpenTableExpensesDay", function( data ) {
        makeTable(data, 'user/gastos/', '');
    });
}

function OpenTableExpendituresDay() {
	$.get( "user/egresos/OpenTableExpendituresDay", function( data ) {
        makeTable(data, 'user/egresos/', '');
    });
}

function OpenTableIncomeDay() {
	$.get( "user/ingresos/OpenTableIncomeDay", function( data ) {
        makeTable(data, 'user/ingresos/', '');
    });
}

function OpenTableAdvancesDay() {
    $.get( "user/adelantos/OpenTableAdvancesDay", function( data ) {
        makeTable(data, 'user/adelantos/', '');
    });
}

function OpenTableDownloadsDay() {
    $.get( "admin/descargas/OpenTableDownloadsDay", function( data ) {
        makeTable(data, 'admin/descargas/', '');
    });
}

function SoportePorFecha(element) {
    fecha = $(".datepicker .calendar .days .selected").attr('date');
    consulta = $(element).attr('consulta');

    $.ajax({
        type: "GET",
        url: 'user/soporte/SoportePorFecha',
        data: { fecha:fecha , consulta:consulta },
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) {
            makeTable(data, '', '');
        }
    });
}

function GastosPorFecha(element) {
    fecha = $(".datepicker .calendar .days .selected").attr('date');
    consulta = $(element).attr('consulta');

    $.ajax({
        type: "GET",
        url: 'user/gastos/GastosPorFecha',
        data: { fecha:fecha , consulta:consulta },
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) {
            makeTable(data, '', '');
        }
    });
}

function EgresosPorFecha(element) {
    fecha = $(".datepicker .calendar .days .selected").attr('date');
    consulta = $(element).attr('consulta');

    $.ajax({
        type: "GET",
        url: 'user/egresos/EgresosPorFecha',
        data: { fecha:fecha , consulta:consulta },
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) {
            makeTable(data, '', '');
        }
    });
}

function IngresosPorFecha(element) {
    fecha = $(".datepicker .calendar .days .selected").attr('date');
    consulta = $(element).attr('consulta');

    $.ajax({
        type: "GET",
        url: 'user/ingresos/IngresosPorFecha',
        data: { fecha:fecha , consulta:consulta },
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) {
            makeTable(data, '', '');
        }
    });
} 

function AdelantosPorFecha(element) {
    fecha = $(".datepicker .calendar .days .selected").attr('date');
    consulta = $(element).attr('consulta');

    $.ajax({
        type: "GET",
        url: 'user/adelantos/AdelantosPorFecha',
        data: { fecha:fecha , consulta:consulta },
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) {
            makeTable(data, '', '');
        }
    });
}

function OpenTableDownloadsForDate(element) {
    fecha = $(".datepicker .calendar .days .selected").attr('date');
    consulta = $(element).attr('consulta');

    $.ajax({
        type: "GET",
        url: 'admin/descargas/OpenTableDownloadsForDate',
        data: { fecha:fecha , consulta:consulta },
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) {
            makeTable(data, '', '');
        }
    });
}

function AbonosDelDiaProveedores(element) {
    $.get( "admin/proveedor/AbonosDelDia", function( data ) {
        makeTable(data, 'admin/compras/payments/', '');
    });
}

function AbonosPorFechaProveedores(element) {
    fecha = $(".datepicker .calendar .days .selected").attr('date');
    consulta = $(element).attr('consulta');
    $.ajax({
        type: "GET",
        url: 'admin/proveedor/AbonosPorFecha',
        data: { fecha:fecha , consulta:consulta },
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) {
            makeTable(data, '', '');
        }
    });
}

function AbonosDelDiaClientes(element) {
    $.get( "user/cliente/AbonosDelDia", function( data ) {
        makeTable(data, 'admin/proveedor/', '');
    });
}

function AbonosPorFechaClientes(element) {
    fecha = $(".datepicker .calendar .days .selected").attr('date');
    consulta = $(element).attr('consulta');
    $.ajax({
        type: "GET",
        url: 'user/cliente/AbonosPorFecha',
        data: { fecha:fecha , consulta:consulta },
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) {
            makeTable(data, '', '');
        }
    });
}

function getMasterQueries() {
    $('.dt-container').hide();
    $('.table').html("");

    $.ajax({
      url: "admin/queries/getMasterQueries",
      type: "GET"
    }).done(function(data) {
        if (data.success == true) {
            $("#table_length").html("");
            $( ".DTTT" ).html("");
            $('.table').html(data);
            $('.dt-panel').show();
            $('.dt-container').show();
            $('.table').html(data.view);
        }
    });
}

$('[data-action=collapse_head]').click(function(){
    var targetCollapse = $(this).parents('.panel').find('.HeadQueriesContainer');
    if (targetCollapse) {
        if((targetCollapse.is(':visible'))) {
            $(this).find('i').removeClass('fa-angle-up').addClass('fa-angle-down');
            targetCollapse.slideUp();
        }else{
            $(this).find('i').removeClass('fa-angle-down').addClass('fa-angle-up');
            targetCollapse.slideDown();
        }
    }
});

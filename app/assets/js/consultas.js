/* Consultas.js */
 
$(function() 
{
    $(document).on('click', '#OpenTablePurchaseDay', 		function() { OpenTablePurchaseDay(this); 		}); 
    $(document).on('click', '#OpenTableSupportDay', 		function() { OpenTableSupportDay(this); 		}); 
    $(document).on('click', '#OpenTableExpensesDay', 		function() { OpenTableExpensesDay(this); 		}); 
    $(document).on('click', '#OpenTableExpendituresDay', 	function() { OpenTableExpendituresDay(this); 	}); 
    $(document).on('click', '#OpenTableIncomeDay', 			function() { OpenTableIncomeDay(this); 			}); 
    $(document).on('click', '#OpenTableAdvancesDay',        function() { OpenTableAdvancesDay(this);        }); 
    $(document).on('click', '#OpenTableDownloadsDay',       function() { OpenTableDownloadsDay(this);        }); 

});


function OpenTablePurchaseDay()
{
	$.get( "admin/compras/OpenTablePurchaseDay", function( data ) 
	{
        makeTable(data, '', '');
    });
}

function OpenTableSupportDay()
{
	$.get( "user/soporte/OpenTableSupportDay", function( data ) 
	{
        makeTable(data, 'user/soporte/', '');
    });
}

function OpenTableExpensesDay()
{
	$.get( "user/gastos/OpenTableExpensesDay", function( data ) 
	{
        makeTable(data, 'user/gastos/', '');
    });
}

function OpenTableExpendituresDay()
{
	$.get( "user/egresos/OpenTableExpendituresDay", function( data ) 
	{
        makeTable(data, 'user/egresos/', '');
    });
}

function OpenTableIncomeDay()
{
	$.get( "user/ingresos/OpenTableIncomeDay", function( data ) 
	{
        makeTable(data, 'user/ingresos/', '');
    });
}

function OpenTableAdvancesDay()
{
    $.get( "user/adelantos/OpenTableAdvancesDay", function( data ) 
    {
        makeTable(data, 'user/adelantos/', '');
    });
}

function OpenTableDownloadsDay() 
{
    $.get( "admin/descargas/OpenTableDownloadsDay", function( data ) 
    {
        makeTable(data, 'admin/descargas/', '');
    });
}

function OpenTableSalesForDate(element)
{
    fecha = $(".datepicker .calendar .days .selected").attr('date');
    consulta = $(element).attr('consulta');

    $.ajax({
        type: "GET",
        url: 'user/ventas/OpenTableSalesForDate',
        data: { fecha:fecha , consulta:consulta },
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) {
            makeTable(data, '', '');
        }
    });
}

function OpenTablePurchaseForDate(element)
{
    fecha = $(".datepicker .calendar .days .selected").attr('date');
    consulta = $(element).attr('consulta');

    $.ajax({
        type: "GET",
        url: 'admin/compras/OpenTablePurchaseForDate',
        data: { fecha:fecha , consulta:consulta },
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) {
            makeTable(data, '', '');
        }
    });
}

function SoportePorFecha(element)
{
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

function GastosPorFecha(element)
{
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

function EgresosPorFecha(element)
{
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

function IngresosPorFecha(element)
{
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

function AdelantosPorFecha(element)
{
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

function OpenTableDownloadsForDate(element)
{
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


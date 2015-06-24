/* Consultas.js */
 
$(function() 
{
    $(document).on('click', '#OpenTableSalesForDate', 		function() { OpenTableSalesForDate(this); 		}); 
    $(document).on('click', '#OpenTablePurchaseDay', 		function() { OpenTablePurchaseDay(this); 		}); 
    $(document).on('click', '#OpenTablePurchaseForDate', 	function() { OpenTablePurchaseForDate(this); 	}); 
    $(document).on('click', '#OpenTableSupportDay', 		function() { OpenTableSupportDay(this); 		}); 
    $(document).on('click', '#OpenTableSupportForDate', 	function() { OpenTableSupportForDate(this); 	}); 
    $(document).on('click', '#OpenTableExpensesDay', 		function() { OpenTableExpensesDay(this); 		}); 
    $(document).on('click', '#OpenTableExpensesForDate', 	function() { OpenTableExpensesForDate(this); 	}); 
    $(document).on('click', '#OpenTableExpendituresDay', 	function() { OpenTableExpendituresDay(this); 	}); 
    $(document).on('click', '#OpenTableExpendituresForDate',function() { OpenTableExpendituresForDate(this);}); 
    $(document).on('click', '#OpenTableIncomeDay', 			function() { OpenTableIncomeDay(this); 			}); 
    $(document).on('click', '#OpenTableIncomeForDate', 		function() { OpenTableIncomeForDate(this); 		}); 
    $(document).on('click', '#OpenTableAdvancesDay',        function() { OpenTableAdvancesDay(this);        }); 
    $(document).on('click', '#OpenTableAdvancesForDate',    function() { OpenTableAdvancesForDate(this);    }); 
    $(document).on('click', '#OpenTableDownloadsDay',         function() { OpenTableDownloadsDay(this);        }); 
    $(document).on('click', '#OpenTableDownloadsForDate',     function() { OpenTableDownloadsForDate(this);    }); 

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

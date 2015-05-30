 $(function() {
    $(document).on("click", "#VerTablaVentasDelDiaUsuario",   function(){ VerTablaVentasDelDiaUsuario(this);   });
    $(document).on("click", "#VerTablaSoporteDelDiaUsuario",  function(){ VerTablaSoporteDelDiaUsuario(this);  });
    $(document).on("click", "#VerTablaIngresosDelDiaUsuario", function(){ VerTablaIngresosDelDiaUsuario(this); });
    $(document).on("click", "#VerTablaEgresosDelDiaUsuario",  function(){ VerTablaEgresosDelDiaUsuario(this);  });
    $(document).on("click", "#VerTablaGastosDelDiaUsuario",   function(){ VerTablaGastosDelDiaUsuario(this);   });
    $(document).on("click", "#VerTablaAdelantosDelDiaUsuario",function(){ VerTablaAdelantosDelDiaUsuario(this);});
    $(document).on("click", "#VerTablaClientesUsuario",       function(){ VerTablaClientesUsuario(this); });
});

function VerTablaVentasDelDiaUsuario(e)
{
    $.get( "user/consulta/VerTablaVentasDelDiaUsuario", function( data ) 
    {
        makeTable(data, '', 'Ventas del Dia');
    });
}  

function VerTablaSoporteDelDiaUsuario(e)
{
    $.get( "user/consulta/VerTablaSoporteDelDiaUsuario", function( data ) 
    {
        makeTable(data, '', 'Soportes del Dia');
    });
}  

function VerTablaIngresosDelDiaUsuario(e)
{
    $.get( "user/consulta/VerTablaIngresosDelDiaUsuario", function( data ) 
    {
        makeTable(data, '', 'Ingresos del Dia');
    });
} 

function VerTablaEgresosDelDiaUsuario(e)
{
    $.get( "user/consulta/VerTablaEgresosDelDiaUsuario", function( data ) 
    {
        makeTable(data, '', 'Egresos del Dia');
    });
}  

function VerTablaGastosDelDiaUsuario(e)
{
    $.get( "user/consulta/VerTablaGastosDelDiaUsuario", function( data ) 
    {
        makeTable(data, '', 'Gastos del Dia');
    });
}   

function VerTablaAdelantosDelDiaUsuario(e)
{
    $.get( "user/consulta/VerTablaAdelantosDelDiaUsuario", function( data ) 
    {
        makeTable(data, '', 'Adelantos del Dia');
    });
}

function VerTablaClientesUsuario(e)
{
    $.get( "user/consulta/VerTablaClientesUsuario", function( data ) 
    {
        makeTable(data, 'user/cliente/', 'Clientes');
        $('#example').addClass('tableSelected');
    });
} 

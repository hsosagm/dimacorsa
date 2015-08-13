function VerTablaVentasDelDiaUsuario(e) {
    $.get( "user/consulta/VerTablaVentasDelDiaUsuario", function( data ) {
        makeTable(data, '', 'Ventas del Dia');
    });
}  

function VerTablaSoporteDelDiaUsuario(e) {
    $.get( "user/consulta/VerTablaSoporteDelDiaUsuario", function( data ) {
        makeTable(data, '', 'Soportes del Dia');
    });
}  

function VerTablaIngresosDelDiaUsuario(e) {
    $.get( "user/consulta/VerTablaIngresosDelDiaUsuario", function( data ) {
        makeTable(data, '', 'Ingresos del Dia');
    });
} 

function VerTablaEgresosDelDiaUsuario(e) {
    $.get( "user/consulta/VerTablaEgresosDelDiaUsuario", function( data ) {
        makeTable(data, '', 'Egresos del Dia');
    });
}  

function VerTablaGastosDelDiaUsuario(e) {
    $.get( "user/consulta/VerTablaGastosDelDiaUsuario", function( data ) {
        makeTable(data, '', 'Gastos del Dia');
    });
}   

function VerTablaAdelantosDelDiaUsuario(e) {
    $.get( "user/consulta/VerTablaAdelantosDelDiaUsuario", function( data ) {
        makeTable(data, '', 'Adelantos del Dia');
    });
}

function VentasAlCreditoUsuario(e) {
    $(e).prop("disabled", true);

    $.ajax({
        type: 'GET',
        url: "user/consulta/VentasAlCreditoUsuario",
        success: function (data) {
            if (data.success == true) 
                generate_dt_local(data.table);
            else 
                msg.warning('Hubo un error intentelo de nuevo', 'Advertencia!');
        }
    }); 
}

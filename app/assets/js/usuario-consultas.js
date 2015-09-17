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

function getConsultarSerie(e) {
    $.ajax({
        type: "GET",
        url: 'user/consulta/getConsultarSerie',
    }).done(function(data) {
        if (data.success == true)
        {
            clean_panel();
            $('#graph_container').show();
            $('#graph_container').html(data.view);
            return;
        }
        msg.warning(data, 'Advertencia!');
    }); 
} 

function setConsultarSerie(e) {
    $(e).prop("disabled", true);
    $.ajax({
        type: "POST",
        url: 'user/consulta/setConsultarSerie',
        data: { serials: $('.inputSerieParaConsultar').val()},
    }).done(function(data) {
        if (data.success == true)
        {
            $('.resultadoDeBusquedaDeSerie').html(data.view);
            return $(e).prop("disabled", false);
        }
        msg.warning(data, 'Advertencia!');
        return $(e).prop("disabled", false);
    }); 
}

function getConsultarNotasDeCredito(e) {
    $.get( "user/consulta/getConsultarNotasDeCredito", function( data ) {
        makeTable(data, '/user/notaDeCredito/', '');
    });
}
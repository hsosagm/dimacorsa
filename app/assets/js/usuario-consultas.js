function VerTablaVentasDelDiaUsuario(e, tipo) {
    $.ajax({
        type: "GET",
        url: 'user/consulta/VerTablaVentasDelDiaUsuario',
        data: {tipo: tipo}
    }).done(function(data) {
        if (data.success == true)
            return makeTable(data.table, '', 'Ventas');

        msg.warning(data, 'Advertencia!');
    });
};  

function VerTablaSoporteDelDiaUsuario(e, tipo) {
    $.ajax({
        type: "GET",
        url: 'user/consulta/VerTablaSoporteDelDiaUsuario',
        data: {tipo: tipo}
    }).done(function(data) {
        if (data.success == true)
            return makeTable(data.table, '', 'Soportes');

        msg.warning(data, 'Advertencia!');
    });
}; 

function VerTablaIngresosDelDiaUsuario(e, tipo) {
    $.ajax({
        type: "GET",
        url: 'user/consulta/VerTablaIngresosDelDiaUsuario',
        data: {tipo: tipo}
    }).done(function(data) {
        if (data.success == true)
            return makeTable(data.table, '', 'Ingresos');

        msg.warning(data, 'Advertencia!');
    });
}; 

function VerTablaEgresosDelDiaUsuario(e, tipo) {
    $.ajax({
        type: "GET",
        url: 'user/consulta/VerTablaEgresosDelDiaUsuario',
        data: {tipo: tipo}
    }).done(function(data) {
        if (data.success == true)
            return makeTable(data.table, '', 'Egresos');

        msg.warning(data, 'Advertencia!');
    });
};  

function VerTablaGastosDelDiaUsuario(e, tipo) {
    $.ajax({
        type: "GET",
        url: 'user/consulta/VerTablaGastosDelDiaUsuario',
        data: {tipo: tipo}
    }).done(function(data) {
        if (data.success == true)
            return makeTable(data.table, '', 'Gastos');

        msg.warning(data, 'Advertencia!');
    });
};   

function VerTablaAdelantosDelDiaUsuario(e, tipo) {
    $.ajax({
        type: "GET",
        url: 'user/consulta/VerTablaAdelantosDelDiaUsuario',
        data: {tipo: tipo}
    }).done(function(data) {
        if (data.success == true)
            return makeTable(data.table, '', 'Adelantos');

        msg.warning(data, 'Advertencia!');
    });
};

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
};

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
}; 

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
};

function getConsultarNotasDeCredito(e, tipo) {
    $.ajax({
        type: "GET",
        url: 'user/consulta/getConsultarNotasDeCredito',
        data: {tipo: tipo}
    }).done(function(data) {
        if (data.success == true)
            return makeTable(data.table, '/user/notaDeCredito/', 'Notas de Credito');

        msg.warning(data, 'Advertencia!');
    });
};

function VentasSinFinalizar() {
    $.ajax({
        type: "GET",
        url: 'user/consulta/VentasSinFinalizar',
    }).done(function(data) {
        if (data.success == true)
            return makeTable(data.table, '', 'Ventas Sin Finalizar');

        msg.warning(data, 'Advertencia!');
    });
};
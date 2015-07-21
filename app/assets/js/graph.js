$(function() {
    $(document).on("click", "#graph_g", function(){ graph_g(this); });
    $(document).on("click", "#graph_v", function(){ graph_v(this); });
    $(document).on("click", "#graph_s", function(){ graph_s(this); });
});


function graph_g() {
    clean_panel();

    $.get('owner/gastos/form_graph_by_date', function (data) {
        $('.dt-container').show();
        $('.table').html(data);
    }); 
}


function graph_v() {
    clean_panel();

    $.get('owner/chart/ventas', function (data) {
        $('.dt-container').show();
        $('.table').html(data);
    }); 
}


function graph_s() {
    clean_panel();

    $.get('owner/soporte/form_graph_by_date', function (data) {
        $('.dt-container').show();
        $('.table').html(data);
    }); 
}

function chartVentasPorUsuario() {
    $.ajax({
        type: "GET",
        url: 'owner/chart/chartVentasPorUsuario',
    }).done(function(data) {
        if (data.success == true)
        {
            clean_panel();
            $('.dt-container').show();
            return $('.table').html(data.view);
        }
        msg.warning(data, 'Advertencia!');
    }); 
}
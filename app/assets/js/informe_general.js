function getInformeGeneralTabla() {
	$.ajax({
        type: "GET",
        url: "verInformeTabla",
        data: {fecha: 'current_date'},
    }).done(function(data) {
        if (data.success == true) {
			clean_panel();
	        $('#graph_container').show();
	        return $('#graph_container').html(data.view);
        }
        msg.warning(data, "Advertencia!");
    });
};

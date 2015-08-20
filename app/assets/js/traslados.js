$(function() {
    $(document).on("enter", "#serialsDetalleTraslado", function(){ guardarSerieDetalleTraslado(); });
});

function fopen_traslado() {
	$.ajax({
		type: "GET",
		url: 'admin/traslados/create',
	}).done(function(data) {
		if (data.success == true)
		{
			$('.panel-title').text('Formulario Traslados');
			$(".forms").html(data.view);
			$(".dt-container").hide();
			return $(".form-panel").show();
		}
		msg.warning(data, 'Advertencia!');
	});
} 


function eliminarTraslado(e , traslado_id) {
	$.confirm({
		confirm: function(){
			$.ajax({
				type: "POST",
				url: 'admin/traslados/eliminarTraslado',
				data: {traslado_id: traslado_id},
			}).done(function(data) {
				if (data.success == true)
				{
					msg.success('Traslado eliminado', 'Listo!')
					return $(".form-panel").slideUp('slow');
				}
				msg.warning(data, 'Advertencia!');
			});
		}
	});
}

function finalizarTraslado(e , traslado_id) {
	$.confirm({
		text: "esta seguro que desea finalizar el Traslado?",
		title: "Confirmacion",
		confirm: function(){
			$.ajax({
				type: "POST",
				url: 'admin/traslados/finalizarTraslado',
				data: {traslado_id: traslado_id},
			}).done(function(data) {
				if (data.success == true)
				{
					msg.success('Traslado Finalizado', 'Listo!')
					return $(".form-panel").slideUp('slow');
				}
				msg.warning(data, 'Advertencia!');
			});
		}
	});
}

function recibirTraslado(e , traslado_id) {
	$.confirm({
		text: "esta seguro que desea recibir el Traslado?",
		title: "Confirmacion",
		confirm: function(){
			$.ajax({
				type: "POST",
				url: 'admin/traslados/recibirTraslado',
				data: {traslado_id: traslado_id},
			}).done(function(data) {
				if (data.success == true)
				{
					msg.success('Traslado Recibido', 'Listo!')
					return $(".form-panel").slideUp('slow');
				}
				msg.warning(data, 'Advertencia!');
			});
		}
	});
}

function abrirTraslado(e){
	$id = $(e).closest('tr').attr('id');

	$.ajax({
		type: "POST",
		url: 'admin/traslados/abrirTraslado',
		data: {traslado_id: $id},
	}).done(function(data) {
		if (data.success == true)
		{
			$('.panel-title').text('Formulario Traslados');
			$(".forms").html(data.form);
			$(".dt-container").hide();
			return $(".form-panel").show();
		}
		msg.warning(data, 'Advertencia!');
	});
}

function abrirTrasladoDeRecibido(e){
	$id = $(e).closest('tr').attr('id');
	
	$.ajax({
		type: "POST",
		url: 'admin/traslados/abrirTrasladoDeRecibido',
		data: {traslado_id: $id},
	}).done(function(data) {
		if (data.success == true)
		{
			$('.panel-title').text('Recibir Traslados');
			$(".forms").html(data.form);
			$(".dt-container").hide();
			return $(".form-panel").show();
		}
		msg.warning(data, 'Advertencia!');
	});
}

function verDetalleTraslado(e, opcion) {
	if ($(e).hasClass("hide_detail")) {
		$(e).removeClass('hide_detail');
		$('.subtable').hide();
	} 
	else {
		$('.hide_detail').removeClass('hide_detail');

		if ( $( ".subtable" ).length ) {
			$('.subtable').fadeOut('slow', function(){
				getDetalleTraslado(e, opcion);
			})
		}
		else {
			getDetalleTraslado(e, opcion);
		}
	}
}

function getDetalleTraslado(e, opcion) {
	$id = $(e).closest('tr').attr('id');
	$('.subtable').remove();
	var nTr = $(e).parents('tr')[0];
	$(e).addClass('hide_detail');
	$(nTr).after("<tr class='subtable'> <td colspan=6 ><div class='grid_detalle_factura'></div></td></tr>");
	$('.subtable').addClass('hide_detail');

	$.ajax({
		type: "GET",
		url: 'admin/traslados/getDetalleTraslado',
		data: {traslado_id: $id, opcion: opcion},
	}).done(function(data) {
		if (data.success == true)
		{
			$('.grid_detalle_factura').html(data.table);
			$(nTr).next('.subtable').fadeIn('slow');
			return $(e).addClass('hide_detail');
		}
		msg.warning(data, 'Advertencia!');
	});
}

var serialsDetalleTraslado = [];

function ingresarSeriesDetalleTraslado(e, detalle_traslado_id) {
    $.ajax({
        type: "POST",
        url: 'admin/traslados/ingresarSeriesDetalleTraslado',
        data: {detalle_traslado_id: detalle_traslado_id },
    }).done(function(data) {
        if (data.success == true) {
            $('.modal-body').html(data.view);
            $('.modal-title').text( 'Ingresar Series');
            $('.bs-modal').modal('show');
            return $("input[name='serials']").focus();
        }
        msg.warning(data, 'Advertencia!');
    });
}

function guardarSerieDetalleTraslado () {
    if($.trim($("#serialsDetalleTraslado").val()) != ''){
        var ingreso = true;
        $("#listaSeriesDetalleTraslado").html("");

        for (var i = 0; i < serialsDetalleTraslado.length; i++) {
            $value ="'"+serialsDetalleTraslado[i]+"'";
            $tr = '<tr><td>'+serialsDetalleTraslado[i]+'</td>';
            $tr += '<td><i class="fa fa-trash fg-red" onclick="eliminarSerialsDetalleTraslado(this,'+$value+');"></i></td></tr>';
            $("#listaSeriesDetalleTraslado").append($tr);
            if(serialsDetalleTraslado[i] == $("#serialsDetalleTraslado").val())
                ingreso = false
        };

        if(ingreso == true) {
            serialsDetalleTraslado.push($("#serialsDetalleTraslado").val());
            $value ="'"+$("#serialsDetalleTraslado").val()+"'";
            $tr  = '<tr><td>'+$("#serialsDetalleTraslado").val()+'</td>';
            $tr += '<td><i class="fa fa-trash fg-red" onclick="eliminarSerialsDetalleTraslado(this,'+$value+');"></i></td></tr>';
            $("#listaSeriesDetalleTraslado").append($tr);
            msg.success('Serie ingresada..!', 'Listo!');
        }
        else
            msg.warning('La serie ya fue ingresada..!', 'Advertencia!');

        $("#serialsDetalleTraslado").val("");
        $("#serialsDetalleTraslado").focus();
    }
    else
        msg.warning('El campo se encuentra vacio..!', 'Advertencia!');
}

function eliminarSerialsDetalleTraslado(e, serie) {
    serialsDetalleTraslado.splice(serialsDetalleTraslado.indexOf(serie), 1);
    $(e).closest('tr').hide();
    $("#serialsDetalleTraslado").focus();
}

function guardarSeriesDetalleTraslado(e, detalle_traslado_id) {
    $(e).prop("disabled", true);
    $.ajax({
        type: "POST",
        url: 'admin/traslados/ingresarSeriesDetalleTraslado',
        data: {detalle_traslado_id: detalle_traslado_id, guardar:true, serials: serialsDetalleTraslado.join(',') },
    }).done(function(data) {
        if (data.success == true) {
            msg.success('Series Guardadas..!', 'Listo!');
            return $('.bs-modal').modal('hide');
        }
        $(e).prop("disabled", true);
        msg.warning(data, 'Advertencia!');
    });
}

function getTrasladosEnviados(e){
	$.get( "admin/traslados/getTrasladosEnviados", function( data ) {
		makeTable(data, ' ', 'Traslados Enviados');
	});
}

function getTrasladosRecibidos(e){
	$.get( "admin/traslados/getTrasladosRecibidos", function( data ) {
		makeTable(data, ' ', 'Traslados Recibidos');
	});
}

$(function() {
    $(document).on("enter", "#serialsDetalleDescarga", function(){ guardarSerieDetalleDescarga(); });
});

function fopen_descarga() {
	$.get( "admin/descargas/create", function( data ) {
		$('.panel-title').text('Formulario Descargas');
		$(".forms").html(data);
		$(".dt-container").hide();
		$(".form-panel").show();
	});
}

function EliminarDescarga(e , descarga_id) {
	$(e).prop('disabled', true);
	$.confirm({
		confirm: function(){
			$.ajax({
				type: "POST",
				url: 'admin/descargas/delete',
				data: { descarga_id: descarga_id },
				contentType: 'application/x-www-form-urlencoded',
				success: function (data) {
					msg.success('Descarga eliminada', 'Listo!')
					$(".form-panel").slideUp('slow');

				}
			});
		}
	});
}

function showDownloadsDetail(e) {
    if ($(e).hasClass("hide_detail")) {
        $(e).removeClass('hide_detail');
        $('.subtable').hide();
    } 
    else {
        $('.hide_detail').removeClass('hide_detail');

        if ( $( ".subtable" ).length ) {
            $('.subtable').fadeOut('slow', function(){
                getDownloadsDetail(e);
            })
        }
        else {
            getDownloadsDetail(e);
        }
    }
}

function getDownloadsDetail(e) {
    $id = $(e).closest('tr').attr('id');
    $('.subtable').remove();
    var nTr = $(e).parents('tr')[0];
    $(e).addClass('hide_detail');
    $(nTr).after("<tr class='subtable'> <td colspan=7><div class='grid_detalle_factura'></div></td></tr>");
    $('.subtable').addClass('hide_detail');

    $.ajax({
        type: 'GET',
        url: "admin/descargas/showgDownloadsDetail",
        data: { descarga_id: $id},
        success: function (data) {
            if (data.success == true) {
                $('.grid_detalle_factura').html(data.table);
                $(nTr).next('.subtable').fadeIn('slow');
                $(e).addClass('hide_detail');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}

function OpenDownload(e)
{
	$id = $(e).closest('tr').attr('id');

	$.ajax({
        type: 'GET',
        url: "admin/descargas/OpenDownload",
        data: { descarga_id: $id},
        success: function (data) {
            if (data.success == true) {
            	$('.panel-title').text('Formulario Descargas');
				$(".forms").html(data.detalle);
				$(".dt-container").hide();
				$(".form-panel").show();
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}

function FinalizarDescarga() {
	$(".form-panel").slideUp('slow');	
}

function IngresarDescripcionDescarga( e , descarga_id) {
    $.ajax({
        type: 'GET',
        url: "admin/descargas/descripcion",
        data: { descarga_id: descarga_id},
        success: function (data) {
            if (data.success == true) {
                $('.modal-body').html(data.data);
                $('.modal-title').text('Ingresar Descripcion');
                $('.bs-modal').modal('show');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });

    return false;
}

var serialsDetalleDescarga = [];

function ingresarSeriesDetalleDescarga(e, detalle_descarga_id) {
    $.ajax({
        type: "POST",
        url: 'admin/descargas/ingresarSeriesDetalleDescarga',
        data: {detalle_descarga_id: detalle_descarga_id },
    }).done(function(data) {
        if (data.success == true) {
            $('.modal-body').html(data.view);
            $('.modal-title').text( 'Ingresar Series');
            return $('.bs-modal').modal('show');
        }
        msg.warning(data, 'Advertencia!');
    });
}

function guardarSerieDetalleDescarga () {
    if($.trim($("#serialsDetalleDescarga").val()) != ''){
        var ingreso = true;
        $("#listaSeriesDetalleDescarga").html("");

        for (var i = 0; i < serialsDetalleDescarga.length; i++) {
            $value ="'"+serialsDetalleDescarga[i]+"'";
            $tr = '<tr><td>'+serialsDetalleDescarga[i]+'</td>';
            $tr += '<td><i class="fa fa-trash fg-red" onclick="eliminarSerialsDetalleDescarga(this,'+$value+');"></i></td></tr>';
            $("#listaSeriesDetalleDescarga").append($tr);
            if(serialsDetalleDescarga[i] == $("#serialsDetalleDescarga").val())
                ingreso = false
        };

        if(ingreso == true) {
            serialsDetalleDescarga.push($("#serialsDetalleDescarga").val());
            $value ="'"+$("#serialsDetalleDescarga").val()+"'";
            $tr  = '<tr><td>'+$("#serialsDetalleDescarga").val()+'</td>';
            $tr += '<td><i class="fa fa-trash fg-red" onclick="eliminarSerialsDetalleDescarga(this,'+$value+');"></i></td></tr>';
            $("#listaSeriesDetalleDescarga").append($tr);
            msg.success('Serie ingresada..!', 'Listo!');
        }
        else
            msg.warning('La serie ya fue ingresada..!', 'Advertencia!');

        $("#serialsDetalleDescarga").val("");
        $("#serialsDetalleDescarga").focus();
    }
    else
        msg.warning('El campo se encuentra vacio..!', 'Advertencia!');
}

function eliminarSerialsDetalleDescarga(e, serie) {
    serialsDetalleDescarga.splice(serialsDetalleDescarga.indexOf(serie), 1);
    $(e).closest('tr').hide();
    $("#serialsDetalleDescarga").focus();
}

function guardarSeriesDetalleDescarga(e, detalle_descarga_id) {
    $(e).prop("disabled", true);
    $.ajax({
        type: "POST",
        url: 'admin/descargas/ingresarSeriesDetalleDescarga',
        data: {detalle_descarga_id: detalle_descarga_id, guardar:true, serials: serialsDetalleDescarga.join(',') },
    }).done(function(data) {
        if (data.success == true) {
            msg.success('Series Guardadas..!', 'Listo!');
            return $('.bs-modal').modal('hide');
        }
        $(e).prop("disabled", true);
        msg.warning(data, 'Advertencia!');
    });
}

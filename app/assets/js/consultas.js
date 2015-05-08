/* Consultas.js */

$(function() 
{
    $(document).on('click', '#_v_dia', function()   { _v_dia(this);   }); // Ventas Por Dia
    $(document).on('click', '#_v_mes', function()   { _v_mes(this);   }); // Ventas por Mes
    $(document).on('click', '#_v_fecha', function() { _v_fecha(this); }); // Ventas por Fecha inicio a Fecha final
    $(document).on('click', '#_c_dia', function()   { _c_dia(this);   }); // Compras por dia
    $(document).on('click', '#_c_mes', function()   { _c_mes(this);   }); // Compras por Mes
    $(document).on('click', '#_c_fecha', function() { _c_fecha(this); }); // Compras por Fecha inicio a Fecha final
});

function form_consultas_modal( data )
{
	$('.modal-body').html(data);
	$('.modal-title').text( 'Consultas');
	$('.bs-modal').modal('show');
}

function  _v_dia()
{
	$(".modal-dialog").attr('style', 'width:300px;');

	data ='<div align="center" class="consultas">';
	data+='<table class="master-table"><tr><td>';
	data+='<input type="text" name="input_v_dia" data-value="now()">';
	data+='</td></tr></table> <button class="btn btn-default theme-button">Cargar..</button></div>';

	form_consultas_modal(data);

	$('input[name="input_v_dia"]').pickadate(
	{
		max: true,
	});
}

function  _v_mes()
{

}

function _v_fecha()
{
	$(".modal-dialog").attr('style', 'width:300px ');

	data ='<div align="center" class="consultas">';
	data+='<table class="master-table"><tr><td> del</td><td> ';
	data+='<input type="text" name="input_v_fecha_inicio" data-value="now()"> </td></tr><tr>';
	data+='<td>al</td><td><input type="text" name="input_v_fecha_final" data-value="now()"> ';
	data+='</td></tr></table> <button class="btn btn-default theme-button">Cargar..</button></div>';

	form_consultas_modal(data);

	$('input[name="input_v_fecha_inicio"]').pickadate(
	{
		max: true,
	});

	$('input[name="input_v_fecha_final"]').pickadate(
	{
		max: true,
	});
}

function  _c_dia()
{
	$(".modal-dialog").attr('style', 'width:300px ');

	data ='<div align="center" class="consultas">';
	data+='<table class="master-table"><tr><td>';
	data+='<input type="text" name="input_c_dia" data-value="now()">';
	data+='</td></tr></table> <button class="btn btn-default theme-button">Cargar..</button></div>';

	form_consultas_modal(data);

	$('input[name="input_c_dia"]').pickadate(
	{
		max: true,
	});
}

function  _c_mes()
{

}

function _c_fecha()
{
	$(".modal-dialog").attr('style', 'width:300px ');

	data ='<div align="center" class="consultas">';
	data+='<table class="master-table"><tr><td> del</td><td> ';
	data+='<input type="text" name="input_c_fecha_inicio" data-value="now()"> </td></tr><tr>';
	data+='<td>al</td><td><input type="text" name="input_c_fecha_final" data-value="now()"> ';
	data+='</td></tr></table> <button class="btn btn-default theme-button">Cargar..</button></div>';

	form_consultas_modal(data);

	$('input[name="input_c_fecha_inicio"]').pickadate(
	{
		max: true,
	});
	
	$('input[name="input_c_fecha_final"]').pickadate(
	{
		max: true,
	});
}

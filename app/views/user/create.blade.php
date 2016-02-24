
{{ Form::_open('Usuario creado') }}

{{ Form::_select('tienda_id', Tienda::lists('nombre', 'id')) }}

{{ Form::_text('username') }}

{{ Form::_text('nombre') }}

{{ Form::_text('apellido') }}

<div class="form-group">
{{ Form::label('body', 'Puesto', array('class'=>'col-sm-2 control-label')) }} 
	<div class="col-sm-9 select_marcas">
		{{ Form::select('puesto_id', Puesto::lists('descripcion', 'id'),3, array('class'=>'form-control'));}} 
	</div>
</div>

{{ Form::_text('email') }}

{{ Form::_password('password') }}

<div class="modal-footer">
	<input class="btn theme-button" type="submit" value="Enviar!" autocomplete="off">
</div>

{{ Form::close() }}

<style type="text/css">

	.bs-modal .Lightbox{
		width: 500px !important;
	}

</style>
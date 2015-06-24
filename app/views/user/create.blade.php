
{{ Form::_open('Usuario creado') }}

{{ Form::_select('tienda_id', Tienda::lists('nombre', 'id')) }}

{{ Form::_text('username') }}

{{ Form::_text('nombre') }}

{{ Form::_text('apellido') }}

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
{{ Form::_open('Perfil actualizado') }}

{{ Form::hidden('id', @Auth::user()->id) }}

{{ Form::_text('username', @Auth::user()->username) }}

{{ Form::_text('nombre', @Auth::user()->nombre) }}

{{ Form::_text('apellido', @Auth::user()->apellido) }}

{{ Form::_text('email', @Auth::user()->email) }}

{{ Form::_password('password') }}

<div class="modal-footer">
    <input class="btn theme-button" type="submit" value="Enviar!" autocomplete="off">
</div>

{{ Form::close() }}

<style type="text/css">

    .bs-modal .Lightbox{
        width: 450px !important;
    }

</style>

{{ Form::_open('Usuario creado') }}

    {{ Form::_select('tienda_id', Tienda::lists('nombre', 'id')) }}

    {{ Form::_text('username') }}
  
    {{ Form::_text('nombre') }}

    {{ Form::_text('apellido') }}

    {{ Form::_text('email') }}

    {{ Form::_password('password') }}

    {{ Form::_submit('Enviar') }}

{{ Form::close() }}

<style type="text/css">

    .bs-modal .Lightbox{
        width: 500px !important;
    }

</style>
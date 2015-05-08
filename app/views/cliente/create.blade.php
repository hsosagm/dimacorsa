
{{ Form::_open("Cliente ingresado") }}
    
    {{ Form::_text('nombre') }}

    {{ Form::_text('apellido') }}

    {{ Form::_text('direccion') }}
  
    {{ Form::_text('telefono') }}

    {{ Form::_text('nit') }}

    {{ Form::_text('email') }}

    {{ Form::_submit('Enviar') }}

{{ Form::close() }}
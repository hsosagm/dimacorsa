{{ Form::_open("Cliente actualizado") }}
    
    {{ Form::hidden('id', @$model->id) }}

    {{ Form::_text('nombre', @$model->nombre) }}

    {{ Form::_text('apellido', @$model->apellido) }}

    {{ Form::_text('direccion', @$model->direccion) }}
  
    {{ Form::_text('telefono', @$model->telefono) }}

    {{ Form::_text('nit', @$model->nit) }}

    {{ Form::_text('email', @$model->email) }}

    {{ Form::_submit('Enviar') }}

{{ Form::close() }}
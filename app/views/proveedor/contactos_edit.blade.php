{{Form::open(array('data-remote-contact-e'))}} 

    {{ Form::hidden('id', @$contacto->id) }}

    <div class="row">
        <div class="col-md-12">{{ Form::text("nombre",@$contacto->nombre , array('placeholder' => 'Nombre'))}}</div>
    </div>

    <div class="row">
        <div class="col-md-12">{{ Form::text("apellido", @$contacto->apellido , array('placeholder' => 'Apellido'))}}</div>
    </div>

    <div class="row">
        <div class="col-md-12">{{ Form::text("direccion", @$contacto->direccion , array('placeholder' => 'Direcion'))}}</div>
    </div>

    <div class="row">
        <div class="col-md-12">{{ Form::text("telefono1", @$contacto->telefono1 , array('placeholder' => 'Telefono1'))}}</div>
    </div>

    <div class="row">
        <div class="col-md-12">{{ Form::text("telefono2", @$contacto->telefono2 , array('placeholder' => 'Telefono2'))}}</div>
    </div>

    <div class="row">
        <div class="col-md-12">{{ Form::text("celular", @$contacto->celular , array('placeholder' => 'Celular'))}}</div>
    </div>

    <div class="row">
        <div class="col-md-12">{{ Form::text("correo", @$contacto->correo , array('placeholder' => 'Correo'))}}</div>
    </div>

    <div style="" class="proveedor-footer">
        <button class="btn btn-default" onclick="clear_contacto_body();" type="button">Cancelar!</button>
        <input class="btn theme-button" value="Guardar!" type="submit">
    </div>

{{Form::close()}}
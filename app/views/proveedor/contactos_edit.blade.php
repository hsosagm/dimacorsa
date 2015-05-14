{{Form::open(array('data-remote-contact-e'))}} 

    {{ Form::hidden('id', @$contacto->id) }}

    <div class="row">
        <div class="col-md-3">Nombre</div>
        <div class="col-md-9">{{ Form::text("nombre",@$contacto->nombre , array())}}</div>
    </div>

    <div class="row">
        <div class="col-md-3">Apellido</div>
        <div class="col-md-9">{{ Form::text("apellido", @$contacto->apellido , array())}}</div>
    </div>

    <div class="row">
        <div class="col-md-3">Direcion</div>
        <div class="col-md-9">{{ Form::text("direccion", @$contacto->direccion , array())}}</div>
    </div>

    <div class="row">
        <div class="col-md-3">Telefono1</div>
        <div class="col-md-9">{{ Form::text("telefono1", @$contacto->telefono1 , array())}}</div>
    </div>

    <div class="row">
        <div class="col-md-3">Telefono2</div>
        <div class="col-md-9">{{ Form::text("telefono2", @$contacto->telefono2 , array())}}</div>
    </div>

    <div class="row">
        <div class="col-md-3">Celular</div>
        <div class="col-md-9">{{ Form::text("celular", @$contacto->celular , array())}}</div>
    </div>

    <div class="row">
        <div class="col-md-3">Correo</div>
        <div class="col-md-9">{{ Form::text("correo", @$contacto->correo , array())}}</div>
    </div>

    <div style="" class="modal-footer">
        <button class="btn btn-default" onclick="clear_contacto_body();" type="button">Cerrar!</button>
        <input class="btn theme-button" value="Guardar!" type="submit">
    </div>

{{Form::close()}}
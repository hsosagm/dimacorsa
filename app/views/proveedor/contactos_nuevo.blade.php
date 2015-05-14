{{Form::open(array('data-remote-contact-n'))}} 

    <div class="row">
        <div class="col-md-3">Nombre</div>
        <div class="col-md-9">{{ Form::text("nombre", "" , array())}}</div>
    </div>

    <div class="row">
        <div class="col-md-3">Apellido</div>
        <div class="col-md-9">{{ Form::text("apellido", "" , array())}}</div>
    </div>

    <div class="row">
        <div class="col-md-3">Direcion</div>
        <div class="col-md-9">{{ Form::text("direccion", "" , array())}}</div>
    </div>

    <div class="row">
        <div class="col-md-3">Telefono1</div>
        <div class="col-md-9">{{ Form::text("telefono1", "" , array())}}</div>
    </div>

    <div class="row">
        <div class="col-md-3">Telefono2</div>
        <div class="col-md-9">{{ Form::text("telefono2", "" , array())}}</div>
    </div>

    <div class="row">
        <div class="col-md-3">Celular</div>
        <div class="col-md-9">{{ Form::text("celular", "" , array())}}</div>
    </div>

    <div class="row">
        <div class="col-md-3">Correo</div>
        <div class="col-md-9">{{ Form::text("correo", "" , array())}}</div>
    </div>

     <div style="" class="modal-footer">
        <button class="btn btn-default" onclick="clear_contacto_body();" type="button">Cerrar!</button>
        <input class="btn theme-button" value="Guardar!" type="submit">
    </div>

{{ Form::close() }}
{{ Form::hidden('id', @$contacto->id) }}

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-2">Nombre</div>
    <div class="col-md-7">{{ Form::text("nombre",@$contacto->nombre , array())}}</div>
</div>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-2">Apellido</div>
    <div class="col-md-7">{{ Form::text("apellido", @$contacto->apellido , array())}}</div>
</div>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-2">Direcion</div>
    <div class="col-md-7">{{ Form::text("direccion", @$contacto->direccion , array())}}</div>
</div>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-2">Telefono1</div>
    <div class="col-md-7">{{ Form::text("telefono1", @$contacto->telefono1 , array())}}</div>
</div>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-2">Telefono2</div>
    <div class="col-md-7">{{ Form::text("telefono2", @$contacto->telefono2 , array())}}</div>
</div>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-2">Celular</div>
    <div class="col-md-7">{{ Form::text("celular", @$contacto->celular , array())}}</div>
</div>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-2">Correo</div>
    <div class="col-md-7">{{ Form::text("correo", @$contacto->correo , array())}}</div>
</div>
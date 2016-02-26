{{ Form::open(array('url' => '/user/cliente/edit', 'v-on="submit: editCustomer"')) }}
<input type="hidden" name="id" v-model="cliente.id">

<div class="form-group">
    <div class="col-sm-3">
        <h4>Editar cliente</h4>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-5">
        Nombre: <input type="text" name="nombre" style="width: 80% !important;" class="input sm_input" value="@{{ cliente.nombre }}" placeholder="Nombre">
    </div>

    <div class="col-sm-4">
        Direccion: <input type="text" name="direccion" style="width: 76% !important;" class="input sm_input" value="@{{ cliente.direccion }}" placeholder="Direccion">
    </div>
</div>

<div class="form-group">
    <div class="col-sm-3">
        Nit:<input type="text" name="nit" style="width: 85% !important;" class="input sm_input" value="@{{ cliente.nit }}" placeholder="Nit">
    </div>

    <div class="col-sm-3">
        Telefono:<input type="text" name="telefono" style="width: 73% !important;" class="input sm_input" value="@{{ cliente.telefono }}" placeholder="Telefono">
    </div>

    <div class="col-sm-3">
        Correo:<input type="text" name="email" style="width: 75% !important;" class="input sm_input" value="@{{ cliente.email }}" placeholder="Correo">
    </div>
</div>

<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-3"></div>
    <div class="col-sm-3">
        <input class="btn theme-button inputGuardar" value="Guardar!" type="submit" style="margin-left:110px;">
    </div>
</div>
{{ Form::close() }}

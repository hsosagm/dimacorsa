{{ Form::open(array('url' => '/user/cliente/edit', 'v-on="submit: editCustomer"')) }}
<input type="hidden" name="id" v-model="cliente.id">

<div class="form-group">
    <div class="col-sm-3">
        <h4>Editar cliente</h4>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-6">
        <input type="text" name="nombre" style="width: 100% !important;" class="input sm_input" value="@{{ cliente.nombre }}" placeholder="Nombre" autocomplete="off">
    </div>

    <div class="col-sm-3">
        <input type="text" name="direccion" style="width: 100% !important;" class="input sm_input" value="@{{ cliente.direccion }}" placeholder="Direccion" autocomplete="off">
    </div>
</div>

<div class="form-group">
    <div class="col-sm-3">
        <input type="text" name="nit" style="width: 100% !important;" class="input sm_input" value="@{{ cliente.nit }}" placeholder="Nit" autocomplete="off">
    </div>

    <div class="col-sm-3">
        <input type="text" name="telefono" style="width: 100% !important;" class="input sm_input" value="@{{ cliente.telefono }}" placeholder="Telefono" autocomplete="off">
    </div>

    <div class="col-sm-3">
        <input type="text" name="email" style="width: 100% !important;" class="input sm_input" value="@{{ cliente.email }}" placeholder="Correo" autocomplete="off">
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

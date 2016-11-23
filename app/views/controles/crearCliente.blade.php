{{ Form::open(array('url' => '/user/cliente/create', 'v-on="submit: createNewCustomer"')) }}
<div class="form-group">
    <div class="col-sm-3">
        <h4>Nuevo cliente</h4>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-6">
        <input type="text" name="nombre" style="width: 100% !important;" class="input sm_input" placeholder="Nombre" autocomplete="off">
    </div>

    <div class="col-sm-3">
        <input type="text" name="direccion" style="width: 100% !important;" class="input sm_input" placeholder="Direccion" autocomplete="off">
    </div>
</div>

<div class="form-group">
    <div class="col-sm-3">
        <input type="text" name="nit" style="width: 100% !important;" class="input sm_input" placeholder="Nit" autocomplete="off">
    </div>

    <div class="col-sm-3">
        <input type="text" name="telefono" style="width: 100% !important;" class="input sm_input" placeholder="Telefono" autocomplete="off">
    </div>

    <div class="col-sm-3">
        <input type="text" name="email" style="width: 100% !important;" class="sm_input" placeholder="Email" autocomplete="off">
    </div>
</div>

<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-3"></div>
    <div class="col-sm-3">
        <input class="btn theme-button" value="Guardar!" type="submit" style="margin-left:110px;">
    </div>
</div>
{{ Form::close() }}

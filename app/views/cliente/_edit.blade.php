{{ Form::open(array('id' => 'formEditCliente')) }}

    {{ Form::hidden('id', $cliente->id) }}

    <div class="form-group row">
        <div class="col-sm-12">
            <h4>Actualizar cliente</h4>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-6">
            <input type="text" name="nombre" style="width: 100% !important;" value="{{$cliente->nombre}}" class="input sm_input" placeholder="Nombre">
        </div>
        <div class="col-sm-6">
            <input type="text" name="direccion" style="width: 100% !important;" value="{{$cliente->direccion}}" class="input sm_input" placeholder="Direccion">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-4">
            <input type="text" name="nit" style="width: 100% !important;" value="{{$cliente->nit}}" class="input sm_input" placeholder="Nit">
        </div>
        <div class="col-sm-4">
            <input type="text" name="telefono" style="width: 100% !important;" value="{{$cliente->telefono}}" class="input sm_input" placeholder="Telefono">
        </div>
        <div class="col-sm-4">
            <input type="text" name="email" style="width: 100% !important;" value="{{$cliente->email}}" class="sm_input" placeholder="Email">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-9"></div>
        <div class="col-sm-3" style="text-align:right;">
            <button type="button" onclick="guardarClienteActualizadoNotaCredito(this)" class="bg-theme">Actualizar..!</button>
        </div>
    </div>
{{ Form::close() }}


<h4>Editar Proveedor</h4>
<div class="row">
    <div class="col-md-8">
        {{ Form::open(array('data-remote-proveedor-ce','data-success' => 'Perfil Actualizado','url' => 'user/profile', 'method' =>'post', 'role'=>'form', 'class' => 'form-horizontal all')) }}
        {{ Form::hidden('id', @$proveedor->id) }}
        <div class="row">
            <div class="col-md-6">
                <input class="form-control" name="nombre" value="{{ $proveedor->nombre }}" placeholder="Nombre" type="text">
            </div>
            <div class="col-md-6">
                <input class="form-control" name="direccion" value="{{ $proveedor->direccion }}" placeholder="Direccion" type="text">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <input class="form-control" name="nit" value="{{ $proveedor->nit }}" placeholder="Nit" type="text">
            </div>
            <div class="col-md-6">
                <input class="form-control" name="telefono" value="{{ $proveedor->telefono }}" placeholder="Telefono" type="text">
            </div>
        </div>
        <div style="" class="modal-footer">
            <input class="btn theme-button" value="Guardar!" type="submit">
        </div>
        {{ Form::close() }}
    </div>
</div>
<h4>Nuevo Proveedor</h4>
<div class="row">
    <div class="col-md-8">
        {{ Form::open(array('data-remote-proveedor-n','data-success' => 'Perfil Actualizado','url' => 'user/profile', 'method' =>'post', 'role'=>'form', 'class' => 'form-horizontal all')) }}
        <div class="row">
            <div class="col-md-6">
                <input class="form-control" name="nombre" placeholder="Nombre" type="text" autocomplete="off">
            </div>
            <div class="col-md-6">
                <input class="form-control" name="direccion" placeholder="Direccion" type="text" autocomplete="off">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <input class="form-control" name="nit" placeholder="Nit" type="text" autocomplete="off">
            </div>
            <div class="col-md-6">
                <input class="form-control" name="telefono" placeholder="Telefono" type="text" autocomplete="off">
            </div>
        </div>
        <div class="modal-footer">
            <input class="theme-button" style="height:30px" value="Guardar" type="submit">
        </div>
        {{ Form::close() }}
    </div>
</div>

 <div class="cliente-body-info">
    {{ Form::open(array('data-remote-cliente','method' =>'post', 'role'=>'form', 'class' => 'form-horizontal all')) }}

    <div class="form-group">
        <div class="col-sm-12">
            <input class="form-control" name="nombre" value="" placeholder="Nombre" type="text">
        </div>
    </div>
 
    <div class="form-group">
        <div class="col-sm-12">
            <input class="form-control" name="apellido" value="" placeholder="Apellido" type="text">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
            <input class="form-control" name="direccion" value="" placeholder="Direccion" type="text">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
          <input class="form-control" name="nit" value="" placeholder="Nit" type="text">
      </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
          <input class="form-control"  name="telefono" value="" placeholder="Telefono" type="text">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
          <input class="form-control"  name="email" value="" placeholder="Correo" type="text">
        </div>
    </div>

    <div style="" class="modal-footer">
        <input class="btn theme-button" value="Guardar!" type="submit">
    </div>
<br>
{{ Form::close() }}

</div>

<style type="text/css">

    .bs-modal .Lightbox{
        width: 550px !important;
    }
    .modal-body {
    	 height: 350px !important;
    }

</style>
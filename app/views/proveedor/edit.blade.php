
<!-- Start tabs heading -->
<div class="panel-heading no-padding">
    <ul class="nav nav-tabs">
        <li class="active" id="tab-proveedor-informacion">
            <a href="#tab-proveedor-informacion" data-toggle="tab">
                <i class="fa fa-university"></i>
                <span>Informacion Proveedor</span>
            </a>
        </li>
        <li class="" id="tab-proveedor-contactos">
            <a href="#tab-proveedor-contactos" data-toggle="tab">
                <i class="fa fa-users"></i>
                <span>Contactos</span>
            </a>
        </li>
    </ul>
</div><!-- /.panel-heading -->
<!--/ End tabs heading -->

<!-- Start tabs content -->
<div class="proveedor_tabs">
    <div class="tab-content" style="background: white" >
        <div class="tab-pane fade active in" id="tab-proveedor-informacion" style="background:white !important">
            <div class="proveedor-body-info">
            {{ Form::open(array('data-remote-proveedor-e','data-success' => 'Perfil Actualizado','url' => 'user/profile', 'method' =>'post', 'role'=>'form', 'class' => 'form-horizontal all')) }}

            {{ Form::hidden('id', @$proveedor->id) }}

            <div class="form-group">
                <div class="col-sm-7">tab-proveedor-informacion
                    <input class="form-control" name="nombre" value="{{ @$proveedor->nombre }}" placeholder="Nombre" type="text">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-7">
                    <input class="form-control" name="direccion" value="{{ @$proveedor->direccion }}" placeholder="Direccion" type="text">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-7">
                  <input class="form-control" name="nit" value="{{ @$proveedor->nit }}" placeholder="Nit" type="text">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-7">
                  <input class="form-control"  name="telefono" value="{{ @$proveedor->telefono }}" placeholder="Telefon" type="text">
                </div>
            </div>


            <div style="" class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" type="button">Cerrar!</button>
                <input class="btn theme-button" value="Guardar!" type="submit">
            </div>

            {{ Form::close() }}
            </div>

        </div>
        <div class="tab-pane fade" id="tab-proveedor-contactos" style="background:white !important">
                {{ Form::hidden('proveedor_id', @$proveedor->id) }}
                <div class="row">
                    <div class="col-md-4 contactos-lista">
                     <?php  $producto = ProveedorContacto::where('proveedor_id','=', @$proveedor->id)->get(); ?>
                         <ul>
                                @foreach($producto as $key => $dt)
                                    <li contacto_id="{{$dt->id}}"  id="contacto_view" class="btn-link theme-c"> {{ $dt->nombre.' '.$dt->apellido }}</li>
                                @endforeach
                                <br>
                                <i class="btn-link theme-c" id="contacto_nuevo"><i class="fa fa-plus-circle ">  </i> Agregar Contacto</i>
                         </ul>
                    </div>
                    <div class="col-md-8">
                        <div class="body-contactos">
                           
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div> 

<style type="text/css">

   .bs-modal .modal-dialog{
        width: 750px !important;
    }
    
</style>
 
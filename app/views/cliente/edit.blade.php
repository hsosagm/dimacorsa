 
<!-- Start tabs heading -->
<div class="panel-heading no-padding">
    <ul class="nav nav-tabs">
        <li class="active" id="tab-cliente-informacio">
            <a href="#tab-cliente-informacion" data-toggle="tab">
                <i class="fa fa-university"></i>
                <span>Informacion Cliente</span>
            </a>
        </li>
        <li class="" id="tab-cliente-contacto">
            <a href="#tab-cliente-contactos" data-toggle="tab">
                <i class="fa fa-users"></i>
                <span>Contactos</span> &nbsp;&nbsp;&nbsp;
                <i class="btn-link theme-c" id="cliente_contacto_nuevo"><i class="fa fa-plus-circle fa-2">  </i> </i>
            </a>
        </li>
    </ul>
</div><!-- /.panel-heading -->
<!--/ End tabs heading -->

<!-- Start tabs content -->
<div class="cliente_tabs">
    <div class="tab-content" style="background: white" >
        <div class="tab-pane fade active in" id="tab-cliente-informacion" style="background:white !important">
            <div class="cliente-body-info">
            {{ Form::open(array('data-remote-cliente-e','method' =>'post', 'role'=>'form', 'class' => 'form-horizontal all')) }}

            {{ Form::hidden('id', @$cliente->id) }}

            <div class="form-group">
                <div class="col-sm-7">
                    <input class="form-control" name="nombre" value="{{ @$cliente->nombre }}" placeholder="Nombre" type="text">
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-sm-7">
                    <input class="form-control" name="apellido" value="{{ @$cliente->apellido }}" placeholder="Apellido" type="text">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-7">
                    <input class="form-control" name="direccion" value="{{ @$cliente->direccion }}" placeholder="Direccion" type="text">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-7">
                  <input class="form-control" name="nit" value="{{ @$cliente->nit }}" placeholder="Nit" type="text">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-7">
                  <input class="form-control"  name="telefono" value="{{ @$cliente->telefono }}" placeholder="Telefono" type="text">
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-sm-7">
                  <input class="form-control"  name="email" value="{{ @$cliente->email }}" placeholder="Correo" type="text">
                </div>
            </div>

            <div style="" class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" type="button">Cerrar!</button>
                <input class="btn theme-button" value="Guardar!" type="submit">
            </div>

            {{ Form::close() }}
            </div>

        </div>
        <div class="tab-pane fade" id="tab-cliente-contactos" style="background:white !important">
                {{ Form::hidden('cliente_id', @$cliente->id) }}
                <div class="row">
                    <div class="col-md-5 contactos-lista">
                     <?php  $producto = ClienteContacto::where('cliente_id','=', @$cliente->id)->get(); ?>
                         <ul>
                                @foreach($producto as $key => $dt)
                                    <li contacto_id="{{$dt->id}}"  id="cliente_contacto_view" class="btn-link theme-c"> {{ $dt->nombre.' '.$dt->apellido }}</li>
                                @endforeach
                                <br>
                         </ul>
                    </div>
                    <div class="col-md-7">
                        <div class="body-contactos">
                           
                        </div>
                    </div>
                </div>
        </div>
    </div>

<style type="text/css">

   .bs-modal .modal-dialog{
        width: 750px !important;
    }
    .cliente_tabs {
         height: 350px !important;
    }

</style>
 
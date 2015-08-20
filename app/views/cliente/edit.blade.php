<div class="panel rounded shadow">
    <div class="panel-heading">
        <div class="DTTT btn-group"></div>
        <div class="pull-right">
            <button v-on="click: closeMainContainer" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="PanelBody panel-body no-padding">
        <div class="panel panel-tab rounded shadow">

            <div class="panel-heading no-padding">
                <ul class="nav nav-tabs nav-pills">
                    <li class="active" id="saldo_vencido">
                        <a aria-expanded="true" href="#tab1" data-toggle="tab">
                            <i class="fa fa-user"></i> <span>Informacion Cliente</span>
                        </a>
                    </li>

                    <li>
                        <a aria-expanded="false" href="#tab2" data-toggle="tab">
                            <i class="fa fa-user"></i> <span>Contactos</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="tab-content">
                <div class="tab-pane fade inner-all active in" id="tab1">
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

                    <div class="form-group">
                        <div class="col-sm-7">
                            <input class="btn theme-button" value="Guardar!" type="submit">
                        </div>
                    </div>
                        

                    {{ Form::close() }}
                    </div>
                </div>
                <div class="tab-pane fade inner-all" id="tab2">
                    {{ Form::hidden('cliente_id', $cliente->id) }}
                    <div class="row">
                        <div class="col-md-5 contactos-lista">
                         <?php  $contacto = ClienteContacto::where('cliente_id','=', @$cliente->id)->get(); ?>
                            <div class="list-group">
                                <a href="javascript:void(0);" class="list-group-item disabled">
                                    Lista de contactos
                                </a>
                                
                                @foreach($contacto as $key => $dt)
                                <a href="javascript:void(0);" class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-8">{{ $dt->nombre.' '.$dt->apellido }} </div>
                                        <div class="col-md-2">
                                            <i contacto_id="{{$dt->id}}"  id="cliente_contacto_view" class="fa fa-pencil btn-link theme-c"></i>
                                        </div>
                                        <div class="col-md-2">
                                            <i class="btn-link fa fa-trash-o" style="color:#FF0000;;" onclick="cliente_contacto_delete(this,{{$dt->id}})"></i>
                                        </div>
                                    </div>
                                </a>
                                @endforeach

                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="body-contactos">
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
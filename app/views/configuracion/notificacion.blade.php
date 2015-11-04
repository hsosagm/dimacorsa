<div class="panel">
    <div class="panel-heading">
        <div class="pull-left">
            <h3 class="panel-title fg-theme">Configurar Notificaciones</h3>
        </div>
        <div class="pull-right">
            <button title="" data-original-title="" class="btn btn-sm" data-action="remove" onclick="$('.dt-container-cierre').hide();" data-toggle="tooltip" data-placement="top" data-title="cerrar"><i class="fa fa-times fg-theme"></i></button>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        {{ Form::open(array('url' => '/admin/configuracion/notificacion', 'data-remote-md-d', 'data-success' => 'Correo  Ingresado', 'status' => '0')) }}
        <div class="row">
            <div class="col-md-2">Correo: </div>
            <div class="col-md-5">
                <input type="text" name="correo" class="form-control">
            </div>
            <div class="col-md-3">
                <select name="notificacion" class="form-control">
                    <option value="CierreDia">Cierre del dia</option>
                    <option value="InformeGeneral">Informe General</option>
                </select>
            </div>
            <div class="col-md-1">
                <input type="submit" value="Guardar!" class="bg-theme">
            </div>
            <div class="col-md-1"> </div>
        </div>

        {{ Form::close() }}
        <div class="body-detail" width="100%">
            @include('configuracion.listCorreos')
        </div>
    </div>
</div>

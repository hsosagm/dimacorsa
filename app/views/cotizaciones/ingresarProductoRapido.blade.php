{{ Form::open(array('url'=>'/user/cotizaciones/ingresarProductoRapido', 'data-remote-md-dc', 'data-success'=>'Producto Ingresado', 'status'=>'0')) }}
    <div class="row">
        <div class="col-md-6">
            <div class="col-md-6">
                <input type="hidden" name="cotizacion_id" value="{{Input::get('cotizacion_id')}}">
                <input type="text" name="cantidad" placeholder="Cantidad" class="form-control">
            </div>
            <div class="col-md-6">
                <input type="text" name="precio" placeholder="Precio" class="form-control">
            </div>
            <div class="col-md-12" style="margin-top:5px">
                <input type="text" name="descripcion" placeholder="Descripcion" class="form-control">
            </div>
            <div class="col-md-12"style="margin-top:5px; text-align:right;">
                <button type="button" name="button" class="bg-theme" onclick="ingresarProductoAlDetalleCotizacion(this)">Guardar..!</button>
            </div>
        </div>
    </div>
{{ Form::close() }}

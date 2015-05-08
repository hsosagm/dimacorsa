<hr>
<div class="row" align="center"> <button type="" id="contacto_nuevo">Nuevo</button></div>
{{Form::open(array('data-remote-contact'))}} 
<div class="row">
    <div class="col-md-6 list-body"  >
        Lista de Contactos:
        <div class="row contactos-list">
            {{HTML::ul( ProveedorContacto::where('proveedor_id','=',@$proveedor_id)->lists('nombre','id'))}}
        </div>
    </div>

{{ Form::hidden('proveedor_id', @$proveedor_id) }}

    <div class="col-md-6 contactos-body">
        
        
    </div>
</div>

<div class="form-footer" align="right">
    {{ Form::submit('Guardar Contacto!', array('class'=>'theme-button')) }}
    <button class="btn btn-warning" data-dismiss="modal" type="button">Finalizar!</button>
</div>

{{Form::close()}}
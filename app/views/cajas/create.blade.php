
{{ Form::_open('Caja creada') }}

{{ Form::_select('tienda_id', Tienda::where('id','=', Auth::user()->tienda_id )->lists('nombre', 'id')) }}

{{ Form::_text('nombre') }}

<div class="modal-footer">
    <input class="btn theme-button" type="submit" value="Enviar!" autocomplete="off">
</div>

{{ Form::close() }}

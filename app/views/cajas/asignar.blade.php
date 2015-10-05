{{ Form::_open('Caja Asignada') }}

{{ Form::hidden('user_id', ) }}

{{ Form::_select('caja_id', Caja::lists('nombre', 'id')) }}

<div class="modal-footer">
    <input class="btn theme-button" type="submit" value="Enviar!" autocomplete="off">
</div>

{{ Form::close() }}

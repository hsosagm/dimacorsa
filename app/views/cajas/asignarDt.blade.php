{{ Form::_open('Caja Asignada') }}


<input type="hidden" name="user_id" id="usuario_id">
<input type="hidden" name="caja_id" value="{{$caja->id}}">

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-5">
        <input type="text" id="usuarios" class="form-control" placeholder="Buscar Usuario">
    </div>

    <div class="col-md-5">
        <input type="text" value="{{$caja->nombre}}" class="form-control" disabled>
    </div>
    <div class="col-md-1"></div>
</div>

<br>

<div class="modal-footer">
    <input class="btn theme-button" type="submit" value="Enviar!" autocomplete="off">
</div>

{{ Form::close() }}

<script type="text/javascript">
$("#usuarios").autocomplete({
    serviceUrl: 'admin/users/buscar',
    onSelect: function (q) {
        $("#usuario_id").val(q.id);
    }
});
</script>

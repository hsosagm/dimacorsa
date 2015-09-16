{{ Form::_open('Nota de credito creada...!') }}

<input type="hidden" name="cliente_id" id="cliente_id">
<input type="hidden" name="tipo" value="Adelanto">

<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-5">Cliente:</div>
	<div class="col-md-1"></div>
	<div class="col-md-5">Monto:</div>
	<div class="col-md-1"></div>
</div>

<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-5">
		<input type="text" id="cliente" class="input form-control" style="width:260px">
	</div>
	<div class="col-md-1"></div>
	<div class="col-md-4">
		<input type="text" class="form-control input" name="monto">
	</div>
	<div class="col-md-1"></div>
</div>

<br>

<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
		<textarea name="nota" class="form-control"></textarea>
	</div>
	<div class="col-md-1"></div>
</div>

<br>

<div class="modal-footer">
	<input class="btn theme-button" type="submit" value="Enviar!" autocomplete="off">
</div>

{{ Form::close() }}

<script type="text/javascript">
	$('#cliente').autocomplete({
		serviceUrl: '/user/cliente/search',
		onSelect: function (data) {
			$('#cliente_id').val(data.id);
		}
	});
</script>
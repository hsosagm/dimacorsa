{{ Form::_open('Nota de credito creada...!') }}

<input type="hidden" name="cliente_id" id="cliente_id">
<input type="hidden" name="tipo" value="Adelanto">

<div class="row"  style="padding:10px">
	<div class="col-md-5">Cliente:</div>
	<div class="col-md-1"></div>
	<div class="col-md-2">Monto:</div>
	<div class="col-md-4">M. Pago</div>
</div>

<div class="row" style="padding:10px">
	<div class="col-md-5">
		<input type="text" id="cliente" class="input form-control" style="width:260px">
	</div>
	<div class="col-md-1"></div>
	<div class="col-md-2">
		<input type="text" class="form-control input" name="monto">
	</div>
	<div class="col-md-4">
		{{ Form::select('metodo_pago_id', MetodoPago::where('id','!=',2)->where('id','!=',6)->where('id','!=',7)
		->lists('descripcion', 'id') ,'', array('class'=>'form-control')) }}
	</div>
</div>

<br>

<div class="row" style="padding:10px">
	<div class="col-md-12">
		<textarea name="nota" class="form-control"></textarea>
	</div>
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
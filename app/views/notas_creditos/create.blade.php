<div class="master-detail-body">
	{{ Form::open(array('data-remote-md', 'data-success' => 'Nota de Credito  Generada' ,"onsubmit"=>" return false")) }}

	<input type="hidden" name="cliente_id" id="cliente_id">

	<div class="row" style="padding:10px">
		<div class="col-md-2">Cliente:</div>
		<div class="col-md-10">
			<input type="text" id="cliente" class="input form-control">
		</div>
	</div>

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
</div>

<script type="text/javascript">
	$('#cliente').autocomplete({
		serviceUrl: '/user/cliente/search',
		onSelect: function (data) {
			$('#cliente_id').val(data.id);
		}
	});
</script>
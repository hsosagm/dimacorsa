<style type="text/css">
	.bs-modal .Lightbox{
		width: 450px !important;
	}
</style>

<div id="nota_credito">
	<div class="form-group">
		<form>
			<div style="padding-left:12px">
				<div class="rdio rdio-theme circle">
					<input value="notaDeCreditoPorDevolucion" id="radio-type-rounded" type="radio" name="nota_credito" checked>
					<label style="margin-left:10px" for="radio-type-rounded">Nota de credito por devolucion de articulos</label>
				</div>
				<div class="rdio rdio-theme circle">
					<input value="notaDeCreditoPorDescuento" id="radio-type-rounded2" type="radio" name="nota_credito">
					<label style="margin-left:10px" for="radio-type-rounded2">Nota de credito por adelanto</label>
				</div>
			</div>
		</form>
	</div> 

	<div class="modal-footer">
		<button class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button onclick="postFormSeleccionarTipoDeNotaDeCredito()" class="btn btn-info">Enviar</button>
	</div>
</div>

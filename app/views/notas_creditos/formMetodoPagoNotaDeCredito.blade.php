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
					<label style="margin-left:10px" for="radio-type-rounded">Mantener la nota de credito al cliente para <br> 
					usarse en futuras compras</label>
				</div>

				<div style="height:20px"></div>

				<div class="rdio rdio-theme circle">
					<input value="notaDeCreditoPorDescuento" id="radio-type-rounded2" type="radio" name="nota_credito">
					<label style="margin-left:10px" for="radio-type-rounded2">Pago de caja (caja 1)</label>
				</div>
			</div>
		</form> 
	</div>

	<table>
		<tr>
			<td>
				<label style="margin-left:10px" for="radio-type-rounded2">Seleccione metodo de pago</label>
			</td>
			<td>
				<div class="form-group">
					<form> 
						<div style="padding-left:12px">
							<div class="rdio rdio-theme circle">
								<input value="notaDeCreditoPorDevolucion" id="radio-type-3" type="radio" name="nota_credito" checked>
								<label style="margin-left:10px" for="radio-type-3">Efectivo</label>
							</div>

							<div class="rdio rdio-theme circle">
								<input value="notaDeCreditoPorDescuento" id="radio-type-4" type="radio" name="nota_credito">
								<label style="margin-left:10px" for="radio-type-4">Cheque</label>
							</div>
							<div class="rdio rdio-theme circle">
								<input value="notaDeCreditoPorDescuento" id="radio-type-5" type="radio" name="nota_credito">
								<label style="margin-left:10px" for="radio-type-5">Deposito</label>
							</div>
							<div class="rdio rdio-theme circle">
								<input value="notaDeCreditoPorDescuento" id="radio-type-6" type="radio" name="nota_credito">
								<label style="margin-left:10px" for="radio-type-6">Vale</label>
							</div>	
						</div>
					</form> 
				</div>
			</td>
		</tr>
	</table>

	<div class="modal-footer">
		<button class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button onclick="postFormSeleccionarTipoDeNotaDeCredito()" class="btn btn-info">Enviar</button>
	</div>
</div>
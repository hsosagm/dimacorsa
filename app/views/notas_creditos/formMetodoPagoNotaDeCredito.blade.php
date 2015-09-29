<style type="text/css">
	.bs-modal .Lightbox{
		width: 450px !important;
	}
</style>

<div id="nota_credito">

@if( $venta->saldo > 0 )

	<div class="form-group">
		<div style="padding-left:12px">
			<div>
			    <label style="margin-left:10px">Se aplicara un descuento sobre saldo <br> a esta factura de: {{ f_num::get(Input::get('monto')) }}</label>
			</div>
			<div>
			    <label style="margin-left:10px">El nuevo saldo sera: {{ f_num::get($venta->saldo - Input::get('monto')) }}</label>
			</div>
		</div>
	</div>

@endif

@if( $venta->saldo < Input::get('monto') )

	<div class="form-group">
		<div style="padding-left:12px">
			<div>
			    <label style="margin-left:10px">Se aplicara una nota de credito por: {{ f_num::get(Input::get('monto') - $venta->saldo) }}</label>
			</div>
		</div>
	</div>

	<div class="form-group">
		<form>
			<div style="text-align:center; color: #575757">
			    <label>Seleccione forma de pago :</label>
			</div>
			<div style="padding-left:12px">
				<div class="rdio rdio-theme circle">
					<input value="agregarNotaAlCliente" id="radio-type-rounded" type="radio" name="nota_credito_opcion" checked>
					<label style="margin-left:10px" for="radio-type-rounded">Mantener la nota de credito al cliente para <br> 
					usarse en futuras compras</label>
				</div>

				<div class="rdio rdio-theme circle">
					<input value="pagoCaja" id="radio-type-rounded2" type="radio" name="nota_credito_opcion">
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
								<input value="efectivo" id="radio-type-3" type="radio" name="mp_nota_credito_caja" checked>
								<label style="margin-left:10px" for="radio-type-3">Efectivo</label>
							</div>

							<div class="rdio rdio-theme circle">
								<input value="cheque" id="radio-type-4" type="radio" name="mp_nota_credito_caja">
								<label style="margin-left:10px" for="radio-type-4">Cheque</label>
							</div>
							<div class="rdio rdio-theme circle">
								<input value="deposito" id="radio-type-5" type="radio" name="mp_nota_credito_caja">
								<label style="margin-left:10px" for="radio-type-5">Deposito</label>
							</div>
							<div class="rdio rdio-theme circle">
								<input value="vale" id="radio-type-6" type="radio" name="mp_nota_credito_caja">
								<label style="margin-left:10px" for="radio-type-6">Vale</label>
							</div>	
						</div>
					</form> 
				</div>
			</td>
		</tr>
	</table>
@endif
	<div class="modal-footer">
		<button class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button onclick="enviarDevolucionParcial()" class="btn btn-info">Enviar</button>
	</div>
</div>
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
			    <label style="margin-left:10px">Se aplicara un descuento sobre saldo <br> a esta factura de:
			    @if( Input::get('monto') >= $venta->saldo )
			        {{ f_num::get( $venta->saldo ) }}</label>
			        <?php $descuento_sobre_saldo = $venta->saldo ?>
			    @else
			        {{ f_num::get( Input::get('monto') ) }}</label>
			        <?php $descuento_sobre_saldo = Input::get('monto') ?>
			    @endif
			</div>

			<div>
			    <label style="margin-left:10px">El nuevo saldo sera:
			    @if( Input::get('monto') > $venta->saldo )
			        {{ f_num::get(0) }}</label>
			    @else
			        {{ f_num::get( $venta->saldo - Input::get('monto') ) }}</label>
			    @endif
			</div>
		</div>
	</div>

@endif

@if( $venta->saldo < Input::get('monto') )

	<div class="form-group">
		<div style="padding-left:12px">
			<div>
			    <label style="margin-left:10px">Se aplicara una nota de credito por: {{ f_num::get(Input::get('monto') - $venta->saldo) }}</label>
			    <?php $monto = Input::get('monto') - $venta->saldo ?>
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

	<table v-show="pago_caja">
		<tr>
			<td>
				<label>Seleccione metodo de pago</label>
			</td>
			<td>
				<div class="form-group">
					<form>
						<div style="padding-left:12px">
							<div class="rdio rdio-theme circle">
								<input value="1" id="radio-type-3" type="radio" name="mp_nota_credito_caja" checked>
								<label style="margin-left:10px" for="radio-type-3">Efectivo</label>
							</div>

							<div class="rdio rdio-theme circle">
								<input value="3" id="radio-type-4" type="radio" name="mp_nota_credito_caja">
								<label style="margin-left:10px" for="radio-type-4">Cheque</label>
							</div>
							<div class="rdio rdio-theme circle">
								<input value="5" id="radio-type-5" type="radio" name="mp_nota_credito_caja">
								<label style="margin-left:10px" for="radio-type-5">Deposito</label>
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
		<button onclick="enviarDevolucionParcial( {{ $descuento_sobre_saldo }}, {{ $monto }} )" class="btn btn-info">Enviar</button>
	</div>
</div>

<script type="text/javascript">
	$('#radio-type-rounded2').click(function() {
		dvnc.pago_caja = true;
    });
	$('#radio-type-rounded').click(function() {
		dvnc.pago_caja = false;
    });

    var dvnc = new Vue({

        el: '#nota_credito',

        data: {
            pago_caja: false
        }
    });

</script>

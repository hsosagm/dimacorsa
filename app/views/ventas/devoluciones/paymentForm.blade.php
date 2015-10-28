<style type="text/css">
	.bs-modal .Lightbox {
		width: 450px !important;
	}
</style>

<?php $descuento_sobre_saldo = 0; ?>
<?php $monto_a_devolver = 0; ?>

<div id="devPaymentForm">
	@if( $venta->saldo > 0 )
		<div class="form-group">
			<div style="padding-left:12px">
				<div>
				    <label style="margin-left:10px">Se aplicara un descuento sobre saldo <br> a esta factura de:
				    @if( Input::get('totalDevolucion') >= $venta->saldo )
				        {{ f_num::get( $venta->saldo ) }}</label>
				        <?php $descuento_sobre_saldo = $venta->saldo ?>
				    @else
				        {{ f_num::get( Input::get('totalDevolucion') ) }}</label>
				        <?php $descuento_sobre_saldo = Input::get('totalDevolucion') ?>
				    @endif
				</div>

				<div>
				    <label style="margin-left:10px">El nuevo saldo sera:
				    @if( Input::get('totalDevolucion') > $venta->saldo )
				        {{ f_num::get(0) }}</label>
				    @else
				        {{ f_num::get( $venta->saldo - Input::get('totalDevolucion') ) }}</label>
				    @endif
				</div>
			</div>
		</div>
	@endif

	@if( $venta->saldo < Input::get('totalDevolucion') )

		<div class="form-group">
			<div style="padding-left:12px">
				<div>
				    <label style="margin-left:10px">Se aplicara una nota de credito por: {{ f_num::get(Input::get('totalDevolucion') - $venta->saldo) }}</label>
				    <?php $monto_a_devolver = Input::get('totalDevolucion') - $venta->saldo ?>
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
						<input value="agregarNotaAlCliente" id="radio-type-rounded" type="radio" name="devolucion_opcion" checked>
						<label style="margin-left:10px" for="radio-type-rounded">Mantener la nota de credito al cliente para <br> 
						usarse en futuras compras</label>
					</div>

					<div class="rdio rdio-theme circle">
						<input value="pagoCaja" id="radio-type-rounded2" type="radio" name="devolucion_opcion">
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
									<input value="1" id="radio-type-3" type="radio" name="mp_devolucion" checked>
									<label style="margin-left:10px" for="radio-type-3">Efectivo</label>
								</div>

								<div class="rdio rdio-theme circle">
									<input value="3" id="radio-type-4" type="radio" name="mp_devolucion">
									<label style="margin-left:10px" for="radio-type-4">Cheque</label>
								</div>
								<div class="rdio rdio-theme circle">
									<input value="5" id="radio-type-5" type="radio" name="mp_devolucion">
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
		<button v-on="click: submit( {{ $descuento_sobre_saldo }}, {{ $monto_a_devolver }} )" class="btn btn-info">Enviar</button>
	</div>
</div>

<script type="text/javascript">

	$('#radio-type-rounded2').click(function() {
		devPaymentForm.pago_caja = true;
    });

	$('#radio-type-rounded').click(function() {
		devPaymentForm.pago_caja = false;
    });

    var devPaymentForm = new Vue({

        el: '#devPaymentForm',

        data: {
            pago_caja: false
        },

        methods: {
        	// Variables dss 'descuento sobre saldo' monto_a_devolver 'el monto real que habra que devolver de caja o generar nota de credito al cliente'
        	submit: function(dss, monto_a_devolver)
        	{
		        var devolucion_opcion = $('input[name="devolucion_opcion"]:checked').val()
		        var mp_devolucion = $('input[name="mp_devolucion"]:checked').val()

                $.ajax({
                    type: 'POST',
                    url: 'user/ventas/devoluciones/finalizarDevolucion',
                    data: { 
                    	devolucion_id: devoluciones.devolucion_id, descuento_sobre_saldo: dss, monto_a_devolver: monto_a_devolver,
                    	devolucion_opcion: devolucion_opcion, mp_devolucion: mp_devolucion, cliente_id: devoluciones.venta.cliente_id,
                    	tienda_id: devoluciones.venta.tienda_id, totalDevolucion: devoluciones.totalDevolucion,
                    	venta_id: devoluciones.venta.id
                    },
                }).done(function(data) {
                    if (data.success == true)
                    {
                    	$('.panel-title').text('')
                    	$(".forms").html("")
                    	$(".form-panel").hide()
	                    $('.modal-body').html('')
	                    $('.modal-title').text('')
	                    $('.bs-modal').modal('hide')
                        return msg.success('Devolucion generada..!', 'Listo!')
                    }
                    msg.warning(data)
                })
        	}
        }
    });

</script>
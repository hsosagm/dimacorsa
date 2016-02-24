<div id="pagosVenta" style="padding:10px;">
	<div class="row">
		<label class="col-md-6"> Total abonado: @{{ totalPagado | currency '' }} </label>
		<label class="col-md-6" v-show="(totalRestante >= 0)"> Total restante: @{{ totalRestante | currency '' }} </label>
		<label class="col-md-6" v-show="(totalRestante < 0)"> Su vuelto es: @{{ totalVuelto | currency '' }} </label>
	</div>
	<div class="row">
		<div class="col-md-5">
			<input type="text" v-on="keyup : agregarPago() | key 'enter'" class="form-control" id="monto">
		</div>
		<div class="col-md-5">
			<select v-model="form.metodo_pago_id" v-el="metodo_pago_id" options="metodo_pago" v-on="keyup : agregarPago() | key 'enter'" class="form-control"></select>
		</div>
		<div class="col-md-1">
			<i class="fa fa-plus fg-theme" v-on="click: agregarPago()" ></i>
		</div>
	</div>
	<hr>
	<table class="table table-striped">
		<tr>
			<th>Metodo de pago</th>
			<th>Monto</th>
			<th></th>
		</tr>
		<tr v-repeat="dp: paymentsView">
			<td> @{{ metodoPagoNombre(dp.metodo_pago_id) }}</td>
			<td> @{{ dp.monto | currency '' }} </td>
			<td class="right">
				<i class="fa fa-trash-o fa-lg icon-delete" v-on="click: eliminarPago($index)"></i>
			</td>
		</tr>
	</table>

	<div class="form-footer footer" style="margin-top: 30px;" align="right">
		<button v-on="click: enviarPagos($event)" v-if="(totalRestante <= 0)" class="btn theme-button ">Enviar!</button>
	</div>
</div>

<script type="text/javascript">

	var pagosVenta = new Vue({

		el: '#pagosVenta',

		data: {

			form: {
				venta_id: ventas.venta_id,
				monto: 0,
				metodo_pago_id: 1
			},

			metodo_pago: [],

			payments: [],

			paymentsView: [],

			totalDeuda: ventas.totalVenta,

			totalPagado: 0,

			totalRestante: ventas.totalVenta,

			totalVuelto: 0
		},

		watch: {
			'payments': function ()
			{
				this.totalPagado = 0;
				this.totalRestante = this.totalDeuda;

				for (var i = 0; i < this.paymentsView.length; i++) {
					this.totalRestante -= parseFloat(this.paymentsView[i]["monto"]);
					this.totalPagado += parseFloat(this.paymentsView[i]["monto"]);
				}

				if(this.totalRestante <= 0) {
					$("#monto").prop("disabled", true);
					this.$$.metodo_pago_id.disabled = true;
					this.totalVuelto = (this.totalRestante * -1);
				} else {
					this.form.monto = this.totalRestante;
					$("#monto").prop("disabled", false);
					this.$$.metodo_pago_id.disabled = false;
					$('#monto').autoNumeric('set', this.totalRestante);
				}
			}
		},

		ready:function(){
			this.metodo_pago = {{ json_encode(MetodoPago::select(DB::raw("id as value"), DB::raw("descripcion as text"))->where('id', '<', 6)->get()) }};
			$('#monto').autoNumeric({aSep:',', aNeg:'', mDec:2, mRound:'S', vMax: '999999.99', wEmpty: 'zero', lZero: 'deny', mNum:10});
   			$('#monto').autoNumeric('set', this.totalRestante);
		},

		methods: {

			agregarPago: function() {
				this.form.monto = $("#monto").val().replace(",", "");

				if(this.validarData()) {
					this.payments.push({ 
						venta_id: this.form.venta_id,
						monto: (this.form.monto > this.totalRestante)? this.totalRestante: this.form.monto.replace(",", ""), 
						metodo_pago_id: this.form.metodo_pago_id
					});

					this.paymentsView.push({ 
						monto: this.form.monto.replace(",", ""), 
						metodo_pago_id: this.form.metodo_pago_id
					});

					this.form.monto = 0;
					this.form.metodo_pago_id = 1;
					$("#monto").focus();
				}
			},

			validarData: function() {
				for (var i = 0; i < this.payments.length; i++) {
                    if(this.payments[i]["metodo_pago_id"] == this.form.metodo_pago_id) {
                    	msg.warning('El metodo de pago ya ha sido ingresado..!');
                        return false;
                    }
                }

				if(parseFloat(this.form.monto) <= 0 || this.form.monto == "" || this.form.monto == null) {
					msg.warning('El monto tiene que ser mayor que 0..!');
					return false;
				}

				if(this.form.metodo_pago_id == 2) {
					if(this.form.monto > this.totalRestante) {
						msg.warning('El monto no puede ser mayor al total restante..!');
						return false;
					}
				}

				return true;
			},

			metodoPagoNombre: function(metodo_pago_id){
				for ( var i = 0; i < this.metodo_pago.length; i++ ) {
					if( this.metodo_pago[i]["value"] == metodo_pago_id )
						return this.metodo_pago[i]["text"];
				}
			},

			eliminarPago: function(index) {
				this.payments.$remove(index);
				this.paymentsView.$remove(index);
			},

			enviarPagos: function(){
				console.log(JSON.stringify(this.payments));
				console.log(ventas.totalVenta);
				console.log("================================================================");
			}
		}
	});


</script>
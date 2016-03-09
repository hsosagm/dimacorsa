<div id="formPayments">
    <div style="height:350px">
        <div style="margin-left:50px" v-if="x==1">
            <div class="row">
                <div class="col-md-5">Total abonado: @{{abonado | currency ''}}</div>
                <div v-show="!disabled" class="col-md-5">Resta abonar: @{{this.total - this.abonado | currency ''}}</div>
                <div v-show="disabled" class="col-md-5">Su vuelto es: @{{this.abonado - this.total | currency ''}}</div>
            </div>

            <div id="payment_input" class="row" style="margin-top:15px">
                <div class="col-md-5">
                    <input v-on="keyup:addPayment | key 'enter'" id="monto" class="form-control right" v-attr="disabled: disabled">
                </div>
                <div class="col-md-5">
                    <select id="payments" v-model="metodo_pago_id" options="paymentsOptions" v-attr="disabled: disabled" class="form-control"></select>
                </div>
                <div class="col-md-2" v-if="!disabled">
                    <i v-on="click: addPayment" style="font-size: 20px; padding-top:7px" class="fa fa-plus fg-theme"></i>
                </div>
            </div>

            <div v-repeat="payment: payments" class="row" style="margin-top:10px">
                <div class="col-md-5 right" style="padding-right:20px">@{{ payment.abonado | currency ' ' }}</div>
                <div class="col-md-5" style="padding-left:25px">@{{ payment.optionSelected }}</div>
                <div class="col-md-2" style="float:right">
                    <i v-on="click: removePayment($index, payment.monto)" class="fa fa-trash-o pointer icon-delete"></i>
                </div>
            </div>
        </div>

        <div class="table-responsive" v-if="x==2" id="tableNotasDeCredito">
        	<table class="table table-hover" width="80%">
        		<thead>
					<tr>
						<th>Fecha:</th>
						<th>Monto:</th>
						<th></th>
					</tr>
        		</thead>
        		<tbody>
	        		<tr v-repeat="nc: notasDeCredito">
	        			 <td> @{{ nc.created_at }} </td>
			            <td class="right"> @{{ nc.monto | currency '' }} </td>
			            <td>
			                <div class="ckbox ckbox-success">
				                <input id="chk-1-@{{nc.id}}" type="checkbox" v-on="click: selectcionarNota($index, $event, nc.monto)">
				                <label for="chk-1-@{{nc.id}}"></label>
			                </div>
			            </td>
	        		</tr>
        		</tbody>
        	</table>
    	</div>
    </div>
    <div class="modal-footer payments-modal-footer" v-if="x==2" >
		<div class="left col-md-6">
			<button v-on="click: cancelarNotaDeCredito" class="btn btn-warning">Cancelar</button>
		</div>
		<div class="right col-md-6" v-if="(totalNotas > 0)">
			<button v-on="click: agregarNotaDeCredito()"  v-show="total" class="btn bg-theme btn-info">Agregar</button>
		</div>
    </div>
    <div class="modal-footer payments-modal-footer" v-if="x==1">
    	<div class="left col-md-6">
    		<button type="button" v-if="disabledNotas" v-on="click: getNotasDeCredito()" class="btn btn-info">Notas de Credito</button>
        </div>
        <div v-if="disabled" v-transition class="right col-md-6">
            <i v-on="click: imprimirGarantia($event)" class="fa fa-file-o icon-print" style="font-size: 22px; padding-left: 10px" title="Imprimir Garantia"></i>
            <i v-on="click: imprimirFactura($event)" class="fa fa-print icon-print" style="font-size: 22px; padding-left: 10px" title="Imprimir Factua"></i>
        	<i v-on="click: endSale" class="fa fa-check icon-success" style="font-size: 22px; padding-left: 10px" title="Finalizar"></i>
        </div>
    </div>
</div>
<script type="text/javascript">

    new Vue({

        el: '#formPayments',

        data: {
            total: {{ Input::get('totalVenta') }},
            paymentsOptions: {{ $paymentsOptions }},
            payments: [],
            metodo_pago_id: 1,
            abonado: 0,
            credito: 0,
            disabled: false,
            notasDeCredito: [],
            disabledNotas: {{ $disabledNotas }},
            x: 1
        },

        ready: function() {
            $('.modal-title').text('Formulario pagos venta')
            $('#monto').autoNumeric('init', {aNeg:'', vMax: '999999.99', lZero: 'deny'});
            $('#monto').autoNumeric('set', this.total - this.abonado);
        },

        watch: {
            payments: function() {
                this.abonado = 0
                for (var i = this.payments.length - 1; i >= 0; i--) {
                    this.abonado += this.payments[i]["abonado"]

                    if (this.payments[i]["metodo_pago_id"] == 2)
                        this.credito = this.payments[i]["monto"]
                }

                if (this.abonado >= this.total)
                    return this.disabled = true
                this.disabled = false

                $('#monto').autoNumeric('init', {aNeg:'', vMax: '999999.99', lZero: 'deny'});
                $('#monto').autoNumeric('set', this.total - this.abonado);
            },
        },

        computed: {
            values: function() {
                var values = this.payments
                for (var i = values.length - 1; i >= 0; i--) {
                    delete values[i]["abonado"]
                    delete values[i]["optionSelected"]
                    values[i]["venta_id"] = {{ Input::get('venta_id') }}
                }
                return values
            },

            totalNotas: function() {
            	totalN = 0;

            	for (var y = 0; y < this.notasDeCredito.length; y++)
            		if (this.notasDeCredito[y]['estado'] == 1)
            			totalN += parseFloat(this.notasDeCredito[y]['monto']);
            	return totalN;
            },

            valuesNotas: function() {
                for (var i = 0; i < this.notasDeCredito.length; i++) {
                    delete this.notasDeCredito[i]["created_at"];
                    delete this.notasDeCredito[i]["monto"];
                    delete this.notasDeCredito[i]["estado"];
                    if (this.notasDeCredito[i]["estado"] == 0)
                    	this.notasDeCredito.$remove(i);
                }
                return this.notasDeCredito;
            }
        },

        methods: {
            addPayment: function() {
                var monto = parseFloat($('#monto').autoNumeric('get'))
                if (monto < 0.01 || $('#monto').val() == "") return

                for (var i = this.payments.length - 1; i >= 0; i--)
                    if (this.metodo_pago_id == this.payments[i]["metodo_pago_id"])
                        return msg.warning("Es metodo de pago ya a sido seleccionado", "Advertencia!")

                if ($("#payments option:selected").text() == "Credito" && this.total-this.abonado < monto)
                    return msg.warning("El credito no puede ser mayor al monto restante", "Advertencia!")

                this.payments.push({
                    abonado:        monto,
                    monto:          this.total-this.abonado <= monto ? this.total-this.abonado : monto,
                    metodo_pago_id: this.metodo_pago_id,
                    optionSelected: $("#payments option:selected").text()
                })
            },

            removePayment: function(index, monto) {
            	if (this.payments[index]['metodo_pago_id'] == 6) {
            		this.notasDeCredito = [];
            		this.disabledNotas = true;
            	}
                this.payments.$remove(index)
            },

            endSale: function(e) {
                e.target.disabled = true;
                $.ajax({
                    type: 'POST',
                    url:  'user/ventas/endSale',
                    data: {
                        payments: 		this.values,
                        total:    		ventas.totalVenta,
                        saldo:    		this.credito,
                        venta_id: 		{{ Input::get('venta_id') }},
                        notasDeCredito: this.valuesNotas,
                        detalleVenta:   ventas.detalleTable
                    },
                }).done(function(data) {
                    if (!data.success) {
                        e.target.disabled = false;
                        return msg.warning(data.msg, "Advertencia!");
                    }

                    $('.bs-modal').modal('hide');
                    $(".form-panel").hide();
                    msg.success('Venta finalizada!');
                }).fail(function (jqXHR, textStatus) {
                    e.target.disabled = false;
                });
            },

            getNotasDeCredito: function() {
            	var that = this;

                $.ajax({
                    type: "GET",
                    url: 'user/ventas/notasDeCredito',
                    data: { cliente_id: ventas.cliente.id },
                }).done(function(data) {
                    if (!data.success)
                        return msg.warning(data, 'Advertencia!');

                    that.x = 2;
 					that.notasDeCredito = data.notasDeCredito;
                });
            },

            selectcionarNota: function(index, event, monto) {
            	if ( $(event.target).is(':checked') ) {
					if (((this.total - this.abonado) - this.totalNotas) < monto) {
						this.notasDeCredito[index]['estado'] = 0;
						return event.target.checked = false;
					}
                    return this.notasDeCredito[index]['estado'] = 1;
                }
                return this.notasDeCredito[index]['estado'] = 0;
            },

            cancelarNotaDeCredito: function() {
            	this.x = 1;
            	this.notasDeCredito = [];
            },

            agregarNotaDeCredito: function() {
            	this.disabledNotas = false;
            	this.x = 1;

            	this.payments.push({
                    abonado:        this.totalNotas,
                    monto:          this.totalNotas,
                    metodo_pago_id: 6,
                    optionSelected: "Nota de credito"
                });
            },

            imprimirFactura: function(e) {
                printInvoice(e.target, {{ Input::get('venta_id') }}, null);
                e.target.disabled = false;
            },

            imprimirGarantia: function(e){
                ImprimirGarantia(e.target, {{ Input::get('venta_id') }}, null);
                e.target.disabled = false;
            }
        }
    });
</script>
<div id="formPayments">
    <div style="height:300px">
        <div style="margin-left:50px">
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
                    <i v-on="click: removePayment($index, payment.monto)" class="fa fa-trash-o pointer btn-link theme-c"></i>
                </div>
            </div>
        </div>
    </div>
    <div v-if="disabled" v-transition class="modal-footer payments-modal-footer">
        <button v-on="click: endSale" class="btn theme-button" type="text">Finalizar</button>
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
            disabled:false
        },

        ready: function() {
            $('.modal-title').text('Formulario pagos venta')
            $('#monto').autoNumeric('init', {aNeg:'', vMax: '999999.99', lZero: 'deny'})
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

                $('#monto').autoNumeric('set', this.total - this.abonado)
            }
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
            }
        },

        methods: {
            addPayment: function()
            {
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

            removePayment: function(index, monto)
            {
                this.payments.$remove(index)
            },

            endSale: function(e) {
                e.target.disabled = true;

                $.ajax({
                    type: 'POST',
                    url:  'user/ventas/endSale',
                    data: {
                        payments: this.values,
                        total:    ventas.totalVenta,
                        saldo:    this.credito,
                        venta_id: {{ Input::get('venta_id') }}
                    },
                }).done(function(data) {
                    if (!data.success) {
                        e.target.disabled = false;
                        return msg.warning("Hubo un error intentelo de nuevo", "Advertencia!");
                    }

                    $('.bs-modal').modal('hide');
                    $(".form-panel").hide();
                    msg.success('Venta finalizada', 'Listo!');

                }).fail(function (jqXHR, textStatus) {
                    e.target.disabled = false;
                });
            }
        }
    });
</script>
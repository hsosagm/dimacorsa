<div id="formPayments" style="height:300px">
    <div style="margin-left:50px">
        <div class="row">
            <div class="col-md-5">Total abonado: @{{abonado | currency ''}}</div>
            <div v-show="resta_abonar" class="col-md-5">Resta abonar: @{{resta_abonar | currency ''}}</div>
            <div v-show="!resta_abonar" class="col-md-5">Su vuelto es: @{{vuelto | currency ''}}</div>
        </div>

        <div v-show="resta_abonar" class="row" style="margin-top:15px">
            <div class="col-md-5">
                <input v-on="keyup:pushPayment | key 'enter'" id="monto" class="form-control">
            </div>
            <div class="col-md-5">
                <select id="payments" v-model="metodoPagoId" options="paymentsOptions" class="form-control"></select>
            </div>
            <div class="col-md-2"> 
                <i v-on="click: pushPayment" style="font-size: 20px; padding-top:7px" class="fa fa-plus fg-theme"></i>
            </div>
        </div>

        <div v-repeat="payment: selectedPayments" class="row" style="margin-top:10px">
            <div class="col-md-5" style="text-align:right; padding-right:20px">@{{ payment.monto | currency ' ' }}</div>
            <div class="col-md-5" style="padding-left:25px">@{{ payment.optionSelected }}</div>
            <div class="col-md-2" style="float:right">
                <i v-on="click: removePayment($index, payment.monto)" class="fa fa-trash-o pointer btn-link theme-c"></i>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    new Vue({

        el: '#formPayments',

        data: {
            resta_abonar: {{ Input::get('totalVenta') }},
            paymentsOptions: {{$metodosDePago}},
            selectedPayments: [],
            metodoPagoId: 1,
            vuelto: 0,
            abonado: 0
        },

        ready: function()
        {
            $('.modal-title').text('Formulario pagos venta')
            $('#monto').autoNumeric('init', {aNeg:'', vMax: '999999.99', lZero: 'deny'})
            $('#monto').autoNumeric('set', this.resta_abonar);
        },

        methods: {
            pushPayment: function()
            {
                var monto = parseFloat($('#monto').autoNumeric('get'))
                if (monto < 0.01) return

                this.selectedPayments.push({ 
                    monto:monto, metodoPagoId:this.metodoPagoId, optionSelected:$("#payments option:selected").text()
                })

                this.resta_abonar = this.resta_abonar - monto 
                this.abonado = this.abonado + monto
                $('#monto').autoNumeric('set', this.resta_abonar);
            },

            removePayment: function(index, monto)
            {
                this.selectedPayments.$remove(index)
                this.resta_abonar = this.resta_abonar + monto
                this.abonado = this.abonado - monto
                $('#monto').autoNumeric('set', this.resta_abonar);
            }
        }
    });

</script>
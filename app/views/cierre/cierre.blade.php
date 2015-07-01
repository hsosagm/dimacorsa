<div id="cierre">

    {{ Form::open(array('class' => 'form-horizontal all', 'v-on="submit: Submit"')) }}

    <div class="form-group">
        <div class="col-sm-3"></div>
        <div class="col-sm-3">
            <label>Esperado</label>
        </div>
        <div class="col-sm-3">
            <label>Real</label>
        </div>
        <div class="col-sm-3">
            <label>Efectivo</label>
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-3">
            <label>Efectivo: </label>
        </div>
        <div class="col-sm-3">
            <input type="text" value="@{{ movimientos.efectivo | currency }}" class="form-control right" disabled>
            <input type="hidden" name="efectivo_esp" value="@{{ movimientos.efectivo }}">
        </div>
        <div class="col-sm-3">
            <input type="text" value="0" v-on="keyup : set_efectivo" class="form-control numeric preventDefault" style="background:#E3F4CF;">
            <input type="hidden" name="efectivo" v-model="efectivo">
        </div>
        <div class="col-sm-3">
            <input type="text" value="@{{ dif_efectivo | currency }}" class="form-control right" disabled>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-3">
            <label>Cheque: </label>
        </div>
        <div class="col-sm-3">
            <input type="text" value="@{{ movimientos.cheque | currency }}" class="form-control right" disabled>
            <input type="hidden" name="cheque_esp" value="@{{ movimientos.cheque }}">
        </div>
        <div class="col-sm-3">
            <input type="text" value="0" v-on="keyup : set_cheque" class="form-control numeric preventDefault" style="background:#E3F4CF;">
            <input type="hidden" name="cheque" v-model="cheque">
        </div>
        <div class="col-sm-3">
            <input type="text" value="@{{ dif_cheque | currency }}"  class="form-control right" disabled>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-3">
            <label>Tarjeta: </label>
        </div>
        <div class="col-sm-3">
            <input type="text" value="@{{ movimientos.tarjeta | currency }}" class="form-control right" disabled>
            <input type="hidden" name="tarjeta_esp" value="@{{ movimientos.tarjeta }}">
        </div>
        <div class="col-sm-3">
            <input type="text" value="0" v-on="keyup : set_tarjeta" class="form-control numeric preventDefault" style="background:#E3F4CF;">
            <input type="hidden" name="tarjeta" v-model="tarjeta">
        </div>
        <div class="col-sm-3">
            <input type="text" value="@{{ dif_tarjeta | currency }}" class="form-control right" disabled>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-3">
            <label>Deposito: </label>
        </div>
        <div class="col-sm-3">
            <input type="text" value="@{{ movimientos.deposito | currency }}" class="form-control right" disabled>
            <input type="hidden" name="deposito_esp" value="@{{ movimientos.deposito }}">
        </div>
        <div class="col-sm-3">
            <input type="text" value="0" v-on="keyup : set_deposito" class="form-control numeric preventDefault" style="background:#E3F4CF;">
            <input type="hidden" name="deposito" v-model="deposito">
        </div>
        <div class="col-sm-3">
            <input type="text" value="@{{ dif_deposito | currency }}" class="form-control right" disabled>
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-3"></div>
        <div class="col-sm-3">
            <label>Total: </label>
        </div>
        <div class="col-sm-3">
            <label style="float:right">@{{ total | currency }}</label>
        </div>
        <div class="col-sm-3"></div>
    </div>

    <div class="form-group">
        <div class="col-sm-3"></div>
        <div class="col-sm-3">
            <label>Diferencia: </label>
        </div>
        <div class="col-sm-3">
            <label style="float:right">@{{ total_diferencia | currency }}</label>
        </div>
        <div class="col-sm-3"></div>
    </div>

    <div class="form-group">
        <div class="col-md-12" style="margin-top:10px;">
            <textarea name="nota" class="form-control" placeholder="Observaciones . . ." rows="2"></textarea>
        </div>
    </div>


    <div class="modal-footer" style="margin-top:20px">
        <button class="btn theme-button" type="submit">Enviar</button>
    </div>

    {{ Form::close() }}

</div>

<script type="text/javascript">

    var vm = new Vue({

        el: '#cierre',


        data: {
            movimientos: {{ $movimientos }},
            efectivo: 0,
            cheque: 0,
            tarjeta: 0,
            deposito: 0,
        },

        computed: {

            dif_efectivo: {
                get: function() {
                    return this.movimientos.efectivo - this.efectivo
                }
            },

            dif_cheque: {
                get: function() {
                    return this.movimientos.cheque - this.cheque
                }
            },

            dif_tarjeta: {
                get: function() {
                    return this.movimientos.tarjeta - this.tarjeta
                }
            },

            dif_deposito: {
                get: function() {
                    return this.movimientos.deposito - this.deposito
                }
            },

            total: {
                get: function() {
                    return this.efectivo + this.cheque + this.tarjeta + this.deposito
                }
            },
            total_diferencia: {
                get: function() {
                    return this.dif_efectivo + this.dif_cheque + this.dif_tarjeta + this.dif_deposito
                }
            }
        },

        methods: {

            set_efectivo: function(e) {
                this.efectivo = vm.clean(e);
            },

            set_cheque: function(e) {
                this.cheque = vm.clean(e);
            },

            set_tarjeta: function(e) {
                this.tarjeta = vm.clean(e);
            },

            set_deposito: function(e) {
                this.deposito = vm.clean(e);
            },

            clean: function(e) {
                return parseFloat( e.target.value.replace(/\Q|\,/g, '') );
            },

            Submit: function(e) {

                e.preventDefault();
                var form = $(e.target).closest("form");
                $('input[type=submit]', form).prop('disabled', true);

                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function (data) {
                        if (data.success == true)
                            msg.success('Cierre realizado correctamente', 'Listo!');
                            return $('.bs-modal').modal('hide');
                            
                        msg.warning(data, 'Advertencia!');
                        $('input[type=submit]', form).prop('disabled', false);
                    }
                });
            }
        }
    });

    $('.numeric').autoNumeric({aSep:',', aNeg:'', mDec:2, mRound:'S', vMax: '999999.99', wEmpty: 'zero', lZero: 'deny', mNum:10});
    
</script>
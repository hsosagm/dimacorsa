<div id="formPayments">
    <div class="modal_header">
        <button class="close" v-on="click: close" type="button" data-dismiss="modal" aria-hidden="true">×</button>
        <h4>Formulario pagos venta</h4>
    </div>
    <div style="height:370px;">
        <div style="height:330px">
            <div v-show="x==1" class="row" style="text-align: center; font-size: 20px; color: #878787">Resta abonar</div>
            <div v-show="x==1" class="row resta_abonar">@{{resta_abonar | currency 'Q'}}</div>
            <div style="margin-left:50px;" v-show="x==1">
                <div id="payment_input" class="row" style="margin-top:15px">
                    <div class="col-md-5">
                        <select id="payments" v-model="metodo_pago_id" options="paymentsOptions" v-attr="disabled: disabled" class="form-control"></select>
                    </div>
                    <div class="col-md-5">
                        <input v-on="keyup:addPayment | key 'enter'" id="monto" class="form-control right" v-attr="disabled: disabled">
                    </div>
                    <div class="col-md-2" v-show="!disabled">
                        <i v-on="click: addPayment" style="font-size: 20px; padding-top:7px" class="fa fa-plus fg-theme"></i>
                    </div>
                </div>

                <div v-repeat="payment: payments" class="row" style="margin-top:10px">
                    <div class="col-md-5" style="padding-left:25px">@{{payment.optionSelected}}</div>
                    <div class="col-md-5 right" style="padding-right:20px">@{{payment.abonado | currency ''}}</div>
                    <div class="col-md-2" style="float:right">
                        <i v-on="click: removePayment($index, payment.monto)" class="fa fa-trash-o pointer btn-link theme-c"></i>
                    </div>
                </div>

                <div v-show="payments.length" class="row" style="margin-top:15px">
                    <div class="col-md-5" style="padding-left:25px">Total:</div>
                    <div class="col-md-5 right" style="padding-right:20px">@{{abonado | currency ''}}</div>
                </div>
            </div>

            <div class="table-responsive" v-show="x==2" id="tableNotasDeCredito">
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
        <div class="vuelto">
            <label>Gracias por su compra</label>
            <label v-if="this.abonado - this.total > 0">su cambio es Q@{{this.abonado - this.total | currency ''}}</label>
        </div>
    </div>

    <div class="modal-footer">
        <div v-show="x==1">
            <i v-show="countNotasCredito" v-on="click: getNotasDeCredito" class="fa fa-file-text-o fa-lg icon-success"></i>
            <i v-on="click: endSale" v-class="disabledSubmit:submitDisable" class="fa fa-check fa-lg icon-success" style="padding-left:10px"></i>
        </div>
        <div v-show="x==2">
            <button v-on="click: cancelarNotaDeCredito" class="btn btn-warning">Cancelar</button>
            <button v-on="click: agregarNotaDeCredito"  v-show="total" class="btn bg-theme btn-info">Agregar</button>
        </div>
    </div>
</div>

<script type="text/javascript">

   var salesPayments = new Vue({

        el: '#formPayments',

        data: {
            total: {{ Input::get('totalVenta') }},
            paymentsOptions: {{ $paymentsOptions }},
            payments: [],
            metodo_pago_id: 1,
            abonado: 0,
            disabled: false,
            notasDeCredito: [],
            countNotasCredito: {{ $countNotasCredito }},
            x: 1,
            submitDisable: false
        },

        ready: function() {
            $('.modal-title').text('Formulario pagos venta')
            $('#monto').autoNumeric('init', {aNeg:'', vMax: '999999.99', lZero: 'deny'});
            $('#monto').autoNumeric('set', this.total - this.abonado);
            $('.modal-header').hide()
        },

        watch: {
            payments: function() {
                this.abonado = 0
                for (var i = this.payments.length - 1; i >= 0; i--)
                    this.abonado += this.payments[i]["abonado"]

                if (this.abonado >= this.total) {
                    this.disabled = true
                    return $('.vuelto label').fadeIn(1500)
                }
                $('.vuelto label').hide()
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
            },

            resta_abonar: function() {
                if (this.total < this.abonado)
                    return 0
                return this.total - this.abonado
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
                    this.countNotasCredito = true;
                }

                this.payments.$remove(index)
            },

            close: function() {
                setTimeout(function() {
                    $(".form-panel").show()
                    $(".modal-header").show()
                },300)
            },

            endSale: function(e) {

                var monto = 0
                for (var i = this.payments.length - 1; i >= 0; i--)
                    monto += this.payments[i]["monto"]

                if (monto == 0)
                    return msg.warning("No se ha realizado ningun pago", "Advertencia!");

                if (monto < this.total)
                    return msg.warning("El monto abonado es menor al total de la venta", "Advertencia!");

                var credito = 0

                for (var i = 0; i < this.payments.length; i++)
                    if (this.payments[i]["metodo_pago_id"] == 2)
                        credito = this.payments[i]["monto"]

                this.submitDisable = true

                $.ajax({
                    type: 'POST',
                    url:  'user/ventas/endSale',
                    data: {
                        payments:       this.values,
                        total:          this.total,
                        saldo:          credito,
                        venta_id:       {{ Input::get('venta_id') }},
                        notasDeCredito: this.valuesNotas,
                        detalleVenta:   ventas.detalleTable
                    },
                }).done(function(data) {
                    if (!data.success) {
                        msg.warning(data.msg, "Advertencia!")
                        return salesPayments.submitDisable = false
                    }

                    $('.bs-modal').modal('hide')
                    $(".form-panel").hide()
                    msg.success('Venta finalizada!')
                    $('#modal').modal('toggle')
                    salesPayments.imprimirFactura()
                    salesPayments.f_ven_op()
                    setTimeout(function() {
                        $(".modal-header").show()
                    },300)
                })
            },

            f_ven_op: function()
            {
                $.ajax({
                  url: "user/ventas/create",
                  type: "GET"
                }).done(function(data) {
                    $('.panel-title').text('Formulario Ventas');
                    $(".forms").html(data);
                    ocultar_capas();
                    $(".form-panel").show();
                    $('#cliente').focus();
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
                this.countNotasCredito = false;
                this.x = 1;

                this.payments.push({
                    abonado:        this.totalNotas,
                    monto:          this.totalNotas,
                    metodo_pago_id: 6,
                    optionSelected: "Nota de credito"
                });
            },

            imprimirFactura: function(e) {
                var config = qz.configs.create("epson");

                var data = [
                '\x1B' + '\x61' + '\x31', // center align
                   { type: 'raw', format: 'image', data: 'img/logo.png', options: { language: "escp", dotDensity: 'double' } },
                    '\x1B' + '\x40',          // init
                    '\x1B' + '\x4D' + '\x31', // small text
                    '\x1B' + '\x61' + '\x31', // center align
                    'MINI DESPENSA CRISTY',
                    '\x0A',                 // line break
                    'Calle Principal, Concepcion Las Minas',
                    '\x0A',                 // line break
                    'Chiquimula, Guatemala',
                    '\x0A',                 // line break
                    'TEL. 7942-1383',
                    '\x0A',                   // line break
                ];

                $.ajax({
                    type: 'GET',
                    url: "user/ventas/printInvoice",
                    data: { venta_id: {{ Input::get('venta_id') }} },
                    success: function(result)
                    {
                        if (!result.success) {
                            return msg.warning('Debe ingresar algun producto para poder imprimir', 'Advertencia!')
                        }

                        data.push("Fecha: " + result.fecha);
                        data.push('\x0A' + '\x0A');
                        data.push('\x1B' + '\x61' + '\x30'); // left align

                        data.push(result.cliente);
                        data.push('\x0A');
                        data.push(result.direccion);
                        data.push('\x0A');
                        data.push(result.nit);
                        data.push('\x0A' + '\x0A');

                        data.push("  CTD               DESCRIPCION                PRECIO      TOTAL");
                        data.push('\x0A');

                        $.each(result.detalle, function(i, v) {
                            data.push(result.detalle[i]['descripcion']);
                            data.push('\x0A');
                        });

                        data.push('\x1B' + '\x61' + '\x30');  // left align
                        data.push('  --------------------------------------------------------------');
                        data.push('\x0A');
                        data.push('\x1B' + '\x61' + '\x32'), // right align
                        data.push(result.total);
                        data.push('\x0A' + '\x0A' + '\x0A');
                        data.push('\x1B' + '\x61' + '\x31');  // center align

                        data.push('\x1B' + '\x21' + '\x30'); // em mode on
                        data.push('Gracias por su compra!');
                        data.push('\x1B' + '\x21' + '\x0A' + '\x1B' + '\x45' + '\x0A'); // em mode off

                        data.push('\x0A');
                        data.push('\x0A' + '\x0A' + '\x0A' + '\x0A' + '\x0A' + '\x0A' + '\x0A');
                        data.push('\x1B' + '\x69');  // cut paper
                        qz.print(config, data).catch(function(e) { console.error(e); })
                    }
                });
            },

            // imprimirFactura: function(e) {
            //     printInvoice(e.target, {{ Input::get('venta_id') }}, null);
            //     e.target.disabled = false;
            // },

            imprimirGarantia: function(e){
                ImprimirGarantia(e.target, {{ Input::get('venta_id') }}, null);
                e.target.disabled = false;
            }
        }
    });

</script>

<style type="text/css">
    .resta_abonar {
        font-size: 60px;
        text-align: center;
        margin-top: 25px;
        margin-bottom: 40px;
        color:#878787;
    }

    .vuelto {
        text-align: center;
    }

    .vuelto label {
        display: none;
        font-size: 20px;
    }

    .modal_header {
        background-color: #f5f5f5 !important;
        border-bottom: 1px solid #e5e5e5 !important;
        color: #878787;
    }

    .modal_header {
        padding: 10px 15px 2px;
        margin-top: -10px !important;
        margin-bottom: 10px;
    }

    .disabledSubmit {
        pointer-events: none;
        opacity: 0.4;
    }
</style>
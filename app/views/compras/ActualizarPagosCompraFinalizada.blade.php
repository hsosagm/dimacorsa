<div id="actualizarPagosContainer">
    <div class="cuerpoPagos" style="height:380px">


        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <input type="text" class="input_numeric form-control" v-model="form.monto">
            </div>
            <div class="col-md-4">
                <select class="form-control" id="metodoPagoSelect">
                    <option v-repeat="mp: metodo_pago" value="@{{mp.id}}"> @{{ mp.descripcion }} </option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="button" value="enviar!" class="bg-theme form-control" v-on="click: agregarPago()">
            </div>
        </div>

        <br>
        <div class="row" style="margin-left:10px">
            <div class="col-md-4">Total: @{{ compra.total | currency ''}}</div>
            <div class="col-md-4">Abonado: @{{ totalAbonado | currency ''}}</div>
            <div class="col-md-4">Restante: @{{ saldoRestante | currency '' }} </div>
        </div>
        <br>

        <table class="table table-responsive" style="margin:15px; width:95%;">
            <thead>
                <tr>
                    <th class="center">Metodo de pago</th>
                    <th class="center">Monto</th>
                    <th class="center"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-repeat="dp: detallePagos">
                    <td> @{{ dp.descripcion }} </td>
                    <td class="right"> @{{ dp.monto | currency '' }}</td>
                    <td class="right">
                        <i class="fa fa-trash-o fa-lg icon-delete" v-on="click: eliminarPago($index)"></i>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2" v-show="(saldoRestante == 0)">
            <i class="fa fa-check fa-lg icon-success" v-on="click: submitPagosCompras()"></i>
        </div>
    </div>
<br>

<script>
	var actualizarPagosContainer = new Vue({

	    el: '#actualizarPagosContainer',

	    data: {

            form: {
                metodo_pago_id: "",
                descripcion: "",
                monto: "",
            },

            compra: [],

            metodo_pago: [],

            pagos: [],

            detallePagos: [],

            saldoRestante: 0,

            totalAbonado: 0
	    },

	    methods: {

            agregarPago: function() {
                if(this.validarForm() == true) {
                    var data = {
                        'metodo_pago_id': $("#metodoPagoSelect").val(),
                        'descripcion': this.buscarDescripcion(),
                        'monto': this.form.monto,
                    };
                    this.detallePagos.push(data);
                    this.calcularTotales();
                    this.resetForm();
                }
            },

            buscarDescripcion: function() {
                for (var i = this.metodo_pago.length - 1; i >= 0; i--) {
                    if(this.metodo_pago[i]["id"] == $("#metodoPagoSelect").val()) {
                        return this.metodo_pago[i]["descripcion"];
                    }
                }
            },

            validarForm: function() {
                for (var i = this.detallePagos.length - 1; i >= 0; i--) {
                    if(this.detallePagos[i]["metodo_pago_id"] == $("#metodoPagoSelect").val()) {
                        return msg.warning('El metodo de pago ya ha sido ingresado..!');
                    }
                }

                if (this.form.metodo_pago <= 0)
                    return msg.warning('Escoja un metodo de pago..!');

                if (parseFloat(this.form.monto) <= 0 || this.form.monto == "")
                    return msg.warning('Ingrese monto..!');

                if (parseFloat(this.form.monto) > this.saldoRestante)
                    return msg.warning('El monto ingresado es mayor que el saldo restante..!');
                else
                    return true;
            },

            eliminarPago: function(index) {
                this.detallePagos.$remove(index);
                this.calcularTotales();
            },

            asignarMetodo: function(metodo_pago_id, descripcion) {
                this.form.metodo_pago_id = metodo_pago_id;
                this.form.descripcion = descripcion;
            },

            resetForm: function() {
                this.form.metodo_pago_id = "";
                this.form.monto = this.saldoRestante;
            },

            calcularTotales: function() {
                var sum = 0
                for (var i = this.detallePagos.length - 1; i >= 0; i--) {
                    sum += parseFloat(this.detallePagos[i]["monto"])
                }

                this.totalAbonado = sum;
                this.saldoRestante = this.compra.total - sum;
            },

            submitPagosCompras: function() {
                $.ajax({
                    url: "admin/compras/actualizarPagosCompraFinalizada",
                    type: "POST",
                    data: {
                        pagos: actualizarPagosContainer.detallePagos ,
                        compra: actualizarPagosContainer.compra
                    },
                }).done(function(data) {
                    if (data.success == true) {
                        $('.bs-modal').modal('hide');
                        return msg.success('Pagos actualizados con exito...','!Listo');
                    }

                    msg.warning(data,'!Advertencia');
                });
            }
	    }
	});

   function actualizarPagosContainerCompile() {
	    actualizarPagosContainer.$nextTick(function() {
	        actualizarPagosContainer.$compile(actualizarPagosContainer.$el);
	    });
	}

    actualizarPagosContainer.compra = {{ json_encode($compra) }};
    actualizarPagosContainer.metodo_pago = {{ json_encode($metodo_pago) }};
    actualizarPagosContainer.saldoRestante = {{ $compra->total }};
    actualizarPagosContainer.form.monto = {{ $compra->total }};

</script>

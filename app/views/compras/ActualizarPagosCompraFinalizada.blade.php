<div id="actualizarPagosContainer" style="height:380px">

    <div class="row">

    </div>

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
            <input type="button" value="enviar!" class="bg-theme" v-on="click: agregarPago()">
        </div>
    </div>

    <br><br>

    <table class="table table-responsive" style="margin:15px; width:95%;">
        <thead>
            <tr>
                <th class="center">Metodo de pago</th>
                <th class="center">Monto</th>
            </tr>
        </thead>
        <tbody>
            <tr v-repeat="dp: detallePagos">
                <td> @{{ dp.descripcion }} </td>
                <td class="right"> @{{ dp.monto | currency '' }}</td>
            </tr>
        </tbody>
    </table>
</div>

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

	    },

	    methods: {

            agregarPago: function() {
                if(this.validarForm() == true) {
                    var data = {
                        'metodo_pago_id': $("#metodoPagoSelect").val(),
                        'descripcion': this.buscarDescripcion(),
                        'monto': this.form.monto,
                    };
                    this.saldoRestante -= this.form.monto;
                    this.detallePagos.push(data);
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

            eliminarPago: function() {

            },

            asignarMetodo: function(metodo_pago_id, descripcion) {
                this.form.metodo_pago_id = metodo_pago_id;
                this.form.descripcion = descripcion;
            },

            resetForm: function() {
                this.form.metodo_pago_id = "";
                this.form.monto = this.saldoRestante;
            },

            guardarCambios: function() {

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

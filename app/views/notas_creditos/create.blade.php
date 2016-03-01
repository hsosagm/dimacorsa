<div id="formContainerAdelanto">
	<input type="hidden" name="cliente_id" v-model="cliente.id" >
	<div align="center">
		<strong>
			<label> @{{ cliente.nombre | empty }} - @{{ cliente.direccion | empty }} </label>
		</strong>
	</div>

	<div class="row">
		<div class="col-md-10" style="margin-left: 25px">
			<input type="text" id="cliente" class="form-control">
		</div>
			<i v-if="cliente.id" class="fa fa-pencil btn-link theme-c" v-on="click: showEditCustomer"></i>
			<i class="fa fa-plus-square btn-link theme-c" v-on="click: showNewCustomer"></i>
	</div>
	<div class="row">
		<div class="col-md-10" style="margin-left: 25px; margin-top: 10px;">
			<textarea v-model="descripcion" class="form-control" placeholder="Descripcion"></textarea>
		</div>
	</div>

	<div class="CustomerForm" v-if="showNewCustomerForm" v-transition>
		{{ Form::open(array('url' => '/user/cliente/create', 'v-on="submit: createNewCustomer"')) }}
			<div class="row">
			    <div class="col-md-9">
			        <h4>Nuevo cliente</h4>
			    </div>
			</div>

			<div class="row">
			    <div class="col-md-6">
			        <input type="text" name="nombre" style="width: 100% !important;" class="input sm_input" placeholder="Nombre">
			    </div>

			    <div class="col-md-3">
			        <input type="text" name="direccion" style="width: 100% !important;" class="input sm_input" placeholder="Direccion">
			    </div>
			</div>
			<br>
			<div class="row">
			    <div class="col-md-3">
			        <input type="text" name="nit" style="width: 100% !important;" class="input sm_input" placeholder="Nit">
			    </div>

			    <div class="col-md-3">
			        <input type="text" name="telefono" style="width: 100% !important;" class="input sm_input" placeholder="Telefono">
			    </div>

			    <div class="col-md-3">
			        <input type="text" name="email" style="width: 100% !important;" class="sm_input" placeholder="Email">
			    </div>
			</div>
			<br>
			<div class="row">
			    <div class="col-md-3"></div>
			    <div class="col-md-3"></div>
			    <div class="col-md-3">
			        <input class="btn theme-button form-control" value="Guardar!" type="submit">
			    </div>
			</div>
		{{ Form::close() }}
	</div>

	<div class="CustomerForm" v-if="showEditCustomerForm" v-transition>
		{{ Form::open(array('url' => '/user/cliente/edit', 'v-on="submit: editCustomer"')) }}
		<input type="hidden" name="id" v-model="cliente.id">

		<div class="row">
			    <div class="col-md-9">
			        <h4>Editar cliente</h4>
			    </div>
			</div>

			<div class="row">
			    <div class="col-md-6">
			        <input type="text" name="nombre" value="@{{cliente.nombre}}" style="width: 100% !important;" class="input sm_input" placeholder="Nombre">
			    </div>

			    <div class="col-md-3">
			        <input type="text" name="direccion"  value="@{{cliente.direccion}}" style="width: 100% !important;" class="input sm_input" placeholder="Direccion">
			    </div>
			</div>
			<br>
			<div class="row">
			    <div class="col-md-3">
			        <input type="text" name="nit" value="@{{cliente.nit}}" style="width: 100% !important;" class="input sm_input" placeholder="Nit">
			    </div>

			    <div class="col-md-3">
			        <input type="text" name="telefono" value="@{{cliente.telefono}}" style="width: 100% !important;" class="input sm_input" placeholder="Telefono">
			    </div>

			    <div class="col-md-3">
			        <input type="text" name="email" value="@{{cliente.email}}" style="width: 100% !important;" class="sm_input" placeholder="Email">
			    </div>
			</div>
			<br>
			<div class="row">
			    <div class="col-md-3"></div>
			    <div class="col-md-3"></div>
			    <div class="col-md-3">
			        <input class="btn theme-button inputGuardar" value="Actualizar!" type="submit">
			    </div>
			</div>
		{{ Form::close() }}
	</div>

	<hr>

	<div v-show="cliente.id" style="margin-top: 10px; margin-left:7px;">
		<div class="col-md-5">
			<input type="text" id="montoPago" v-on="keyup : agregarPago() | key 'enter'" class="form-control col-md-8" v-model="form.monto" placeholder="Monto">
		</div>
		<div class="col-md-5">
			<select v-model="form.metodo_pago_id" options="metodo_pago" v-on="keyup : agregarPago() | key 'enter'" class="form-control"></select>
		</div>
		<div class="col-md-2"> <i class="fa fa-check fg-theme" style="font-size:25px; margin-top: 3px;" v-on="click: agregarPago()" ></i> </div>
	</div>

	<br><br>

	<div style="margin-top: 10px;">
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
                    <td> @{{ buscarDescripcion(dp.metodo_pago_id) }} </td>
                    <td class="right"> @{{ dp.monto | currency '' }} </td>
                    <td class="right">
                        <i class="fa fa-trash-o fa-lg icon-delete" v-on="click: eliminarPago($index)"></i>
                    </td>
                </tr>
            </tbody>
        </table>
	</div>

	<div class="form-footer footer" style="margin-top: 30px;" align="right">
		<button v-on="click: enviarAbono($event)" v-if="detallePagos.length" class="btn theme-button ">Enviar!</button>
	</div>
</div>


<script>
	var adelantosVue = new Vue({

		el: '#formContainerAdelanto',

		data: {
			cliente: [],

			showNewCustomerForm: false,

			showEditCustomerForm: false,

			form: { monto: "", metodo_pago_id: 1},

			detallePagos: [],

			totalAdelanto: 0,

			descripcion: "",

			metodo_pago: {{ json_encode($metodo_pago) }},
		},

		computed: {

			FullName: function () {
				return this.cliente.nombre + ' ' + this.cliente.apellido
			}
		},

		filters: {
			empty: function(value) {

				return ($.trim(value) == null)?  "":  value;
			}
		},

		watch: {

			"detallePagos": function() {
	            var sum = 0;
	            for (var i = 0; i < this.detallePagos.length; i++)
	                sum += parseFloat(this.detallePagos[i]["monto"]);

	            this.totalAdelanto = sum;
			}
		},

		directives: {
			'item-focus': function () {
				this.el.focus();
			}
		},

		methods: {

			agregarPago: function() {
                if(this.validarForm()) {
                    this.detallePagos.push({
                    	monto: this.form.monto.replace(",", ""),
                    	metodo_pago_id: this.form.metodo_pago_id
                    });

                    this.form = { monto: "", metodo_pago_id: 1};
                    $("#montoPago").focus();
                }
            },

            buscarDescripcion: function(metodo_pago_id) {
                for ( var i = 0; i < this.metodo_pago.length; i++ )
                    if( this.metodo_pago[i]["value"] == metodo_pago_id )
                        return this.metodo_pago[i]["text"];
            },

            validarForm: function() {
                for (var i = 0; i < this.detallePagos.length; i++)
                    if(this.detallePagos[i]["metodo_pago_id"] == this.form.metodo_pago_id)
                        return msg.warning('El metodo de pago ya ha sido ingresado..!');

                if (parseFloat(this.form.monto) <= 0 || this.form.monto == "" || this.form.monto == null)
                    return msg.warning('Ingrese monto..!');

                if (!this.form.metodo_pago_id)
                    return msg.warning('Seleccione un metodo de pago..!');

                return true;
            },

            eliminarPago: function(index) {
                this.detallePagos.$remove(index);
            },

			reset: function() {
				adelantosVue.cliente = [];
			},

			showEditCustomer: function() {
				this.showNewCustomerForm = false;
				this.showEditCustomerForm = !this.showEditCustomerForm;
			},

			showNewCustomer: function() {
				this.showEditCustomerForm = false;
				this.showNewCustomerForm = !this.showNewCustomerForm;
			},

			getInfoCliente: function(id) {
				$.get( "/user/cliente/getInfo",  { id: id }, function( data ) {
					adelantosVue.cliente = data;
				});
			},

			createNewCustomer: function(e) {
				var form = $(e.target).closest("form");
				$('input[type=submit]', form).prop('disabled', true);

				$.ajax({
					type: form.attr('method'),
					url: form.attr('action'),
					data: form.serialize(),
				}).done(function(data) {
					if (data.success) {
						adelantosVue.cliente = data.info;
						adelantosVue.showNewCustomerForm = false;
						return msg.success('Cliente creado', 'Listo!');
					}

					$('input[type=submit]', form).prop('disabled', false);
					msg.warning(data, 'Advertencia!');
				});

				e.preventDefault();
			},


			editCustomer: function(e) {
				var form = $(e.target).closest("form");
				$('input[type=submit]', form).prop('disabled', true);

				$.ajax({
					type: form.attr('method'),
					url: form.attr('action'),
					data: form.serialize(),
				}).done(function(data) {
					if (data.success) {
						adelantosVue.cliente = data.info;
						adelantosVue.showEditCustomerForm = false;
						return msg.success('Cliente actualizado', 'Listo!');
					}

					$('input[type=submit]', form).prop('disabled', false);
					msg.warning(data, 'Advertencia!');
				});

				e.preventDefault();
			},

			enviarAbono: function(e) {
				$.confirm({
					text: "esta seguro que desea finalizar el abono?",
					title: "Confirmacion",
					confirm: function(){
						e.target.disabled = true;
						$.ajax({
							type: "POST",
							url: '/user/adelantos/create',
							data: {
								cliente_id: adelantosVue.cliente.id,
								descripcion: adelantosVue.descripcion,
								totalAdelanto: adelantosVue.totalAdelanto,
								detallePagos: adelantosVue.detallePagos,
							},
						}).done(function(data) {
							if (data.success){
								msg.success('Adelanto creado..', 'Listo!')
								window.open('user/adelantos/comprobante?adelanto_id='+data.adelanto_id ,'_blank');
								return $('.bs-modal').modal('hide');
							}
							e.target.disabled = false;
							msg.warning(data, 'Advertencia!');
						});
					}
				});
			},
		}

	});


	function adelantosCompile() {
		adelantosVue.$nextTick(function() {
			adelantosVue.$compile(adelantosVue.$el);
		});
	}

	$('#cliente').autocomplete({
		serviceUrl: '/user/cliente/search',
		onSelect: function (data) {
			adelantosVue.getInfoCliente(data.id);
			$('#cliente').val("");
			adelantosVue.verCliente = true;
		}
	});

	$('#montoPago').number( true, 2 );

</script>

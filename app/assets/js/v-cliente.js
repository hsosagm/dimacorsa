var vm = new Vue({

    el: 'body',

    data: {
    	customer_search: '',
    	PanelBody: false,
    	tableDetail: '',
    	cliente_id: '',
    	divAbonosPorSeleccion: '',
    	infoCliente: '',
    	saldo_total: '',
    	saldo_vencido: '',
    	saldoParcial: '',
    	monto: '',
    },

    ready: function() {

    },

    methods: {

    	resetSaldoParcial: function(e) {
    		this.saldoParcial = '';
    		this.monto = e.target.value;
    		$('.montoAbono').val(0);
    	},

    	clearPanelBody: function() {
    		this.PanelBody = false;
    		this.tableDetail = '';
    		$('.table').html('');
    		$('.dt-container').hide();
    	},

    	setMonto: function() {
    		this.monto = $('.montoAbono').autoNumeric('get');
    	},

    	getInfoCliente: function(id) {
	        $.ajax({
	            type: 'GET',
	            url: "user/cliente/getInfoCliente",
	            data: { cliente_id: id },
	            success: function (data) {
	                if (data.success == true)
	                {
	                    vm.infoCliente   = data.info;
	                    vm.saldo_total   = data.saldo_total;
	                    vm.saldo_vencido = data.saldo_vencido;
	                    GetSalesForPaymentsBySelection(1, null);
	                    vm.updateMonto();
	                    return;
	                }
	                msg.warning(data, 'Advertencia!');
	            }
	        });
    	},

    	updateMonto: function() {
			vm.$nextTick(function() {
				if (vm.PanelBody) {
			        var selectedMonto = $("input[type='radio'][name='monto']:checked").val();
			        if (selectedMonto == 'on') {
			        	vm.monto = $('#monto').val();
			        	return;
			        };
			        vm.monto = selectedMonto;
				};
		    });
    	},

    	montoFocus: function() {
    		setTimeout(function() {
    			vm.monto = parseFloat(0);
    			$('.montoAbono').focus();
    		}, 100);
    	},

    	updateInfoCliente: function() {
	        $.ajax({
	            type: 'GET',
	            url: "user/cliente/getInfoCliente",
	            data: { cliente_id: vm.cliente_id },
	            success: function (data) {
	                if (data.success == true)
	                {
	                    vm.infoCliente   = data.info;
	                    vm.saldo_total   = data.saldo_total;
	                    vm.saldo_vencido = data.saldo_vencido;
	                    return vm.updateMonto();
	                }
	                msg.warning(data, 'Advertencia!');
	            }
	        });
    	},


        getFormAbonosVentas: function() {
        	vm.clearPanelBody();

		    $.ajax({
		        type: 'GET',
		        url: "user/ventas/payments/formPayments",
		        data: { cliente_id: vm.cliente_id },
		        success: function (data) {

		            if (data.success == true)
		            {
		                $("#table_length").html("");
		                $(".PanelBody").html(data.form);
		                vm.PanelBody = true;
		                SST_search();
		                return compile();
		            }

		            msg.warning(data, 'Advertencia!');
		        } 
		    });
        },


        onSubmitForm: function(e) {

            e.preventDefault();
            var form = $(e.target).closest("form");
            $('input[type=submit]', form).prop('disabled', true);

            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function (data) {
		            if (data.success == true)
		            {
		            	vm.tableDetail = data.detalle;
		                msg.success('Abono ingresado', 'Listo!');
		                vm.updateInfoCliente();
		                $('input[type=submit]', form).prop('disabled', false);
		                return compile();
		            }
		            msg.warning(data, 'Advertencia!');
		            $('input[type=submit]', form).prop('disabled', false);
                }
            });
        },


        eliminarAbono: function(e, abonos_ventas_id) {

        	$('input[type=button]', e.target).prop('disabled', true);

		    $.ajax({
		        type: 'POST',
		        url: "user/ventas/payments/eliminarAbonoVenta",
		        data: { abonos_ventas_id: abonos_ventas_id },
		        success: function (data) {

		            if (data == 'success')
		            {
		                msg.success('Abonos Eliminados', 'Listo!');
		                vm.tableDetail = '';
		                vm.updateInfoCliente();
		                return;
		            }

		            msg.warning(data, 'Advertencia!');
		            $('input[type=button]', e.target).prop('disabled', false);
		        }
		    });
        },

        eliminarAbonoPorSeleccion: function(e, abonos_ventas_id) {

        	$('input[type=button]', e.target).prop('disabled', true);

		    $.ajax({
		        type: 'POST',
		        url: "user/ventas/payments/eliminarAbonoVenta",
		        data: { abonos_ventas_id: abonos_ventas_id },
		        success: function (data) {

		            if (data == 'success')
		            {
		                msg.success('Abonos Eliminados', 'Listo!');
		                vm.updateInfoCliente();
		                vm.GetSalesForPaymentsBySelection();
		                return;
		            }

		            msg.warning(data, 'Advertencia!');
		            $('input[type=button]', e.target).prop('disabled', false);
		        }
		    });
        },

        GetSalesForPaymentsBySelection: function() {

		    $.ajax({
		        type: 'GET',
		        url: "user/ventas/payments/formPaymentsPagination",
		        data: { cliente_id: vm.cliente_id, sSearch: null },
		        success: function (data) {
		            if (data.success == true)
		            {
		                vm.divAbonosPorSeleccion = data.table;
		                return compile();
		            }

		            msg.warning(data, 'Advertencia!');
		        }
		    });

        },

        editCustomer: function() {

	        $.ajax({
	            type: "POST",
	            url: "user/cliente/edit",
	            data: {id: vm.cliente_id },
	            contentType: 'application/x-www-form-urlencoded',
	            success: function (data) {
	                $('.modal-body').html(data);
	                $('.modal-title').text('Editar cliente');
	                $('.bs-modal').modal('show');
	            },
	            error: function (request, status, error) {
	                alert(request.responseText);
	            }
	        });

        },

        salesByCustomer: function() {

            $.get( "/user/cliente/salesByCustomer", function( data ) {
	            if (data.success == true)
	            {
	               return generate_dt(data.table);
	            }
	            
	            msg.warning('Hubo un error intentelo de nuevo', 'Advertencia!');
            });

        },
        imprimirAbonoVenta: function(e,id) {
        	 window.open('user/ventas/payments/imprimirAbonoVenta/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
        },
        getHistorialAbonos: function() {

        	this.PanelBody = false;
        	$('.dt-container').hide();

		    $.ajax({
		        type: 'GET',
		        url: "user/cliente/getHistorialAbonos",
		        data: { cliente_id: vm.cliente_id, sSearch: null },
		        success: function (data) {
		            if (data.success == true)
		            {
		            	return $('.table').html(data.table);
		            }

		            msg.warning(data, 'Advertencia!');
		        }
		    });

        }
    }
});


function compile() {
    vm.$nextTick(function() {
    	vm.$compile(vm.$el);
    });
}
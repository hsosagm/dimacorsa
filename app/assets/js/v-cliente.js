var vm = new Vue({

    el: 'body',

    data: {
    	customer_search: '',
    	PanelBody: '',
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
    	},


    	clearPanelBody: function() {
    		this.PanelBody = '';
    		vm.tableDetail = '';
    		$('.table').html('');
    		$('.dt-container').hide();
    	},


    	getInfoCliente: function(id) {
	        $.ajax({
	            type: 'GET',
	            url: "user/cliente/info_cliente",
	            data: { cliente_id: id },
	            success: function (data) {
	                if (data.success == true)
	                {
	                    vm.infoCliente   = data.info;
	                    vm.saldo_total   = data.saldo_total;
	                    vm.saldo_vencido = data.saldo_vencido;
	                    GetSalesForPaymentsBySelection();
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
    			$('#monto').focus();
    		}, 100);
    	},

    	updateInfoCliente: function() {
	        $.ajax({
	            type: 'GET',
	            url: "user/cliente/info_cliente",
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
		                vm.PanelBody = data.form;
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
    }
});


function compile() {
    vm.$nextTick(function() {
    	vm.$compile(vm.$el);
    });
}
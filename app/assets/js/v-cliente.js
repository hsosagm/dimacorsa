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

    methods: {

    	resetSaldoParcial: function(e) {
    		this.saldoParcial = '';
    		this.monto = e.target.value;
    		$('.montoAbono').val(0);
    	},

    	clearPanelBody: function() {
    		
    	},

		generate_dt: function(data) {
			$('#main_container').hide();
		    $('#main_container').html(data);
		    $("#iSearch").unbind().val("").focus();
		    $("#table_length").html("");

		    setTimeout(function() {
		        $('#example').dataTable();
		        $('#example_length').prependTo("#table_length");
		        $('#main_container').show();
		        $('#iSearch').keyup(function() {
		            $('#example').dataTable().fnFilter( $(this).val() );
		        });
		    }, 0);
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
	                    return vm.updateMonto();
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
			            $('#main_container').show();
			            $('#main_container').html(data.form);
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
	               vm.generate_dt(data.table);
	               return compile();
	            }
	            msg.warning('Hubo un error intentelo de nuevo', 'Advertencia!');
            });
        },

		creditSalesByCustomer: function() {
		    $.ajax({
		        type: 'GET',
		        url: "user/cliente/creditSalesByCustomer",
		        data: { cliente_id: vm.cliente_id },
		        success: function (data) {
		            if (data.success == true) {
		                vm.generate_dt(data.table);
		                return compile();
		            }
		            msg.warning('Hubo un error intentelo de nuevo', 'Advertencia!');
		        }
		    }); 
		},

        imprimirAbonoVenta: function(e,id) {
        	 window.open('user/ventas/payments/imprimirAbonoVenta/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
        },
        
        getHistorialAbonos: function() {
		    $.ajax({
		        type: 'GET',
		        url: "user/cliente/getHistorialAbonos",
		        data: { cliente_id: vm.cliente_id, sSearch: null },
		        success: function (data) {
		            if (data.success == true)
		            {
		            	vm.historialAbonos = data.data;
		            	$('#main_container').hide();
		                $('#main_container').html(data.table);
		            	vm.$compile(vm.$el);

					    setTimeout(function() {
					        $('#example').dataTable();
					        $('#example_length').prependTo("#table_length");
					        $('#main_container').show();
					        $('#iSearch').keyup(function() {
					            $('#example').dataTable().fnFilter( $(this).val() );
					        });
					    }, 0);
		            	return;
		            }
		            msg.warning(data, 'Advertencia!');
		        }
		    });
        },

        togleDetalleAbonos: function(e, av) {
	        var that = av.active;
			$('.subtable').remove();

			this.historialAbonos.forEach(function(av){
				av.$set('active', false);
			});

			if (that != true) {
				av.$set('active', true);
			    $(e.$el).after("<tr class='subtable'> <td colspan=7><div class='grid_detalle_factura'></div></td></tr>");

			    $.ajax({
			        type: 'GET',
			        url: "user/ventas/payments/getDetalleAbono",
			        data: { abono_id: av.id },
			        success: function (data) {
			            if (data.success == true)
			            {
			                $('.grid_detalle_factura').html(data.table);
			                return $(e.$el).next('.subtable').fadeIn('slow');
			            }
			            msg.warning(data, 'Advertencia!');
			        }
			    });
			}
        },

        imprimirAbonoVenta: function(e ,av) {
			window.open('user/ventas/payments/imprimirAbonoVenta/dt/'+av.id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
    	},

        getHistorialPagos: function() {
        	this.PanelBody = false;
        	$('.dt-container').hide();

		    $.ajax({
		        type: 'GET',
		        url: "user/cliente/getHistorialPagos",
		        data: { cliente_id: vm.cliente_id, sSearch: null },
		        success: function (data) {
		            if (data.success == true)
		            {
		            	vm.historialPagos = data.data;
		            	$('#main_container').hide();
		                $('#main_container').html(data.table);
		            	vm.$compile(vm.$el);

					    setTimeout(function() {
					        $('#example').dataTable();
					        $('#example_length').prependTo("#table_length");
					        $('#main_container').show();
					        $('#iSearch').keyup(function() {
					            $('#example').dataTable().fnFilter( $(this).val() );
					        });
					    }, 0);
		            	return;
		            }
		            msg.warning(data, 'Advertencia!');
		        }
		    });
        },

        chartVentasPorCliente: function() {
		    $.ajax({
		        type: "GET",
		        url: 'user/chart/chartVentasPorCliente',
		        data: { cliente_id: vm.cliente_id },
		    }).done(function(data) {
		        if (data.success == true)
		        {
		            $('#main_container').show();
		            $('#main_container').html(data.view);
		            return compile();
		        }
		        msg.warning(data, 'Advertencia!');
		    }); 
        },

        closeMainContainer: function() {
        	$('#main_container').hide();
        }

    }
});

function compile() {
    vm.$nextTick(function() {
    	vm.$compile(vm.$el);
    });
}
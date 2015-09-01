var vm = new Vue({

    el: 'body',

    data: {
    	ProviderFinder: '',
    	PanelBody: false,
    	tableDetail: '',
    	proveedor_id: '',
    	divAbonosPorSeleccion: '',
    	infoProveedor: '',
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
    		this.PanelBody = false;
    		this.tableDetail = '';
    		$('.table').html('');
    		$('.dt-container').hide();
    	},


    	setMonto: function() {
    		this.monto = $('.montoAbono').autoNumeric('get');
    	},


    	getInfoProveedor: function(id) {
	        $.ajax({
	            type: 'GET',
	            url: "admin/proveedor/getInfoProveedor",
	            data: { proveedor_id: id },
	            success: function (data) {
	            	console.log(data);
	                if (data.success == true)
	                {
	                    vm.infoProveedor = data.info;
	                    vm.saldo_total   = data.saldo_total;
	                    vm.saldo_vencido = data.saldo_vencido;
	                    GetPurchasesForPaymentsBySelection(1, null);
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


    	updateInfoProveedor: function() {
	        $.ajax({
	            type: 'GET',
	            url: "admin/proveedor/getInfoProveedor",
	            data: { proveedor_id: vm.proveedor_id },
	            success: function (data) {
	                if (data.success == true)
	                {
	                    vm.infoProveedor   = data.info;
	                    vm.saldo_total   = data.saldo_total;
	                    vm.saldo_vencido = data.saldo_vencido;
	                    return vm.updateMonto();
	                }
	                msg.warning(data, 'Advertencia!');
	            }
	        });
    	},


        getFormAbonos: function() {
        	vm.clearPanelBody();

		    $.ajax({
		        type: 'GET',
		        url: "admin/compras/payments/formPayments",
		        data: { proveedor_id: vm.proveedor_id },
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


        postFormAbonos: function(e) {
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
		                vm.updateInfoProveedor();
		                $('input[type=submit]', form).prop('disabled', false);
		                return compile();
		            }
		            msg.warning(data, 'Advertencia!');
		            $('input[type=submit]', form).prop('disabled', false);
                }
            });
        },


        eliminarAbono: function(e, abonos_compra_id) {
        	$('input[type=button]', e.target).prop('disabled', true);

		    $.ajax({
		        type: 'POST',
		        url: "admin/compras/payments/eliminarAbono",
		        data: { abonos_compra_id: abonos_compra_id },
		        success: function (data) {
		            if (data == 'success')
		            {
		                msg.success('Abono Eliminado', 'Listo!');
		                vm.tableDetail = '';
		                vm.updateInfoProveedor();
		                return;
		            }
		            msg.warning(data, 'Advertencia!');
		            $('input[type=button]', e.target).prop('disabled', false);
		        }
		    });
        },


        eliminarAbonoPorSeleccion: function(e, abonos_compra_id) {
        	$('input[type=button]', e.target).prop('disabled', true);

		    $.ajax({
		        type: 'POST',
		        url: "admin/compras/payments/eliminarAbono",
		        data: { abonos_compra_id: abonos_compra_id },
		        success: function (data) {
		            if (data == 'success')
		            {
		                msg.success('Abonos Eliminados', 'Listo!');
		                vm.updateInfoProveedor();
		                return vm.GetPurchasesForPaymentsBySelection();
		            }
		            msg.warning(data, 'Advertencia!');
		            $('input[type=button]', e.target).prop('disabled', false);
		        }
		    });
        },


        GetPurchasesForPaymentsBySelection: function() {

		    $.ajax({
		        type: 'GET',
		        url: "admin/compras/payments/formPaymentsPagination",
		        data: { proveedor_id: vm.proveedor_id, sSearch: null },
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


        getEditarProveedor: function() {

	        $.ajax({
	            type: "POST",
	            url: "admin/proveedor/edit",
	            data: { id: vm.proveedor_id },
	            contentType: 'application/x-www-form-urlencoded',
	            success: function (data) {
	                $('.modal-body').html(data);
	                $('.modal-title').text('Editar proveedor');
	                $('.bs-modal').modal('show');
	            },
	            error: function (request, status, error) {
	                alert(request.responseText);
	            }
	        });

        },


        getHistorialCompras: function() {
        	this.PanelBody = false;

		    $.ajax({
		        type: "GET",
		        url: "admin/compras/ConsultPurchase",
		        data: { proveedor_id: vm.proveedor_id },
		        contentType: 'application/x-www-form-urlencoded',
		        success: function (data) {
		            makeTable(data, '', 'Compras');
		        }
		    });
        },


        getComprasPendientesDePago: function() {
        	this.PanelBody = false;

		    $.ajax({
		        type: 'GET',
		        url: "admin/compras/ShowTableUnpaidShopping",
		        data: { proveedor_id: vm.proveedor_id },
		        success: function (data) {
		            if (data.success == true)
		            {
		                setTimeout(function()
		                {
		                    $('#example_length').prependTo("#table_length");
		                    $('.dt-container').show();
		                    $('#iSearch').keyup(function() {
		                        $('#example').dataTable().fnFilter( $(this).val() );
		                    })
		                }, 300);

		                return generate_dt_local(data.table);
		            }
		            msg.warning('Hubo un error intentelo de nuevo', 'Advertencia!');
		        }
		    }); 
        },


        getHistorialAbonos: function() {
        	this.PanelBody = false;

	        $.ajax({
	            type: "GET",
	            url: "admin/compras/ShowTableHistoryPaymentDetails",
	            data: { proveedor_id: vm.proveedor_id },
	            contentType: 'application/x-www-form-urlencoded',
	            success: function (data) {
	                makeTable(data, 'admin/compras/payments/', 'Pagos');
	            },
	            error: function (request, status, error) {
	                alert(request.responseText);
	            }
	        });
        },


        getHistorialPagos: function() {
        	this.PanelBody = false;

	        $.ajax({
	            type: "GET",
	            url: "admin/compras/ShowTableHistoryPayment",
	            data: { proveedor_id: vm.proveedor_id },
	            contentType: 'application/x-www-form-urlencoded',
	            success: function (data) {
	                makeTable(data, '', 'Pagos');
	            }
	        });
        },

		chartComprasPorProveedor: function() {
			$.ajax({
				type: "GET",
				url: 'admin/chart/ComprasPorProveedor',
				data: { proveedor_id: vm.proveedor_id },
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


		chartComparativaPorMesPorProveedor: function() {
			$.ajax({
				type: "GET",
				url: 'admin/chart/ComparativaPorMesPorProveedor',
				data: { proveedor_id: vm.proveedor_id },
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
			vm.showFilter = false;
			vm.formPayments = false;
		}

    }
});


function compile() {
    vm.$nextTick(function() {
    	vm.$compile(vm.$el);
    });
}

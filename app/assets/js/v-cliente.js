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
		cliente_id_creditos: '',
	},

	methods: {

		resetSaldoParcial: function(e) {
			this.saldoParcial = '';
			this.monto = e.target.value;
			$('.montoAbono').val(0);
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
				data: { id: vm.cliente_id },
				success: function (data) {
					$('#main_container').hide();
					$('#main_container').html(data);
					$('#main_container').show();
					return compile();
				}
			});
		},


		salesByCustomer: function() {
			$.get( "/user/cliente/salesByCustomer", function( data ) {
				if (data.success == true)
				{
					return vm.proccesDataTable(data.table);
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
						return vm.proccesDataTable(data.table);
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
						return vm.proccesDataTable(data.table);
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


		imprimirAbonoVenta: function(e ,id) {
			$.ajax({
				type: "GET",
				url: 'user/ventas/payments/imprimirAbonoVenta/dt/'+id,
			}).done(function(data) {
				myWindow = window.open("", "MsgWindow", "width=800, height=500,toolbar=no,location=no,statusbar=no");
				myWindow.document.write(data);
			});
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
						return vm.proccesDataTable(data.table);
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


		chartComparativaPorMesPorCliente: function() {
			$.ajax({
				type: "GET",
				url: 'user/chart/chartComparativaPorMesPorCliente',
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
		},

		clientes_table: function() {
			$.get( "user/cliente/index", function( data ) {
				if (data.success == true)
				{ 
					vm.proccesDataTable(data.table);
					return $('#example').addClass('tableSelected');
				}
				msg.warning('Hubo un error intentelo de nuevo', 'Advertencia!');
			});
		},


		getVentasPedientesDePago: function() {
			$.ajax({
				type: 'GET',
				url: "user/ventas/getVentasPedientesDePago",
				success: function (data) {
					if (data.success == true)
					{
						vm.historialPagos = data.data;
						return vm.proccesDataTable(data.table);
					}
					msg.warning(data, 'Advertencia!');
				}
			}); 
		},


		VentasPendientesPorCliente: function(e, id) {
			vm.cliente_id_creditos = id;

			e = e.target;

			if ($(e).hasClass("hide_detail"))  {
				$(e).removeClass('hide_detail');
				$('.subtable').fadeOut('slow');
			} 
			else {
				$('.hide_detail').removeClass('hide_detail');
				if ( $( ".subtable" ).length ) {
					$('.subtable').fadeOut('slow', function(){
						vm.getVentasPendientesPorCliente(e, 1 , null);
					})
				}
				else 
					vm.getVentasPendientesPorCliente(e, 1 , null);
			}
		},


		getVentasPendientesPorCliente: function(e , page, sSearch) {
			$('.subtable').remove();
			var nTr = $(e).parents('tr')[0];
			$(e).addClass('hide_detail');
			$(nTr).after("<tr class='subtable'> <td colspan=6><div class='grid_detalle_factura'></div></td></tr>");
			$('.subtable').addClass('hide_detail');

			$.ajax({
				type: "GET",
				url: "user/ventas/getVentasPendientesPorCliente?page=" + page,
				data: {cliente_id: vm.cliente_id_creditos , sSearch:sSearch},
			}).done(function(data) {
				if (data.success == true) {
					$('.grid_detalle_factura').html(data.table);
					$(nTr).next('.subtable').fadeIn('slow');
					compile();
					return $(e).addClass('hide_detail');
				}
				msg.warning(data, 'Advertencia!');
			});
		},


		getVentasPendientesPorClientePaginacion: function(page , sSearch) {
			$.ajax({
				type: "GET",
				url: "user/ventas/getVentasPendientesPorCliente?page=" + page,
				data: {cliente_id: vm.cliente_id_creditos , sSearch:sSearch},
			}).done(function(data) {
				if (data.success == true)
					return  $('.grid_detalle_factura').html(data.table);

				msg.warning(data, 'Advertencia!');
			});
		},


		getVentaConDetalle: function(e, venta_id) {

			$.ajax({
				type: "GET",
				url: 'user/ventas/getVentaConDetalle',
				data: {venta_id: venta_id},
			}).done(function(data) {
				if (data.success == true)
				{
					$('.modal-body').html(data.table);
					$('.modal-title').text( 'Detalle de Venta' );
					return  $('.bs-modal').modal('show');
				}
				msg.warning(data, 'Advertencia!');
			});
		},


		crearCliente: function() {
			$.ajax({
				type: "POST",
				url: 'user/cliente/crearCliente',
			}).done(function(data) {
				if (data.success == true) {
					$('.modal-body').html(data.view);
					$('.modal-title').text( 'Crear Cliente');
					return $('.bs-modal').modal('show');
				}
				msg.warning(data, 'Advertencia!');
			});
		},


		actualizarCliente: function() {
			$.ajax({
				type: "POST",
				url: 'user/cliente/actualizarCliente',
				data: {cliente_id: $('.dataTable tbody .row_selected').attr('id')},
			}).done(function(data) {
				if (data.success == true) {
					$('.modal-body').html(data.view);
					$('.modal-title').text( 'Editar Cliente');
					return $('.bs-modal').modal('show');
				}
				msg.warning(data, 'Advertencia!');
			});
		},


		eliminarCliente: function() {
			$.confirm({
				confirm: function(){
					$.ajax({
						type: "POST",
						url: 'user/cliente/eliminarCliente',
						data: {cliente_id: $('.dataTable tbody .row_selected').attr('id')},
					}).done(function(data) {
						if (data.success == true) {
							msg.success('Cliente eliminado', 'Listo!')
							return $('.dataTable tbody .row_selected').hide();
						}
						msg.warning(data, 'Advertencia!');
					});
				}
			});
			$('.modal-title').text( 'Eliminar Cliente');
		},


		proccesDataTable: function(data) {
			$('#main_container').hide();
			$('#main_container').html(data);
			$("#iSearch").unbind().val("").focus();
			vm.$compile(vm.$el);

			setTimeout(function() {
				$('#example').dataTable();
				$('#example_length').prependTo("#table_length");
				$('#main_container').show();
				$('#iSearch').keyup(function() {
					$('#example').dataTable().fnFilter( $(this).val() );
				});
			}, 0);
		}

	}
});


function compile() {
	vm.$nextTick(function() {
		vm.$compile(vm.$el);
	});
}


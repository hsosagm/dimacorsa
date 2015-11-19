
var vm = new Vue({
	
	el: 'body',

	data: {
		customer_search: '',
		PanelBody: false,
		tableDetail: '',
		cliente_id: 0,
		divAbonosPorSeleccion: '',
		infoCliente: '',
		saldo_total: '',
		saldo_vencido: '',
		saldoParcial: '',
		monto: '',
		cliente_id_creditos: '',
		user_id_creditos: '',
		showFilter: false,
		formPayments: false, // si enta en true no oculta el div al canviar a otro cliente para poder seguir haciendo abonos.
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
			vm.tableDetail = '';
			$.ajax({
				type: 'GET',
				url: "user/ventas/payments/formPayments",
				data: { cliente_id: vm.cliente_id },
				success: function (data) {
					if (data.success == true)
					{
						$('#main_container').show();
						$('#main_container').html(data.form);
						vm.formPayments = true;
						return compile();
					}
					msg.warning(data, 'Advertencia!');
				} 
			});
		},


		payFromTable: function( e, cliente_id ) {
			vm.cliente_id = cliente_id;
            vm.getInfoCliente(cliente_id);
            $('#customer_search').val('');
            $('.montoAbono').val(0);
            vm.monto = 0;
            vm.tableDetail = '';
            vm.getFormAbonosVentas();
		},


		submitFormPayments: function(e) {
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
					vm.formPayments = false;
					return vm.proccesDataTable(data.table);
				}
				msg.warning('Hubo un error intentelo de nuevo', 'Advertencia!');
			});
		},


		devolutionsByCustomer: function() {
			$.get( "/user/cliente/devolutionsByCustomer", function( data ) {
				if (data.success == true)
				{
					vm.formPayments = false;
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
						vm.formPayments = false;
						return vm.proccesDataTable(data.table);
					}
					msg.warning('Hubo un error intentelo de nuevo', 'Advertencia!');
				}
			}); 
		},


		imprimirAbonoVenta: function(e, id, impresora) {
		    var url = "ImprimirAbonoCliente";
		    printDocument(impresora, url, id);
		},


		getHistorialAbonos: function() {
			$.ajax({
				type: 'GET',
				url: "user/cliente/getHistorialAbonos",
				data: { cliente_id: vm.cliente_id, sSearch: null },
				success: function (data) {
					if (data.success == true)
					{
						vm.formPayments = false;
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
			vm.showFilter = false;
			vm.formPayments = false;
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
						vm.cliente_id = 0;
						vm.infoCliente   = '';
						vm.saldo_total   = '';
						vm.saldo_vencido = '';
						vm.historialPagos = data.data;
						return vm.proccesDataTable(data.table);
					}
					msg.warning(data, 'Advertencia!');
				}
			}); 
		},


		getVentasPedientesPorUsuario: function() {
			$.ajax({
				type: 'GET',
				url: "user/ventas/getVentasPedientesPorUsuario",
				success: function (data) {
					if (data.success == true)
					{
						$("#infoSaldosTotales").html("");
						vm.historialPagos = data.data;
						return vm.proccesDataTable(data.table);
					}
					msg.warning(data, 'Advertencia!');
				}
			}); 
		},


		DetalleVentasPendientesPorUsuario: function(e, id) {
			vm.user_id_creditos = id;

			e = e.target;

			if ($(e).hasClass("hide_detail"))  {
				$(e).removeClass('hide_detail');
				$('.subtable').fadeOut('slow');
			} 
			else {
				$('.hide_detail').removeClass('hide_detail');
				if ( $( ".subtable" ).length ) {
					$('.subtable').fadeOut('slow', function(){
						vm.getDetalleVentasPendientesPorUsuario(e, 1 , null);
					})
				}
				else 
					vm.getDetalleVentasPendientesPorUsuario(e, 1 , null);
			}
		},

		getDetalleVentasPendientesPorUsuario: function(e , page, sSearch) {
			$('.subtable').remove();
			var nTr = $(e).parents('tr')[0];
			$(e).addClass('hide_detail');
			$(nTr).after("<tr class='subtable'> <td colspan=6><div class='grid_detalle_factura'></div></td></tr>");
			$('.subtable').addClass('hide_detail');

			$.ajax({
				type: "GET",
				url: "user/ventas/getDetalleVentasPendientesPorUsuario?page=" + page,
				data: {user_id: vm.user_id_creditos , sSearch:sSearch},
			}).done(function(data) {
				if (data.success == true) {
					vm.cliente_id = 0;
					vm.infoCliente   = '';
					vm.saldo_total   = '';
					vm.saldo_vencido = '';
					vm.historialPagos = data.data;
					vm.proccesDataTable(data.table);
					$(nTr).next('.subtable').fadeIn('slow');
					compile();
					return $(e).addClass('hide_detail');
				}
				msg.warning(data, 'Advertencia!');
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
					vm.cliente_id = 0;
					vm.infoCliente   = '';
					vm.saldo_total   = '';
					vm.saldo_vencido = '';
					vm.historialPagos = data.data;
					vm.proccesDataTable(data.table);
					$(nTr).next('.subtable').fadeIn('slow');
					compile();
					return $(e).addClass('hide_detail');
				}
				msg.warning(data, 'Advertencia!');
			});
		},


		getDetalleVentasPendientesPorUsuarioPaginacion: function(page , sSearch) {
			$.ajax({
				type: "GET",
				url: "user/ventas/getDetalleVentasPendientesPorUsuario?page=" + page,
				data: {user_id: vm.user_id_creditos , sSearch:sSearch},
			}).done(function(data) {
				if (data.success == true) {
					vm.cliente_id = 0;
					vm.infoCliente   = '';
					vm.saldo_total   = '';
					vm.saldo_vencido = '';
					vm.historialPagos = data.data;
					return vm.proccesDataTable(data.table);
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
				if (data.success == true) {
					vm.cliente_id = 0;
					vm.infoCliente   = '';
					vm.saldo_total   = '';
					vm.saldo_vencido = '';
					vm.historialPagos = data.data;
					return vm.proccesDataTable(data.table);
				}

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
				vm.showFilter = true;
				$('#iSearch').keyup(function() {
					$('#example').dataTable().fnFilter( $(this).val() );
				});
			}, 0);
		},

		goToCustomer: function(cliente_id) {
			vm.closeMainContainer();
			vm.cliente_id = cliente_id;
            vm.getInfoCliente(cliente_id);
            $('#customer_search').val('');
            $('.montoAbono').val(0);
            vm.monto = 0;
            vm.tableDetail = '';
		},

		exportarEstadoDeCuentaDeClientes:  function(tipo) {
			window.open('admin/exportar/exportarEstadoDeCuentaDeClientes/'+tipo ,'_blank');
		},

		exportarEstadoDeCuentaPorCliente: function(tipo, cliente_id) {
			window.open('admin/exportar/exportarEstadoDeCuentaPorCliente/'+tipo+'?cliente_id='+cliente_id ,'_blank');
		},

		exportarVentasPendientesDeUsuarios: function(tipo) {
			window.open('admin/exportar/exportarVentasPendientesDeUsuarios/'+tipo,'_blank');
		},

		exportarVentasPendientesPorUsuario: function(tipo, user_id) {
			window.open('admin/exportar/exportarVentasPendientesPorUsuario/'+tipo+'?user_id='+user_id ,'_blank');
		}
	}
});


function compile() {
	vm.$nextTick(function() {
		vm.$compile(vm.$el);
	});
}
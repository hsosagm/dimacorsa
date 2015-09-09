var vm = new Vue({

    el: 'body',

    data: {
    	ProviderFinder: '',
    	tableDetail: '',
    	proveedor_id: '',
    	divAbonosPorSeleccion: '',
    	infoProveedor: '',
    	saldo_total: '',
    	saldo_vencido: '',
    	saldoParcial: '',
    	monto: '',
    	proveedor_id_creditos: 0,
    },

    methods: {

    	resetSaldoParcial: function(e) {
    		this.saldoParcial = '';
    		this.monto = e.target.value;
    		$('.montoAbono').val(0);
    	},


    	clearPanelBody: function() {
    		this.tableDetail = '';
    		$('.table').html('');
    		$('#main_container').hide();
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
	                    vm.GetPurchasesForPaymentsBySelection(1, null);
	                    vm.updateMonto();
	                    return;
	                }
	                msg.warning(data, 'Advertencia!');
	            }
	        });
    	},


    	updateMonto: function() {
			vm.$nextTick(function() {
			    var selectedMonto = $("input[type='radio'][name='monto']:checked").val();
			    if (selectedMonto == 'on') {
			        vm.monto = $('#monto').val();
			        return;
			    };
			    vm.monto = selectedMonto;
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
		            	$('#main_container').hide();
		                $("#table_length").html("");
		                $('#main_container').html(data.form)
		            	$('#main_container').show();
		                vm.SST_search();
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
		                return vm.GetPurchasesForPaymentsBySelection(1,null);
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
		    $.ajax({
		        type: "GET",
		        url: "admin/compras/ConsultPurchase",
		        data: { proveedor_id: vm.proveedor_id },
		        success: function (data) {
		            vm.proccesDataTable(data);
		        }
		    });
        },
 

        getComprasPendientesDePago: function() {
		    $.ajax({
		        type: 'GET',
		        url: "admin/compras/ShowTableUnpaidShopping",
		        data: { proveedor_id: vm.proveedor_id },
		        success: function (data) {
		            if (data.success == true)
		            {
		                return vm.proccesDataTable(data.table);
		            }
		            msg.warning('Hubo un error intentelo de nuevo', 'Advertencia!');
		        }
		    }); 
        },


        getHistorialAbonos: function() {
	        $.ajax({
	            type: "GET",
	            url: "admin/compras/ShowTableHistoryPaymentDetails",
	            data: { proveedor_id: vm.proveedor_id },
	            success: function (data) {
	               	vm.proccesDataTable(data);
	            }
	        });
        },


        getHistorialPagos: function() {
	        $.ajax({
	            type: "GET",
	            url: "admin/compras/ShowTableHistoryPayment",
	            data: { proveedor_id: vm.proveedor_id },
	            success: function (data) {
	                vm.proccesDataTable(data);
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

		GetPurchasesForPaymentsBySelection: function(page , sSearch ) {
		    $.ajax({
		        type: 'GET',
		        url: "admin/compras/payments/formPaymentsPagination?page=" + page,
		        data: { proveedor_id: vm.proveedor_id, sSearch: sSearch },
		        success: function (data) {
		            if (data.success == true){
		               $('#tab4').html(data.table);
		               return compile();
		            }
		            
		            msg.warning(data, 'Advertencia!');
		        }
		    });
		},

		abonosComprasPorSeleccion: function(element){
		    var form = $("form[data-remote-abonosComprasPorSeleccion]");
		    var array_ids_compras = vm.GetPurchasesSelected();
		    $(element.target).prop("disabled", true);
		    
		    $.ajax({
		        type: "POST",
		        url:  "admin/compras/payments/abonosComprasPorSeleccion",
		        data: form.serialize()+'&array_ids_compras='+array_ids_compras,
		        success: function (data) {
		            if (data.success == true) 
		            {
		                vm.divAbonosPorSeleccion = data.detalle;
		                msg.success('Abonos Ingresados', 'Listo!');
		                vm.updateInfoProveedor();
		                return compile();
		            }
		            msg.warning(data, 'Advertencia!');
		            $(element).prop("disabled", false);
		        }
		    });

		},

		GetPurchasesSelected: function() {
		    var checkboxValues = new Array();
		    $('input[name="selectedPurshase[]"]:checked').each(function() {
		        checkboxValues.push($(this).val());
		    });

		    return checkboxValues;
		},
		
		SST_search: function() {
		    $("#iSearch").val("");
		    $("#iSearch").unbind();
		    $('#iSearch').keyup(function() {
		        vm.GetPurchasesForPaymentsBySelection( 1, $(this).val() );
		    });
		},

		proveedoresListado: function() {
		    $.get( "admin/proveedor/index", function( data ) {
		        vm.proccesDataTable(data);
		        $('#example').addClass('tableSelected');
		    });
		},

		getComprasPedientesDePago: function() {
		   $.ajax({
		        type: 'GET',
		        url: "admin/compras/getComprasPedientesDePago",
		        success: function (data) {
		            if (data.success == true) {
		                vm.proveedor_id = '';
		                vm.proccesDataTable(data.table);
		                $('#example').DataTable( {
		                    "order": [[ 3, "desc" ]]
		                } );
		                $("#iSearch").focus();
		                return compile();
		            }
		            msg.warning('Hubo un error intentelo de nuevo', 'Advertencia!');
		        }
		    }); 
		},

		ComprasPendientesPorProveedor: function(e, id) {
		    vm.proveedor_id_creditos = id;
		    if ($(e.target).hasClass("hide_detail"))  {
		        $(e.target).removeClass('hide_detail');
		        $('.subtable').fadeOut('slow');
		    } 
		    else {
		        $('.hide_detail').removeClass('hide_detail');

		        if ( $( ".subtable" ).length ) {
		            $('.subtable').fadeOut('slow', function(){
		                vm.getComprasPendientesPorProveedor(e.target, 1 , null);
		            })
		        }
		        else {
		            vm.getComprasPendientesPorProveedor(e.target, 1 , null);
		        }
		    }
		},

	 	getComprasPendientesPorProveedor: function(e , page , sSearch) {
		    $('.subtable').remove();
		    var nTr = $(e).parents('tr')[0];
		    $(e).addClass('hide_detail');
		    $(nTr).after("<tr class='subtable'> <td colspan=6><div class='grid_detalle_factura'></div></td></tr>");
		    $('.subtable').addClass('hide_detail');

		    $.ajax({
		        type: 'GET',
		        url: "admin/compras/getComprasPendientesPorProveedor?page=" + page,
		        data: { proveedor_id: vm.proveedor_id_creditos,  sSearch:sSearch},
		        success: function (data) {
		            if (data.success == true) {
		                vm.proccesDataTable(data.table);
		                $(nTr).next('.subtable').fadeIn('slow');
		                $(e).addClass('hide_detail');
		                return compile();
		            }
		            msg.warning(data, 'Advertencia!');
		        }
		    });
		},

 		getComprasPendientesPorProveedorPaginacion: function(page , sSearch) {
		    $.ajax({
		        type: 'GET',
		        url: "admin/compras/getComprasPendientesPorProveedor?page=" + page,
		        data: { proveedor_id:  vm.proveedor_id_creditos , sSearch:sSearch},
		        success: function (data) {
		            if (data.success == true) { 
		                vm.proccesDataTable(data.table);
		            	return compile();
		            }
		            msg.warning(data, 'Advertencia!');
		        }
		    });
		},

		getCompraConDetalle: function(e, compra_id) {
		    $.ajax({
		        type: 'GET',
		        url: "admin/compras/getCompraConDetalle",
		        data: {compra_id: compra_id },
		        success: function (data) {
		            if (data.success == true) {
		                $('.modal-body').html(data.table);
						$('.modal-title').text( 'Vista');
						return $('.bs-modal').modal('show');
				     }
		            msg.warning(data, 'Advertencia!');
		        }
		    });
		},

		proccesDataTable: function(data) {
			$('#main_container').hide();
			$('#main_container').html(data);
			$("#iSearch").unbind().val("").focus();

			compile();

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

		crearProveedor: function() {
			$.ajax({
				type: "POST",
				url: 'admin/proveedor/crearProveedor',
			}).done(function(data) {
				$('.modal-body').html(data);
				$('.modal-title').text( 'Crear Proveedor');
				return $('.bs-modal').modal('show');
			});
		},

		actualizarProveedor: function() {
			$.ajax({
				type: "POST",
				url: 'admin/proveedor/actualizarProveedor',
				data: {id: $('.dataTable tbody .row_selected').attr('id')},
			}).done(function(data) {
				$('.modal-body').html(data);
				$('.modal-title').text( 'Editar Proveedor');
				return $('.bs-modal').modal('show');
			});
		},

		eliminarProveedor: function() {
			$.confirm({
				confirm: function(){
					$.ajax({
						type: "POST",
						url: 'admin/proveedor/eliminarProveedor',
						data: {id: $('.dataTable tbody .row_selected').attr('id')},
					}).done(function(data) {
						if ($.trim(data) == 'success') {
							msg.success('Proveedor eliminado', 'Listo!')
							return $('.dataTable tbody .row_selected').hide();
						}
						msg.warning(data, 'Advertencia!');
					});
				}
			});
			$('.modal-title').text( 'Eliminar Proveedor');
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

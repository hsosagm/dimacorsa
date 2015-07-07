<table id="example" class="display" width="100%" cellspacing="0">
    
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Usuario</th>
            <th>Metodo pago</th>
            <th>Monto</th>
            <th>Observaciones</th>
            <th>Detalle</th>
        </tr>
    </thead>

	<tbody>
        <tr class="test" v-repeat="av: historialAbonos" id="@{{av.id}}">
            <td width="12%"> @{{ av.fecha }} </td>
            <td width="16%"> @{{ av.usuario }} </td>
            <td width="12%"> @{{ av.metodoPago }} </td>
            <td width="10%" class="right"> @{{ av.monto | currency }} </td>
            <td width="40%"> @{{ av.observaciones }} </td>
            <td class="widthS center font14"  width="10%"> 
                <a href="javascript:void(0);" title="Ver detalle" v-on="click: toggleActive(this, av)" v-class="hide_detail: av.active" class="fa fa-plus-square"> 
                <a href="javascript:void(0);" title="Imprimir abono" v-on="click: imprimirAbonoVenta(this, av)" class="fa fa-print font14"> 
            </td>
        </tr>
	</tbody>

</table>

<script type="text/javascript">

    var ab = new Vue({

        el: '#example',

        data: {
            historialAbonos: {{ $abonosVentas }},
        },

        methods: {
        	showDetail: function() {
        		console.log(1);
        	},

	        toggleActive: function(e, av) {
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
        }	
    });

    setTimeout(function() {
	    $("#table_length").html("");
	    $( ".DTTT" ).html("");
	    $('.dt-panel').show();

	    $('#example').dataTable();
	    $('#example_length').prependTo("#table_length");
	    $('.dt-container').show();
	    $("#iSearch").unbind().val("").focus();
	    $('#iSearch').keyup(function() {
	        $('#example').dataTable().fnFilter( $(this).val() );
	    });
    }, 0);
function test(e, av) {
	alert(av);

$(e).closest('tr').hide();

}
</script>

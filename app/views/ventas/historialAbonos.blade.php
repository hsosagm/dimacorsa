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
        <tr v-repeat="av: historialAbonos" id="@{{av.id}}">
            <td width="12%"> @{{ av.fecha }} </td>
            <td width="16%"> @{{ av.usuario }} </td>
            <td width="12%"> @{{ av.metodoPago }} </td>
            <td width="10%" class="right"> @{{ av.monto | currency }} </td>
            <td width="40%"> @{{ av.observaciones }} </td>
            <td class="widthS center font14"  width="10%"> 
                <a href="javascript:void(0);" title="Ver detalle" onclick="showSalesDetail(this)" class="fa fa-plus-square show_detail"> 
            </td>
        </tr>
	</tbody>

</table>

<script type="text/javascript">

    var ab = new Vue({
        el: '#example',
        data: {
            historialAbonos: {{ $abonosVentas }},
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

</script>

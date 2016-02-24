<div class="rounded shadow"> 
	<div class="panel_heading">
		<div id="table_length_cliente" class="pull-left"></div>
		<div class="DTTT btn-group"></div>
		<div class="pull-right">
			<i class="fa fa-file-excel-o fa-lg" v-on="click: exportarEstadoDeCuentaPorCliente('xlsx',{{Input::get('cliente_id')}})"></i>
			<i class="fa fa-file-pdf-o fa-lg" v-on="click: exportarEstadoDeCuentaPorCliente('pdf',{{Input::get('cliente_id')}})"></i>
			<i  v-on="click: getVentasPedientesDePago" class="fa fa-reply"></i>
			<i  v-on="click: closeMainContainer" class="fa fa-times"></i>
		</div>
		<div class="clearfix"></div>
	</div>
	<table class="dt-table table-striped table-theme" id="dataTableCliente">
	    <tbody style="background: #ffffff;">
	        <tr>
	            <td style="font-size: 14px; color:#1b7be2;" colspan="7" class="dataTables_empty">Cargando datos del servidor...</td>
	        </tr>
	    </tbody>
	</table>
</div>
 
<script type="text/javascript">
    $("#iSearch").val("");
    $("#iSearch").unbind();
    $('.bread-current').text("");

    setTimeout(function(){
        $("#iSearch").focus();
        $('#dataTableCliente_length').prependTo("#table_length_cliente");
        oTable = $('#dataTableCliente').dataTable();
        $('#iSearch').keyup(function(){
            oTable.fnFilter( $(this).val() );
        })
    }, 300);

    $(document).ready(function() {
        $('#dataTableCliente').dataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ archivos por pagina",
                "zeroRecords": "No se encontro ningun archivo",
                "info": "Mostrando la pagina _PAGE_ de _PAGES_",
                "infoEmpty": "No hay archivos disponibles",
                "infoFiltered": "- ( filtrado de _MAX_ archivos )"
            },
            "aoColumnDefs": [
	            {"sClass": "width30",                		"sTitle": "Fecha",         "aTargets": [0]},
	            {"sClass": "width30",                		"sTitle": "Usuario",       "aTargets": [1]},
	            {"sClass": "width15 right formato_precio",  "sTitle": "Total",         "aTargets": [2]},
	            {"sClass": "width15 right formato_precio",  "sTitle": "Saldo",         "aTargets": [3]},
	            {"sClass": " ", "bVisible": false,  		"sTitle": "",         	   "aTargets": [4]},
	            {"sClass": "width10 icons center",   		"sTitle": "",   		   "aTargets": [5],
	                "orderable": false,
	                "mRender": function(data, type, full ) {
	                  	return '<i title="Veta" onclick="vm.getVentaConDetalle(this, '+full.DT_RowId+')" class="fa fa-plus-square fg-theme"></i>';
	                }
            	}, 
	        ],
            "fnDrawCallback": function( oSettings ) {
                $("td[class*='formato_precio']").each(function() {
                    $(this).html(formato_precio($(this).html()));
                });
            },
            "bJQueryUI": false,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "user/ventas/getVentasPendientesPorCliente",
            "fnServerParams": function (aoData) {
                aoData.push({ "name": "cliente_id", "value": "{{Input::get('cliente_id')}}" });
                aoData.push({ "name": "dt", "value": "true" });
            },
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {                
	            if ( aData[4] > 30){
	                jQuery(nRow).addClass('red');
	            }               
        	},
        });
		$('#dataTableCliente').attr('width', '100%');
	});
</script>
 
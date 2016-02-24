<div class="rounded shadow"> 
	<div class="panel_heading">
		<div id="table_length_usuario" class="pull-left"></div>
		<div class="DTTT btn-group"></div>
		<div class="pull-right">
			<i class="fa fa-file-excel-o fa-lg" v-on="click: exportarVentasPendientesPorUsuario('xlsx',{{Input::get('user_id')}})"></i>
			<i class="fa fa-file-pdf-o fa-lg" v-on="click: exportarVentasPendientesPorUsuario('pdf',{{Input::get('user_id')}})"></i>
			<i class="fa fa-reply" v-on="click: getVentasPedientesPorUsuario" ></i>
			<i  v-on="click: closeMainContainer" class="fa fa-times"></i>
		</div>
		<div class="clearfix"></div>
	</div>
	<table class="dt-table table-striped table-theme" id="dataTableUsuario">
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
        $('#dataTableUsuario_length').prependTo("#table_length_usuario");
        oTable = $('#dataTableUsuario').dataTable();
        $('#iSearch').keyup(function(){
            oTable.fnFilter( $(this).val() );
        })
    }, 300);

    $(document).ready(function() {
        $('#dataTableUsuario').dataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ archivos por pagina",
                "zeroRecords": "No se encontro ningun archivo",
                "info": "Mostrando la pagina _PAGE_ de _PAGES_",
                "infoEmpty": "No hay archivos disponibles",
                "infoFiltered": "- ( filtrado de _MAX_ archivos )"
            },
            "aoColumnDefs": [
	            {"sClass": "width30",                		"sTitle": "Fecha",         "aTargets": [0]},
	            {"sClass": "width30",                		"sTitle": "Cliente",       "aTargets": [1]},
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
            "sAjaxSource": "user/ventas/getDetalleVentasPendientesPorUsuario",
            "fnServerParams": function (aoData) {
                aoData.push({ "name": "user_id", "value": "{{Input::get('user_id')}}" });
                aoData.push({ "name": "dt", "value": "true" });
            },
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {                
	            if ( aData[4] > 30){
	                jQuery(nRow).addClass('red');
	            }               
        	},
        });
		$('#dataTableUsuario').attr('width', '100%');
	});
</script>
 
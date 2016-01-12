<div class="rounded shadow"> 
	 <div class="panel_heading">
        <div id="table_length_proveedor" class="pull-left"></div>
        <div class="DTTT btn-group"> </div>
        <div class="pull-right">
        	<i  v-on="click: getComprasPedientesDePago" class="fa fa-reply"></i>
            <button v-on="click: closeMainContainer" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
        </div>
        <div class="clearfix"></div>
    </div>
	<table class="dt-table table-striped table-theme" id="dataTableProveedor">
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
        $('#dataTableProveedor_length').prependTo("#table_length_proveedor");
        oTable = $('#dataTableProveedor').dataTable();
        $('#iSearch').keyup(function(){
            oTable.fnFilter( $(this).val() );
        })
    }, 300);

    $(document).ready(function() {
        $('#dataTableProveedor').dataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ archivos por pagina",
                "zeroRecords": "No se encontro ningun archivo",
                "info": "Mostrando la pagina _PAGE_ de _PAGES_",
                "infoEmpty": "No hay archivos disponibles",
                "infoFiltered": "- ( filtrado de _MAX_ archivos )"
            },
            "aoColumnDefs": [
	            {"sClass": "width10",                		"sTitle": "Factura",         "aTargets": [0]},
	            {"sClass": "width25",                		"sTitle": "Fecha Ingreso",   "aTargets": [1]},
	            {"sClass": "width15",					    "sTitle": "Fecha Doc.",      "aTargets": [2]},
	            {"sClass": "width15",					    "sTitle": "Usuario",         "aTargets": [3]},
	            {"sClass": "width15 right formato_precio",  "sTitle": "Total",         	 "aTargets": [4]},
	            {"sClass": "width15 right formato_precio",  "sTitle": "Saldo",         	 "aTargets": [5]},
	            {"sClass": " ", "bVisible": false,  		"sTitle": "dias",      	   	 "aTargets": [6]},
	            {"sClass": "width5 icons center",   		"sTitle": "",   		   	 "aTargets": [7],
	                "orderable": false,
	                "mRender": function(data, type, full ) {
	                  	return '<i title="Veta" onclick="vm.getCompraConDetalle(this, '+full.DT_RowId+')" class="fa fa-plus-square fg-theme"></i>';
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
            "sAjaxSource": "admin/compras/getComprasPendientesPorProveedor",
            "fnServerParams": function (aoData) {
                aoData.push({ "name": "proveedor_id", "value": "{{Input::get('proveedor_id')}}" });
                aoData.push({ "name": "dt", "value": "true" });
            },
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {                
	            if ( aData[6] > 30){
	                jQuery(nRow).addClass('red');
	            }               
        	},
        });
		$('#dataTableProveedor').attr('width', '100%');
	});
</script>
 
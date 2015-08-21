<div class="row HeadQueriesContainer">
	<div class="col-md-12">
		@include('queries.formularioFechas')
	</div>
</div>

<table class="dt-table table-striped table-theme" id="example"></table>

<?php $impresora = "epson" ?>

<script type="text/javascript">

	$(document).ready(function() {

		$('#example').dataTable({

			"language": {
				"lengthMenu": "Mostrar _MENU_ archivos por pagina",
				"zeroRecords": "No se encontro ningun archivo",
				"info": "Mostrando la pagina _PAGE_ de _PAGES_",
				"infoEmpty": "No hay archivos disponibles",
				"infoFiltered": "- ( filtrado de _MAX_ archivos )"
			},

			"aoColumnDefs": [
				{"sClass": "widthS",                         "sTitle": "Fecha",                        "aTargets": [0]},
				{"sClass": "widthM",                         "sTitle": "Usuario",                      "aTargets": [1]},
				{"sClass": "widthL",                         "sTitle": "Cliente",                      "aTargets": [2]},
				{"sClass": "widthS right formato_precio",    "sTitle": "Total",                        "aTargets": [3]},
				{"sClass": "widthS right formato_precio",    "sTitle": "Saldo",                        "aTargets": [4]},
				{"sClass": "widthS",                         "sTitle": "Completed", "bVisible": false, "aTargets": [5]},
				{"sClass": "widthS center font14", "orderable": false, "aTargets": [6],


					"mRender": function( data, type, full ) {
						$v  = '<a href="javascript:void(0);" title="Ver detalle" onclick="showSalesDetail(this)" class="fa fa-plus-square show_detail font14">';
						$v += '<a href="javascript:void(0);" title="Abrir venta" onclick="openSale(this)" class="fa fa-pencil-square-o font14" style="padding-left:10px">';
						$v += '<a href="javascript:void(0);" onclick="printInvoice(this, '+full.DT_RowId+', '+"'"+'{{$factura->impresora}}'+"'"+')" class="fa fa-print font14" style="padding-left:10px">';
						$v += '<a href="javascript:void(0);" title="Imprimir Garantia" onclick="ImprimirGarantiaVenta_dt(this,{{Auth::user()->id}})" class="fa fa-file-o font14" style="padding-left:10px">';

						return $v;
					}
				}
			],

			"fnDrawCallback": function( oSettings ) {
				$( ".DTTT" ).html("");
				$("td[class*='formato_precio']").each(function() {
					$(this).html(formato_precio($(this).html()));
				});
			},
			"bJQueryUI": false,
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "admin/queries/DtVentasPorFecha/{{$consulta}}",
			"fnServerParams": function (aoData) {
				aoData.push({ "name": "fecha_inicial", "value": "{{$fecha_inicial}}" });
				aoData.push({ "name": "fecha_final",  "value": "{{$fecha_final}}" });
			},
			"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {                
				if ( aData[5] == 0){
					jQuery(nRow).addClass('red');
				}               
			},
		});
    });

	var position = $(this).index('input');
	$("input, select").eq(position+1).select();

	$('input[name="fecha_inicial"]').pickadate({ 
		max: true,
		selectYears: true,
		selectMonths: true
	});


	$('input[name="fecha_final"]').pickadate({ 
		max: true,
		selectYears: true,
		selectMonths: true
	});


	$('[data-action=collapse_head]').find('i').removeClass('fa-angle-down').addClass('fa-angle-up');

</script>

<script type="text/javascript">

    proccess_table('Cotizacion');

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
				{"sClass": "width10",                                       "sTitle": "No.",          "aTargets": [0]},
				{"sClass": "width20",                                       "sTitle": "Fecha",        "aTargets": [1]},
				{"sClass": "width25",                                       "sTitle": "Usuario",      "aTargets": [2]},
				{"sClass": "width25",                                       "sTitle": "Cliente",      "aTargets": [3]},
				{"sClass": "width10 right formato_precio",                  "sTitle": "Total",        "aTargets": [4]},
				{"sClass": "width10 center font14", "orderable": false,     "sTitle": "",             "aTargets": [5],
					"mRender": function( data, type, full ) {
						$v  = '<i title="Ver detalle" onclick="showDetalleCotizacion(this)" class="fa fa-plus-square"></i>';
                        $v += '<i title="Editar Cotizacion" onclick="EditarCotizacion(this, '+full.DT_RowId+')" class="fa fa-pencil fg-theme" style="padding-left:10px"></i>';
						$v += '<i title="Imprimir Cotizacion" onclick="ImprimirCotizacion(this, '+full.DT_RowId+','+"'pdf'"+')" class="fa fa-file-o fg-theme" style="padding-left:10px"></i>';
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
			"sAjaxSource": "user/cotizaciones/DtCotizaciones"
		});
    });
</script>

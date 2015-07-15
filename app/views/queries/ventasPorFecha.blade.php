<div class="row HeadQueriesContainer">
	<div class="col-md-12">
		<table class="master-table">
			<tr class="col-md-5">
				<td class="col-md-4">Fecha inicial:</td>
				<td class="col-md-6"><input type="text" name="fecha_inicial" data-value="now()"></td>
				<td class="col-md-2"></td>
			</tr>
			<tr class="col-md-5">
				<td class="col-md-4">Fecha final:</td>
				<td class="col-md-6"><input type="text" name="fecha_final" data-value="now()"></td>
				<td class="col-md-2"></td>
			</tr>
			<tr class="col-md-2">
			    <td><button class="btn btn-theme" type="submit"> Actualizar !</button></td>
			</tr>
		</table>
	</div>
</div>

<table class="dt-table table-striped table-theme" id="example"></table>

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
                {"sClass": "widthS",               "sTitle": "Usuario",                      "aTargets": [0]},
                {"sClass": "widthM",               "sTitle": "Fecha",                        "aTargets": [1]},
                {"sClass": "widthS right",         "sTitle": "Numero",                       "aTargets": [2]},
                {"sClass": "widthS right",         "sTitle": "Total",                        "aTargets": [3]},
                {"sClass": "widthS right",         "sTitle": "Saldo",                        "aTargets": [4]},
                {"sClass": "widthS center font14", "sTitle": "Acciones", "orderable": false, "aTargets": [5],
                    "mRender": function() {
                        return '<a href="javascript:void(0);" title="Ver detalle" onclick="showSalesDetail(this)" class="fa fa-plus-square show_detail">';
                    }
                }
            ],

            "fnDrawCallback": function( oSettings ) {
                $( ".DTTT" ).html("");
            },

            "bJQueryUI": false,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "admin/queries/DtVentasPorFecha",
            "fnServerParams": function (aoData) {
                aoData.push({ "name": "cliente_id", "value": 664 });
            }
        });

    });

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
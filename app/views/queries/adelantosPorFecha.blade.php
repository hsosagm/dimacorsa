<div class="row HeadQueriesContainer">
	<div class="col-md-12">
		@include('queries.formularioFechas')
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
            {"sClass": "mod_codigo hover width20",                      "sTitle": "Usuario",     "aTargets": [0]},
            {"sClass": "mod_codigo hover width20",                      "sTitle": "Fecha",       "aTargets": [1]},
            {"sClass": "mod_codigo hover width40",                      "sTitle": "Nota", 		 "aTargets": [2]},
            {"sClass": "mod_codigo hover right width5 ", 				"sTitle": "tipo",        "aTargets": [3]},
            {"sClass": "mod_codigo hover width5 formato_precio",        "sTitle": "Monto.",      "aTargets": [4]},
			{"sClass": "widthS", "bVisible": false,                     "sTitle": "estado",      "aTargets": [5]},
            {"sClass": "width5 icons center",                           "sTitle": "",            "aTargets": [6],
                "orderable": false,
                "mRender": function(data, type, full) {
                    return ' <i class="fa fa-trash-o btn-link theme-c" title="Eliminar" onclick="eliminarNotaCredito(this, '+full[5]+', '+full.DT_RowId+')"></i> ';
                }
            },
        ],
        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
            $("td[class*='formato_precio']").each(function() {
                $(this).html(formato_precio($(this).html()));
            });
        },
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
			if ( aData[5] == 0){
				jQuery(nRow).addClass('blue');
			}
		},
        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "admin/queries/DtAdelantosPorFecha/{{$consulta}}",
        "fnServerParams": function (aoData) {
           aoData.push({ "name": "fecha_inicial", "value": "{{$fecha_inicial}}" });
           aoData.push({ "name": "fecha_final",  "value": "{{$fecha_final}}" });
       },
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

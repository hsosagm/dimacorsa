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
                {"sClass": "mod_codigo hover width20",                      "sTitle": "Fecha",       "aTargets": [0]},
                {"sClass": "mod_codigo hover width30",                      "sTitle": "Usuario",     "aTargets": [1]},
                {"sClass": "mod_codigo hover width30",                      "sTitle": "Cliente",     "aTargets": [2]},
                {"sClass": "mod_codigo hover right width5 ", 				        "sTitle": "tipo",        "aTargets": [3]},
                {"sClass": "mod_codigo hover width5 formato_precio right",  "sTitle": "Monto.",      "aTargets": [4]},
    			{"sClass": "widthS", "bVisible": false,                     "sTitle": "estado",      "aTargets": [5]},
                {"sClass": "width5 icons center",                           "sTitle": "",            "aTargets": [6],
                    "orderable": false,
                    "mRender": function(data, type, full) {
                        return '<i class="fa fa-plus-square btn-link theme-c"  title="Ver detalle" onClick="verDetalleNotaDeCredito(this,'+full.DT_RowId+')"></i><i class="fa fa-trash-o icon-delete" style="margin-left:5px" title="Eliminar" onclick="eliminarNotaDeCredito(this,'+full.DT_RowId+')"></i>';
                    }
                },
            ],
            "order": [[ 0, "desc" ]],
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
            "sAjaxSource": "admin/queries/DtNotasDeCreditoPorFecha/{{$consulta}}",
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

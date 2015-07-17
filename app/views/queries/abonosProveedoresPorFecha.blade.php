<div class="row HeadQueriesContainer">
	<div class="col-md-12">
		<table class="master-table">
			<tr class="col-md-5">
				<td class="col-md-4">Fecha inicial:</td>
				<td class="col-md-6"><input type="text"  name="fecha_inicial" data-value="{{$fecha_inicial}}"></td>
				<td class="col-md-2"></td>
			</tr>
			<tr class="col-md-5">
				<td class="col-md-4">Fecha final:</td>
				<td class="col-md-6"><input type="text"  name="fecha_final" data-value="{{$fecha_final}}"></td>
				<td class="col-md-2"></td>
			</tr>
			<tr class="col-md-2">
             <td><button class="btn btn-theme" type="submit" > Actualizar !</button></td>
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
            {"sClass": "mod_codigo hover widthM",                       "sTitle": "Proveedor",    "aTargets": [0]},
            {"sClass": "mod_codigo hover widthM",                       "sTitle": "Usuario",      "aTargets": [1]},
            {"sClass": "mod_codigo hover widthS",                       "sTitle": "Fecha",        "aTargets": [2]},
            {"sClass": "mod_codigo hover  widthS",                      "sTitle": "M.P.",         "aTargets": [3]},
            {"sClass": "mod_codigo hover right widthS formato_precio",  "sTitle": "Monto",        "aTargets": [4]},
            {"sClass": "mod_codigo hover  widthL",                      "sTitle": "Observaciones","aTargets": [5]},
            {"sClass": "widthS icons center",                           "sTitle": "",             "aTargets": [6],
                "orderable": false,
                "mRender": function() {
                    $v  = '<i class="fa fa-plus-square btn-link theme-c" onClick="showPaymentsDetail(this)"></i>';
                    $v += '<a href="javascript:void(0);" title="Imprimir Abono" onclick="ImprimirAbonoProveedor_dt(this,{{Auth::user()->id}})" class="fa fa-print font14" style="padding-left:10px"> </a>'
                    $v += '<i class="fa fa-trash-o btn-link theme-c" style="padding-left:5px" onClick="_delete_dt(this)"></i>';

                    return $v;
                }
            },
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
        "sAjaxSource": "admin/queries/DtAbonosProveedoresPorFecha/{{$consulta}}",
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

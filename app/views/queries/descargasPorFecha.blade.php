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
                {"sClass": "widthS",                          "sTitle": "ID",           "aTargets": [0]},
                {"sClass": "widthM",                          "sTitle": "Fecha",        "aTargets": [1]},
                {"sClass": "widthL",                          "sTitle": "Usuario",      "aTargets": [2]},
                {"sClass": "widthS right formato_precio",     "sTitle": "Total",        "aTargets": [3]},
                {"sClass": "widthS",        "bVisible": false,"sTitle": "status",       "aTargets": [4]},
                {"sClass": "widthS center","orderable": false,"sTitle": "",             "aTargets": [5],
                    "mRender": function(data, type, full ) {
                        $v  = '<a href="javascript:void(0);" title="Ver detalle" onclick="showDownloadsDetail(this)" class="fa fa-plus-square show_detail font14">';
                        $v += '<a href="javascript:void(0);" title="Abrir Descarga" onclick="OpenDownload(this)" class="fa fa-pencil-square-o font14" style="padding-left:10px">';
                        $v += '<a href="javascript:void(0);" title="Imprimir Descarga" onclick="ImprimirDescarga(this, '+full.DT_RowId+', '+"'"+'{{@$comprobante->impresora}}'+"'"+')" class="fa fa-print font14" style="padding-left:10px">';
                        return $v;
                    }
                }
            ],
            "order": [[ 1, "desc" ]],
            "fnDrawCallback": function( oSettings ) {
                $( ".DTTT" ).html("");
                $("td[class*='formato_precio']").each(function() {
                    $(this).html(formato_precio($(this).html()));
                });
            },
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {                
              if ( aData[4] == 0){
                jQuery(nRow).addClass('red');
              }               
            },
            "bJQueryUI": false,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "admin/queries/DtDescargasPorFecha/{{$consulta}}",
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

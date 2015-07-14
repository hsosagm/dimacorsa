
<script>
$(document).ready(function() {

    proccess_table('Inventario');

    $('#example').dataTable({

        "language": {
            "lengthMenu": "Mostrar _MENU_ archivos por pagina",
            "zeroRecords": "No se encontro ningun archivo",
            "info": "Mostrando la pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay archivos disponibles",
            "infoFiltered": "- ( filtrado de _MAX_ archivos )"
        },
        
        "aoColumnDefs": [
            {"sClass": "widthS",                      "sTitle": "ID",                           "aTargets": [0]},
            {"sClass": "widthM",                      "sTitle": "Fecha",                        "aTargets": [1]},
            {"sClass": "widthL",                      "sTitle": "Usuario",                      "aTargets": [2]},
            {"sClass": "widthS right formato_precio", "sTitle": "Total",                        "aTargets": [3]},
            {"sClass": "widthS center", "sTitle": "", "orderable": false,"aTargets": [4],
                "mRender": function() {
                    return '<a href="javascript:void(0);" title="Ver detalle" onclick="showDownloadsDetail(this)" class="fa fa-plus-square show_detail font14"><a href="javascript:void(0);" title="Abrir Descarga" onclick="OpenDownload(this)" class="fa fa-pencil-square-o font14" style="padding-left:10px"><a href="javascript:void(0);" title="Imprimir Descarga" onclick="ImprimirDescarga_dt(this,{{Auth::user()->id}})" class="fa fa-print font14" style="padding-left:10px">';
                }
            }
        ],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
            $("td[class*='formato_precio']").each(function() {
                $(this).html(formato_precio($(this).html()));
            });
        },

        "fnRowCallback": function( nRow, aData ) {                
                        
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "admin/descargas/DownloadsDay_dt"
    });

});

</script>
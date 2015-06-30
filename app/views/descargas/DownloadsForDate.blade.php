
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
            {"sClass": "widthS",       "sTitle": "ID",                           "aTargets": [0]},
            {"sClass": "widthM",       "sTitle": "Tienda",                       "aTargets": [1]},
            {"sClass": "widthM",       "sTitle": "Fecha",                        "aTargets": [2]},
            {"sClass": "widthL",       "sTitle": "Usuario",                      "aTargets": [3]},
            {"sClass": "widthS right", "sTitle": "Total",                        "aTargets": [4]},
            {"sClass": "widthS center", "sTitle": "Acciones", "orderable": false,"aTargets": [5],
                "mRender": function() {
                    return '<a href="javascript:void(0);" title="Ver detalle" onclick="showDownloadsDetail(this)" class="fa fa-plus-square show_detail font14"><a href="javascript:void(0);" title="Abrir Descarga" onclick="OpenDownload(this)" class="fa fa-pencil-square-o font14" style="padding-left:10px"><a href="javascript:void(0);" title="Imprimir Descarga" onclick="ImprimirDescarga_dt(this,{{Auth::user()->id}})" class="fa fa-print font14" style="padding-left:10px">';
                }
            }
        ],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
            $( ".DTTT" ).append( '<button consulta="dia"    onclick="OpenTableDownloadsForDate(this)">Dia</button>'    );
            $( ".DTTT" ).append( '<button consulta="semana" onclick="OpenTableDownloadsForDate(this)">Semana</button>' );
            $( ".DTTT" ).append( '<button consulta="mes"    onclick="OpenTableDownloadsForDate(this)">Mes</button>'    );
        },

        "fnRowCallback": function( nRow, aData ) {                
                        
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "admin/descargas/DownloadsForDate?fecha={{Input::get('fecha')}}&consulta={{Input::get('consulta')}}"
    });

});

</script>
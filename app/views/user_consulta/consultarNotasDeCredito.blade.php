
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
            {"sClass": "width15",                                        "sTitle": "Fecha",   "aTargets": [0]},
            {"sClass": "width15",                                        "sTitle": "Vendedor","aTargets": [1]},
            {"sClass": "width25",                                        "sTitle": "Cliente", "aTargets": [2]},
            {"sClass": "width5 ",                                       "sTitle": "Tipo",    "aTargets": [3]},
            {"sClass": "width40 ",                                       "sTitle": "Nota",    "aTargets": [4]},
            {"sClass": "width5 right formato_precio",                   "sTitle": "Monto",   "aTargets": [5]},
            {"bVisible": false,                                                               "aTargets": [6]},
            {"sClass": "width5 icons center", "orderable": false,        "sTitle": "",        "aTargets": [7],
                "mRender": function(  data, type, full ) {
                    $v  = '<a href="javascript:void(0);" title="Ver detalle" onclick="" class="fa fa-plus-square show_detail font14">';
                ')" class="fa fa-file-o font14" style="padding-left:10px">';

                    return $v;
                }
            }
        ],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
            $( ".DTTT" ).append('<button id="_create" class="btn btngrey " >Crear</button>');
            
            $("td[class*='formato_precio']").each(function() {
                $(this).html(formato_precio($(this).html()));
            });
        },

        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {                
            if ( aData[6] == 0){
                jQuery(nRow).addClass('blue');
            }               
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "user/consulta/DtConsultarNotasDeCredito"
    });

});

</script>
<script>

    $(document).ready(function() {

        proccess_table('Devoluciones');

        $('#example').dataTable({

            "language": {
                "lengthMenu": "Mostrar _MENU_ archivos por pagina",
                "zeroRecords": "No se encontro ningun archivo",
                "info": "Mostrando la pagina _PAGE_ de _PAGES_",
                "infoEmpty": "No hay archivos disponibles",
                "infoFiltered": "- ( filtrado de _MAX_ archivos )"
            },

            "aoColumnDefs": [
                {"sClass": "widthM",                                  "sTitle": "Fecha",   "aTargets": [0]},
                {"sClass": "widthM",                                  "sTitle": "Usuario", "aTargets": [1]},
                {"sClass": "widthM",                                  "sTitle": "Cliente", "aTargets": [2]},
                {"sClass": "widthS right formato_precio",             "sTitle": "Total",   "aTargets": [3]},
                {"sClass": "width5 icons center", "orderable": false, "sTitle": "",         "aTargets": [4],
                    "mRender": function(  data, type, full ) {
                        $v  = '<a href="javascript:void(0);" title="Ver detalle" onclick="getDevolucionesDetail(this)" class="fa fa-plus-square show_detail font14">';
                        $v += '<a href="javascript:void(0);" title="Abrir devolucion" onclick="openDevolucion('+full.DT_RowId+')" class="fa fa-pencil-square-o font14" style="padding-left:10px">';
                        $v += '<a href="javascript:void(0);" title="Imprimir Constancia" onclick="printDevolucion('+full.DT_RowId+')" class="fa fa-print font14" style="padding-left:10px">';
                        $v += '<a href="javascript:void(0);" title="Eliminar devolucion" onclick="deleteDevolucion(this, '+full.DT_RowId+')" class="fa fa-trash-o icon-delete" style="padding-left:10px">';
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

            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                if ( aData[2] == 0){
                    jQuery(nRow).addClass('red');
                }
            },

            "fnServerParams": function (aoData) {
                aoData.push({ "name": "where", "value": "{{$where}}" });
            },

            "bJQueryUI": false,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "user/ventas/devoluciones/devoluciones_DT",
        });

    });

</script>

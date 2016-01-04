<script type="text/javascript">

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
                {"sClass": "widthM",                                  "sTitle": "Dif. Inversion", "aTargets": [1]},
                {"sClass": "widthM",                                  "sTitle": "Dif. Cuentas por pagar", "aTargets": [2]},
                {"sClass": "widthS right formato_precio",             "sTitle": "Dif. cuentas por cobrar",   "aTargets": [3]},
                {"sClass": "width5 icons center", "orderable": false, "sTitle": "Operaciones",         "aTargets": [4],
                    "mRender": function( data, type, full ) {
                        $v = '<a href="javascript:void(0);" title="Ver detalle inversion" onclick="getInformeDetail(this, '+"'"+'getInformeInversion'+"'"+')" class="fa fa-plus-square show_detail font14">';

                        $v += '<a href="javascript:void(0);" title="Ver detalle inversion" onclick="getInformeDetail(this, '+"'"+'getInformeCuentasPorPagar'+"'"+')" class="fa fa-plus-square show_detail font14" style="padding-left:10px">';

                        $v += '<a href="javascript:void(0);" title="Ver detalle inversion" onclick="getInformeDetail(this, '+"'"+'getInformeCuentasPorCobrar'+"'"+')" class="fa fa-plus-square show_detail font14" style="padding-left:10px">';

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
            "sAjaxSource": "admin/informeGeneral/tableInformeGeneral_DT",
        });

    });

</script>

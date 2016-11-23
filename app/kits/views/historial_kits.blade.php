<script type="text/javascript">
    $(document).ready(function() {
        proccess_table('Traslados');
        $('#example').dataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ archivos por pagina",
                "zeroRecords": "No se encontro ningun archivo",
                "info": "Mostrando la pagina _PAGE_ de _PAGES_",
                "infoEmpty": "No hay archivos disponibles",
                "infoFiltered": "- ( filtrado de _MAX_ archivos )"
            },
            "aoColumnDefs": [
                {"sClass": "widthS",                      "sTitle": "Fecha",         "aTargets": [0]},
                {"sClass": "widthM",                      "sTitle": "Usuario",       "aTargets": [1]},
                {"sClass": "widthL",                      "sTitle": "Producto",      "aTargets": [2]},
                {"sClass": "widthS right formato_precio", "sTitle": "Cantidad",      "aTargets": [3]},
                {"sClass": "widthS right formato_precio", "sTitle": "Precio",        "aTargets": [4]},
                {"sClass": "widthS",                      "sTitle": "Observaciones", "aTargets": [5]},
                {"bVisible": false,                                                  "aTargets": [6]},
                {"sClass": "widthS", "orderable": false,  "sTitle": "Operaciones",   "aTargets": [7],
                    "mRender": function( data, type, full ) {
                        $v  = '<i title="Ver detalle" onclick="verKitDetalle(this, '+full.DT_RowId+')" class="fa fa-plus-square show_detail fg-theme"></i>';
                        $v += '<i title="Abrir combo" onclick="open_kit_no_finalizado('+full.DT_RowId+')" class="fa fa-pencil-square-o fg-theme" style="padding-left:10px"></i>';
                        return $v;
                    }
                }
            ],
            "order": [ 0, "desc" ],

            "fnDrawCallback": function( oSettings ) {
                $( ".DTTT" ).html("");
                $("td[class*='formato_precio']").each(function() {
                    $(this).html(formato_precio($(this).html()));
                });
            },

            "fnRowCallback": function(nRow, aData) {
                if ( aData[6] == 0) {
                    jQuery(nRow).addClass('red');
                }
            },

            "bServerSide": true,
            "sAjaxSource": "admin/kits/historial_kits_DT",
        });
    });
</script>

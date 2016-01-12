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
                {"sClass": "mod_codigo hover width10",                       "sTitle": "Fecha",      "aTargets": [0]},
                {"sClass": "mod_codigo hover width15",                       "sTitle": "Usuario",    "aTargets": [1]},
                {"sClass": "mod_codigo hover width30",                       "sTitle": "Tienda",     "aTargets": [2]},
                {"sClass": "mod_codigo hover width25",                       "sTitle": "Nota",       "aTargets": [3]},
                {"sClass": "mod_codigo hover width10 right formato_precio",  "sTitle": "Total",      "aTargets": [4]},
                {"bVisible": false,                                                                  "aTargets": [5]},
                {"sClass": "width10 icons center",                           "sTitle": "",           "aTargets": [6],
                    "orderable": false,
                    "mRender": function( data, type, full) {
                        $v  = '<i class="fa fa-plus-square btn-link theme-c" onClick="verDetalleTraslado(this, 2)"></i>';
                        $v += '<a href="javascript:void(0);" title="Recibir traslado" onclick="abrirTrasladoDeRecibido(this)" class="fa fa-pencil-square-o font14" style="padding-left:10px">';
                        $v += '<a href="javascript:void(0);" title="Imprimir Traslado" onclick="ImprimirTraslado(this, '+full.DT_RowId+', '+"'"+'{{@$comprobante->impresora}}'+"'"+')" class="fa fa-print font14" style="padding-left:5px">';
                        return $v;
                    }
                },
            ],
            "order": [[ 5, "asc" ],[ 0, "desc" ]],
            "fnDrawCallback": function( oSettings ) {
                $( ".DTTT" ).html("");
                $("td[class*='formato_precio']").each(function() {
                    $(this).html(formato_precio($(this).html()));
                });
            },
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {                
                if ( aData[5] == 0){
                    jQuery(nRow).addClass('red');
                }               
            },
            "bJQueryUI": false,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "admin/traslados/getTrasladosRecibidos_dt",
            "fnServerParams": function (aoData) {
                aoData.push({ "name": "fecha_inicial", "value": "" });
                aoData.push({ "name": "fecha_final",  "value": "" });
            },
        });
    });
</script>
 
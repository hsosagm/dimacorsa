<script>
    $(document).ready(function() {
        proccess_table('Adelantos');
        $('#example').dataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ archivos por pagina",
                "zeroRecords": "No se encontro ningun archivo",
                "info": "Mostrando la pagina _PAGE_ de _PAGES_",
                "infoEmpty": "No hay archivos disponibles",
                "infoFiltered": "- ( filtrado de _MAX_ archivos )"
            },
            "aoColumnDefs": [
                {"sClass": "width15",                      "sTitle": "Fecha",   		"aTargets": [0]},
                {"sClass": "width15",                      "sTitle": "Usuario", 		"aTargets": [1]},
                {"sClass": "width15",                      "sTitle": "Cliente", 		"aTargets": [2]},
                {"sClass": "width30",                      "sTitle": "Descripcion", 	"aTargets": [3]},
                {"sClass": "width10 right formato_precio", "sTitle": "Total",   		"aTargets": [4]},
                {"sClass": "width5 icons center",  		   "sTitle": "",     			"aTargets": [5],  "orderable": false, 
                    "mRender": function(  data, type, full ) {
                        return '<i title="Ver detalle" onclick="getAdelantosDetail(this,'+full.DT_RowId+')" class="fa fa-plus-square show_detail font14"></i> <i title="Ver detalle" onclick="imprimirComprobanteAdelanto(this,'+full.DT_RowId+')" style="margin-left:5px" class="fa fa-print show_detail font14"></i>';
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
            "bJQueryUI": false,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "user/adelantos/DTadelantos",
        });
    });
</script>
 
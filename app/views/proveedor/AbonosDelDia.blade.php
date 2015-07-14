
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
            {"sClass": "mod_codigo hover widthM",              "sTitle": "Proveedor",   "aTargets": [0]},
            {"sClass": "mod_codigo hover widthM",              "sTitle": "Usuario",     "aTargets": [1]},
            {"sClass": "mod_codigo hover widthS",              "sTitle": "Fecha",       "aTargets": [2]},
            {"sClass": "mod_codigo hover  widthS",             "sTitle": "M.P.",        "aTargets": [3]},
            {"sClass": "mod_codigo hover right widthS",         "sTitle": "Monto",       "aTargets": [4]},
            {"sClass": "mod_codigo hover  widthL",             "sTitle": "Observaciones","aTargets": [5]},
            {"sClass": "widthS icons center",   "sTitle": "",   "aTargets": [6],
                "orderable": false,
                "mRender": function() {
                    return '<i class="fa fa-plus-square btn-link theme-c" onClick="showPaymentsDetail(this)"></i><a href="javascript:void(0);" title="Imprimir Abono" onclick="ImprimirAbonoProveedor_dt(this,{{Auth::user()->id}})" class="fa fa-print font14" style="padding-left:10px"> </a><i class="fa fa-trash-o btn-link theme-c" onClick="_delete_dt(this)"></i>';
                }
            },
        ],
        "order": [[ 3, "desc" ]],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "admin/proveedor/AbonosDelDia_dt"
    });

});
</script>

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
            {"sClass": "mod_codigo hover widthM",              "sTitle": "Codigo",       "aTargets": [0]},
            {"sClass": "mod_codigo hover widthM",              "sTitle": "Marca",        "aTargets": [1]},
            {"sClass": "mod_codigo hover widthL",              "sTitle": "Descripcion",  "aTargets": [2]},
            {"sClass": "mod_codigo hover align_left  widthS",  "sTitle": "P publico",   "aTargets": [3]},
            {"sClass": "mod_codigo hover align_right widthS",  "sTitle": "Existencia",    "aTargets": [4]},

        ],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
             $( ".DTTT" ).append( '<button id="_view_existencias" class="btn btngrey">Existencias</button>' );
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "user/datatables/user_datatables"
    });

});
</script> 
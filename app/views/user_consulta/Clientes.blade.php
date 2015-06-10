<script>

$(document).ready(function()
{
    proccess_table('Proveedores');

    $('#example').dataTable({
        "aoColumnDefs": [
            {"sClass": "widthS",              "sTitle": "Nombre",       "aTargets": [0]},
            {"sClass": "widthM",              "sTitle": "Direccion",    "aTargets": [1]},
            {"sClass": "widthS",             "sTitle": "Telefono",     "aTargets": [2]},
            {"sClass": "widthS",              "sTitle": "nit",          "aTargets": [3]},
        ],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
            $( ".DTTT" ).append( '<button id="_create" class="btn btngrey">New</button>' );
            $( ".DTTT" ).append( '<button id="_edit" class="btn btngrey btn_edit" disabled>Edit</button>' );
            $( ".DTTT" ).append( '<button id="_delete" class="btn btngrey btn_edit" disabled>Delete</button>' );
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "user/consulta/clientes_dt"
    });

});

</script>
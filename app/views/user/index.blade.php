<script>

$(document).ready(function()
{
    proccess_table('Usuarios');

    $('#example').dataTable({
        "aoColumnDefs": [
            {"sClass": "widthM",              "sTitle": "Username",       "aTargets": [0]},
            {"sClass": "widthM",              "sTitle": "Nombre",        "aTargets": [1]},
            {"sClass": "widthL",              "sTitle": "Apellido",  "aTargets": [2]},
            {"sClass": "align_right widthS",  "sTitle": "Email",      "aTargets": [3]},
            {"sClass": "align_right widthS",  "sTitle": "Tienda",    "aTargets": [4]},
            {"sClass": "center widthS",       "sTitle": "Estado",       "aTargets": [5]},
        ],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
            $( ".DTTT" ).append( '<button id="_create" class="btn btngrey">New</button>' );
            $( ".DTTT" ).append( '<button id="_edit_profile" class="btn btngrey btn_edit" disabled>Edit</button>' );
            $( ".DTTT" ).append( '<button id="_delete" class="btn btngrey btn_edit" disabled>Delete</button>' );
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "user/datatables/users"
    });

});

</script>
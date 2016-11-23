<script>

$(document).ready(function()
{
    proccess_table('Usuarios');

    $('#example').dataTable({
        "language": {
            "lengthMenu": "Mostrar _MENU_ archivos por pagina",
            "zeroRecords": "No se encontro ningun archivo",
            "info": "Mostrando la pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay archivos disponibles",
            "infoFiltered": "- ( filtrado de _MAX_ archivos )"
        },

        "aoColumnDefs": [
            {"sClass": "width15",              "sTitle": "Username",     "aTargets": [0]},
            {"sClass": "width30",              "sTitle": "Nombre",       "aTargets": [1]},
            {"sClass": "width30",              "sTitle": "Tienda",       "aTargets": [2]},
            {"sClass": "align_right width20",  "sTitle": "Email",        "aTargets": [3]},
            {"sClass": "center width5",        "sTitle": "Estado",       "aTargets": [4]},
        ],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
            $( ".DTTT" ).append( '<button id="_create" class="btn btngrey">Crear</button>' );
            $( ".DTTT" ).append( '<button id="_edit_profile" class="btn btngrey btn_edit" disabled>Editar</button>' );
            $( ".DTTT" ).append( '<button id="_delete" class="btn btngrey btn_edit" disabled>Eliminar</button>' );
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "owner/user/users"
    });

});

</script>
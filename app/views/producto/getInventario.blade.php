@if( Auth::user()->hasRole('Owner', 'Admin') )
    <?php $access = 1;  ?>
    <script>
        $(document).ready(function() {
            function show_pc() {
                var column = $('#example').DataTable().column(3);
                column.visible( !column.visible() );
            }
        });
    </script>
@else
    <?php $access = 0;  ?>
@endif

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
            {"sClass": "mod_codigo hover widthXL",              "sTitle": "Descripcion",  "aTargets": [2]},
            {"sClass": "mod_codigo hover right widthS", "sTitle": "P costo", "bVisible": false, "aTargets": [3]},
            {"sClass": "mod_codigo hover right widthS",  "sTitle": "P publico",    "aTargets": [4]},
            {"sClass": "mod_codigo hover right widthS",  "sTitle": "Existencias",    "aTargets": [5]},
        ],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
            if ( {{$access}} == true) {
                $( ".DTTT" ).append( '<button onclick="show_pc()" class="btn btngrey btn_edit">PC</button>');
            }
            $( ".DTTT" ).append( '<button id="_edit_dt" class="btn btngrey btn_edit" disabled>Editar</button>');
            $( ".DTTT" ).append( '<button id="_print"  class="btn btngrey btn_edit" disabled><i class="fa fa-barcode"></i> Imprimir</button>' );
            $( ".DTTT" ).append( '<button id="_view_existencias"  class="btn btngrey btn_edit" disabled><i class=""></i> Existencias</button>' );
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "user/productos"
    });

});

</script>
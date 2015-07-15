
<script>
$(document).ready(function() {

    proccess_table('Ingresos del dia');

    $('#example').dataTable({

        "language": {
            "lengthMenu": "Mostrar _MENU_ archivos por pagina",
            "zeroRecords": "No se encontro ningun archivo",
            "info": "Mostrando la pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay archivos disponibles",
            "infoFiltered": "- ( filtrado de _MAX_ archivos )"
        },
        
        "aoColumnDefs": [
            {"sClass": "mod_codigo hover widthM",                       "sTitle": "Usuario",     "aTargets": [0]},
            {"sClass": "mod_codigo hover widthM",                       "sTitle": "Fecha",       "aTargets": [1]},
            {"sClass": "mod_codigo hover widthL",                       "sTitle": "Descripcion", "aTargets": [2]},
            {"sClass": "mod_codigo hover right widthS formato_precio",  "sTitle": "Monto",       "aTargets": [3]},
            {"sClass": "mod_codigo hover widthS",                       "sTitle": "M.P.",        "aTargets": [4]},
            {"sClass": "widthS icons",   "sTitle": "",   "aTargets": [5],
                "orderable": false,
                "mRender": function() {
                    return ' <i class="fa fa-trash-o btn-link theme-c" title="Eliminar" onclick="_delete_dt(this)"></i> ';
                }
            },
        ],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
            $( ".DTTT" ).append( '<button consulta="dia"    onclick="IngresosPorFecha(this)">Dia</button>'    );
            $( ".DTTT" ).append( '<button consulta="semana" onclick="IngresosPorFecha(this)">Semana</button>' );
            $( ".DTTT" ).append( '<button consulta="mes"    onclick="IngresosPorFecha(this)">Mes</button>'    );
            $("td[class*='formato_precio']").each(function() {
                $(this).html(formato_precio($(this).html()));
            });
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "user/ingresos/IngresosPorFecha_dt?fecha={{Input::get('fecha')}}&consulta={{Input::get('consulta')}}"
    });

});
</script>

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
            {"sClass": "mod_codigo hover widthS",              "sTitle": "Tienda",      "aTargets": [0]},
            {"sClass": "mod_codigo hover widthM",              "sTitle": "Cliente",     "aTargets": [1]},
            {"sClass": "mod_codigo hover widthM",              "sTitle": "Usuario",     "aTargets": [2]},
            {"sClass": "mod_codigo hover widthS",              "sTitle": "Fecha",       "aTargets": [3]},
            {"sClass": "mod_codigo hover  widthM",             "sTitle": "Metodo Pago", "aTargets": [4]},
            {"sClass": "mod_codigo hover right widthS",        "sTitle": "Monto",       "aTargets": [5]},
            {"sClass": "mod_codigo hover  widthL",             "sTitle": "Observaciones","aTargets": [6]},
            {"sClass": "widthS icons",   "sTitle": "Acciones",   "aTargets": [7],
                "orderable": false,
                "mRender": function() {
                    return '<i class="fa fa-plus-square btn-link theme-c" onClick="verDetalleAbonosClietes(this)"></i> <a href="javascript:void(0);" title="Imprimir Abono" onclick="ImprimirAbonoCliente(this,{{Auth::user()->id}})" class="fa fa-print font14" style="padding-left:10px"> ';
                }
            },
        ],

        "fnDrawCallback": function( oSettings ) {
              $( ".DTTT" ).html("");
            $( ".DTTT" ).append( '<button consulta="dia"    onclick="AbonosPorFechaClientes(this)">Dia</button>'    );
            $( ".DTTT" ).append( '<button consulta="semana" onclick="AbonosPorFechaClientes(this)">Semana</button>' );
            $( ".DTTT" ).append( '<button consulta="mes"    onclick="AbonosPorFechaClientes(this)">Mes</button>'    );
        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "user/cliente/AbonosPorFecha_dt?fecha={{Input::get('fecha')}}&consulta={{Input::get('consulta')}}"
    });

});
</script>
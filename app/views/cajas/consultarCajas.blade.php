<script>
$(document).ready(function() {
    $("#iSearch").val("");
    $("#iSearch").unbind();
    $("#table_length").html("");

    setTimeout(function() {
        graph_container.x = 3;
        $('#iSearch').keyup(function(){
            $('#example').dataTable().fnFilter( $(this).val() );
        })
    }, 300);

    $('#example').dataTable({

        "language": {
            "lengthMenu": "Mostrar _MENU_ archivos por pagina",
            "zeroRecords": "No se encontro ningun archivo",
            "info": "Mostrando la pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay archivos disponibles",
            "infoFiltered": "- ( filtrado de _MAX_ archivos )"
        },

        "aoColumnDefs": [
            {"sClass": "width15",                                        "sTitle": "Tienda",            "aTargets": [0]},
            {"sClass": "width25",                                        "sTitle": "Caja",              "aTargets": [1]},
            {"sClass": "width35",                                        "sTitle": "Usuario",           "aTargets": [2]},
            {"sClass": "width25",                                        "sTitle": "Fecha Asignacion",  "aTargets": [3]},
        ],

        "fnDrawCallback": function( oSettings ) {
            $( ".DTTT" ).html("");
            $( ".DTTT" ).append('<button id="_create" class="btn btngrey " >Crear</button>');
            $( ".DTTT" ).append('<button class="btn btngrey" disabled>Asignar</button>');

            $("td[class*='formato_precio']").each(function() {
                $(this).html(formato_precio($(this).html()));
            });
        },

        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {

        },

        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "admin/cajas/DtConsultarCajas"
    });

});
</script>

<script>
	var graph_container = new Vue({

	    el: '#graph_container',

	    data: {
	        x: 1,
            caja_model: "",
            caja_metodo_pago_id: "",
            caja_id: {{$datos['caja_id']}},
            fecha_inicial: "{{$datos['fecha_inicial']}}",
            fecha_final: "{{$datos['fecha_final']}}",
	    },

	    methods: {

	        reset: function() {
	            graph_container.x = graph_container.x - 1;
	        },

	        close: function() {
	            $('#graph_container').hide();
	        },

	    	getAsignarInfoEnviar: function($v_model ,$v_metodo) {
	            graph_container.caja_model= $v_model;
	            graph_container.caja_metodo_pago_id = $v_metodo;
	            graph_container.getCajaConsultasPorMetodoDePago(1 , null);
	        },

	        getCajaConsultasPorMetodoDePago: function(page , sSearch) {
                $.ajax({
            		type: "GET",
            		url: "admin/cajas/ConsultasPorMetodoDePago/" + graph_container.caja_model + "?page=" + page,
                    data: {
                        sSearch: sSearch ,
                        metodo_pago_id : graph_container.caja_metodo_pago_id ,
                        fecha_inicial: graph_container.fecha_inicial,
                        fecha_final: graph_container.fecha_final,
                        caja_id: graph_container.caja_id
                    },
            	}).done(function(data) {
            		if (data.success == true) {
                        graph_container.x = 2;
                        return $('#cajas_dt').html(data.table);
            		}
            		msg.warning(data, 'Advertencia!');
            	});
	        }
	    }
    });

    function graph_container_compile() {
	    graph_container.$nextTick(function() {
	        graph_container.$compile(graph_container.$el);
	    });
	}

	$(document).on('click', '.pagination_caja_graficas a', function (e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        graph_container.getCajaConsultasPorMetodoDePago(page , null);
    });
</script>

<div class="panel_heading">
    <div class="pull-right">
        <button v-show="x > 1" v-on="click: reset" class="btn" title="Regresar"><i class="fa fa-reply"></i></button>
        <button v-on="click: close" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
    </div>
</div>
<div v-show="x == 1" id="container">
    <table class="dt-table table-striped table-theme" id="example">
        <tbody style="background: #ffffff;">
            <tr>
                <td style="font-size: 14px; color:#1b7be2;" colspan="7" class="dataTables_empty">Cargando datos del servidor...</td>
            </tr>
        </tbody>
    </table>
</div>
<div v-show="x == 2" id="cajas"></div>
<div v-show="x == 2" id="cajas_dt"></div>

<script>
	var graph_container = new Vue({

	    el: '#graph_container',

	    data: {
	        x: 1,
            caja_model: "",
            caja_metodo_pago_id: "",
            caja_id: "",
            fecha_inicial: "{{$fecha_inicial}}",
            fecha_final: "{{$fecha_final}}",
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

            cierreDeCajaPorFecha: function() {
                $fecha = $('#start_hidden').val();

                $.ajax({
            		type: "GET",
            		url: 'admin/cajas/cortesDeCajaPorDia',
                    data: { fecha: $fecha },
            	}).done(function(data) {
            		if (data.success == true)
            		{
            			clean_panel();
                    	$('#graph_container').show();
                    	return $('#graph_container').html(data.view);
            		}
            		msg.warning(data, 'Advertencia!');
            	});
            },

            getMovimientosDeCajaDt: function(e, caja_id){
                $.ajax({
            		type: "POST",
            		url: '/admin/cajas/getMovimientosDeCajaDt',
            		data:{cierre_caja_id: caja_id}
            	}).done(function(data) {
                	if (data.success == true)
                	{
                        graph_container.x = 2;
                        $('#cajas').html(data.view);
                        return graph_container_compile();
                	}
                	msg.warning(data, 'Advertencia!');
                });
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

<div class="panel_heading master-table short_calendar" >
    <div v-show="x == 1" id="table_length2" class="pull-left"></div>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha:</td>
        <td><input type="text" id="fechaCierresCaja" data-value="now" name="start"></td>
        <i class="glyphicon glyphicon-repeat fg-theme" style="cursor:pointer" v-on="click: cierreDeCajaPorFecha"></i>
    </tr>
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


<script>
    var counter = 2;

    var $start = $('input[name="start"]').pickadate(
    {
        selectYears: true,
        selectMonths: true,
        formatSubmit: 'yyyy-m-d',
        hiddenName: true,
        onSet: function() {
            if (counter == 2) {
                counter = 0;
                picker_start.set('select', picker_start.get('highlight'));
                $('.short_calendar .picker__table').css('display', 'none');
            };
            counter++;
        },
        onClose: function(element) {
            $('.short_calendar .picker__table').css('display', 'none');
        }
    });

    $('.short_calendar .picker__table').css('display', 'none');
    var picker_start = $start.pickadate('picker')

    $(document).ready(function() {
        $("#iSearch").val("");
        $("#iSearch").unbind();
        $("#table_length2").html("");

        setTimeout(function() {
            $('#example_length').prependTo("#table_length2");
            graph_container.x = 1;
            $('#iSearch').keyup(function(){
                $('#example').dataTable().fnFilter( $(this).val() );
            })
        }, 300)

        $('#example').dataTable({

            "language": {
                "lengthMenu": "Mostrar _MENU_ archivos por pagina",
                "zeroRecords": "No se encontro ningun archivo",
                "info": "Mostrando la pagina _PAGE_ de _PAGES_",
                "infoEmpty": "No hay archivos disponibles",
                "infoFiltered": "- ( filtrado de _MAX_ archivos )"
            },

            "aoColumnDefs": [
                {"sClass": "mod_codigo hover width10",              "sTitle": "Caja",        "aTargets": [0]},
                {"sClass": "mod_codigo hover width15",              "sTitle": "Usuario",     "aTargets": [1]},
                {"sClass": "mod_codigo hover width40",              "sTitle": "Nota",        "aTargets": [2]},
                {"sClass": "mod_codigo hover width15",              "sTitle": "Fecha Inicio","aTargets": [3]},
                {"sClass": "mod_codigo hover width15",              "sTitle": "Fecha Final", "aTargets": [4]},
                {"sClass": "width5 icons center",                   "sTitle": "",            "aTargets": [5],
                    "orderable": false,
                    "mRender": function(data, type, full) {
                        return '<i title="Ver Corte" onclick="graph_container.getMovimientosDeCajaDt(this, '+full.DT_RowId+')" class="fa fa-search font14" style="padding-left:10px"> </i>';
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
            "sAjaxSource": "admin/cajas/DtCortesDeCajasPorDia",
            "fnServerParams": function (aoData) {
               aoData.push({ "name": "fecha_inicial", "value": "{{$fecha_inicial}}" });
               aoData.push({ "name": "fecha_final",  "value": "{{$fecha_final}}" });
           },
        });

    });
</script>

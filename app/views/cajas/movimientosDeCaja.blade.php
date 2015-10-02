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

	    	getAsignarInfoEnviar: function($v_model ,$v_metodo){
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
    <div class="panel-body" style="padding:0px;">
        <table class="table table-default cierre_caja">
            <thead>
                <tr>
                    <th class="center">Descripcion</th>
                    <th class="center">Efectivo</th>
                    <th class="center">Credito</th>
                    <th class="center">Cheque</th>
                    <th class="center">Tarjeta</th>
                    <th class="center">Deposito</th>
                    <th class="center">Totales</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Ventas</td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Ventas', 1);">
                        {{ f_num::get($data['pagos_ventas']['efectivo']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Ventas', 2);">
                        {{ f_num::get($data['pagos_ventas']['credito']) }} </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Ventas', 3);">
                        {{ f_num::get($data['pagos_ventas']['cheque']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Ventas', 4);">
                        {{ f_num::get($data['pagos_ventas']['tarjeta']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Ventas', 5);">
                        {{ f_num::get($data['pagos_ventas']['deposito']) }} </td>
                    <td class="right"> {{ f_num::get($data['pagos_ventas']['total']) }} </td>
                </tr>
                <tr>
                    <td>Abonos</td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('AbonosVentas', 1);">
                        {{ f_num::get($data['abonos_ventas']['efectivo']) }}
                    </td>
                    <td class="right"> {{ f_num::get($data['abonos_ventas']['credito']) }} </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('AbonosVentas', 3);">
                        {{ f_num::get($data['abonos_ventas']['cheque']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('AbonosVentas', 4);">
                        {{ f_num::get($data['abonos_ventas']['tarjeta']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('AbonosVentas', 5);">
                        {{ f_num::get($data['abonos_ventas']['deposito']) }}
                    </td>
                    <td class="right"> {{ f_num::get($data['abonos_ventas']['total']) }} </td>
                </tr>
                <tr>
                    <td>Soporte</td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Soporte', 1);">
                        {{ f_num::get($data['soporte']['efectivo']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Soporte', 2);">
                        {{ f_num::get($data['soporte']['credito']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Soporte', 3);">
                        {{ f_num::get($data['soporte']['cheque']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Soporte', 4);">
                        {{ f_num::get($data['soporte']['tarjeta']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Soporte', 5);">
                        {{ f_num::get($data['soporte']['deposito']) }}
                    </td>
                    <td class="right"> {{ f_num::get($data['soporte']['total']) }} </td>
                </tr>
                <tr>
                    <td>Adelantos</td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Adelantos', 1);">
                       {{ f_num::get($data['adelantos']['efectivo']) }}
                    </td>
                    <td class="right">
                        {{ f_num::get($data['adelantos']['credito']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Adelantos', 3);">
                       {{ f_num::get($data['adelantos']['cheque']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Adelantos', 4);">
                       {{ f_num::get($data['adelantos']['tarjeta']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Adelantos', 5);">
                       {{ f_num::get($data['adelantos']['deposito']) }}
                    </td>
                    <td class="right"> {{ f_num::get($data['adelantos']['total']) }} </td>
                </tr>
                <tr>
                    <td>Notas de Credito Adelanto</td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('AdelantosNotasCreditos', 1);">
                        {{ f_num::get($data['adelanto_notas_creditos']['efectivo']) }}
                    </td>
                    <td class="right">
                        {{ f_num::get($data['adelanto_notas_creditos']['credito']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('AdelantosNotasCreditos', 3);">
                        {{ f_num::get($data['adelanto_notas_creditos']['cheque']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('AdelantosNotasCreditos', 4);">
                        {{ f_num::get($data['adelanto_notas_creditos']['tarjeta']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('AdelantosNotasCreditos', 5);">
                        {{ f_num::get($data['adelanto_notas_creditos']['deposito']) }}
                    </td>
                    <td class="right"> {{ f_num::get($data['adelanto_notas_creditos']['total']) }} </td>
                </tr>
                <tr>
                    <td>Ingresos</td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Ingresos', 1);">
                       {{ f_num::get($data['ingresos']['efectivo']) }}
                    </td>
                    <td class="right">
                        {{ f_num::get($data['ingresos']['credito']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Ingresos', 3);">
                       {{ f_num::get($data['ingresos']['cheque']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Ingresos', 4);">
                       {{ f_num::get($data['ingresos']['tarjeta']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Ingresos', 5);">
                       {{ f_num::get($data['ingresos']['deposito']) }}
                    </td>
                    <td class="right"> {{ f_num::get($data['ingresos']['total'])  }} </td>
                </tr>
                <tr>
                    <td>Gastos</td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Gastos', 1);">
                        ({{ f_num::get(($data['gastos']['efectivo'] == 0) ?  '0.00':$data['gastos']['efectivo']) }})
                    </td>
                    <td class="right">
                        {{ f_num::get($data['gastos']['credito']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Gastos', 3);">
                         {{ f_num::get($data['gastos']['cheque']) }}
                     </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Gastos', 4);">
                         {{ f_num::get($data['gastos']['tarjeta']) }}
                     </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Gastos', 5);">
                         {{ f_num::get($data['gastos']['deposito']) }}
                     </td>
                    <td class="right"> {{ f_num::get($data['gastos']['total']) }} </td>
                </tr>
                <tr>
                    <td>Egresos</td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Egresos', 1);">
                        ({{ f_num::get(($data['egresos']['efectivo'] == 0) ?  '0.00':$data['egresos']['efectivo']) }})
                    </td>
                    <td class="right">
                        {{ f_num::get($data['egresos']['credito']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Egresos', 2);">
                        {{ f_num::get($data['egresos']['cheque']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Egresos', 5);">
                        {{ f_num::get($data['egresos']['tarjeta']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Egresos', 5);">
                        {{ f_num::get($data['egresos']['deposito']) }}
                    </td>
                    <td class="right"> {{ f_num::get($data['egresos']['total']) }} </td>
                </tr>
                <tr>
                    <td>Notas de Credito Devolucion</td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('DevolucionNotasCreditos', 1);">
                        ({{ f_num::get(($data['devolucion_notas_creditos']['efectivo'] == 0) ?  '0.00':$data['devolucion_notas_creditos']['efectivo']) }})
                    </td>
                    <td class="right">
                        {{ f_num::get($data['devolucion_notas_creditos']['credito']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('DevolucionNotasCreditos', 3);">
                        {{ f_num::get($data['devolucion_notas_creditos']['cheque']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('DevolucionNotasCreditos', 4);">
                        {{ f_num::get($data['devolucion_notas_creditos']['tarjeta']) }}
                    </td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('DevolucionNotasCreditos', 5);">
                        {{ f_num::get($data['devolucion_notas_creditos']['deposito']) }}
                    </td>
                    <td class="right"> {{ f_num::get($data['devolucion_notas_creditos']['total']) }} </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>Efectivo esperado en caja</th>
                    <th class="right" style="padding-right: 10px !important;">
                        <?php
                            $caja_negativos = $data['devolucion_notas_creditos']['efectivo'] + $data['egresos']['efectivo'] + $data['gastos']['efectivo'];

                            $caja_positivos = $data['adelanto_notas_creditos']['efectivo'] + $data['ingresos']['efectivo'] + $data['adelantos']['efectivo'] + $data['soporte']['efectivo'] + $data['pagos_ventas']['efectivo'] + $data['abonos_ventas']['efectivo'];

                            $caja =  $caja_positivos - $caja_negativos;
                            echo f_num::get($caja);
                        ?>
                    </th>
                    <th></th>
                    <th class="right" style="padding-right: 10px !important;">
                        <?php
                            $total_cheque = $data['pagos_ventas']['cheque'] + $data['abonos_ventas']['cheque'] + $data['soporte']['cheque'] + $data['ingresos']['cheque'] + $data['adelantos']['cheque'] + $data['adelanto_notas_creditos']['cheque'];
                            echo f_num::get($total_cheque);
                         ?>
                    </th>
                    <th class="right" style="padding-right: 10px !important;">
                        <?php
                            $total_tarjeta = $data['pagos_ventas']['tarjeta'] + $data['abonos_ventas']['tarjeta'] + $data['soporte']['tarjeta'] + $data['ingresos']['tarjeta'] + $data['adelantos']['tarjeta'] + $data['adelanto_notas_creditos']['tarjeta'];
                            echo f_num::get($total_tarjeta);
                         ?>
                    </th>
                    <th class="right" style="padding-right: 10px !important;">
                        <?php
                            $total_deposito = $data['pagos_ventas']['deposito'] + $data['abonos_ventas']['deposito'] + $data['soporte']['deposito'] + $data['ingresos']['deposito'] + $data['adelantos']['deposito'] + $data['adelanto_notas_creditos']['deposito'];
                            echo f_num::get($total_deposito);
                         ?>
                    </th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<div v-show="x == 2" id="cajas_dt"></div>

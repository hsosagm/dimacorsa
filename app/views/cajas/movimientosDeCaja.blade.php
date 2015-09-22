<div class="panel panel-default">
    <div class="panel-heading">
        <div class="pull-left">
            <h3 class="panel-title fg-theme">Movimientos de Caja</h3>
        </div>
        <div class="pull-right">
            <button title="" data-original-title="" class="btn btn-sm" data-action="remove" onclick="$('#graph_container').hide();" data-toggle="tooltip" data-placement="top" data-title="cerrar"><i class="fa fa-times fg-theme"></i></button>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body" style="padding:0px;">
        <table class="table table-default">
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
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Ventas',1);"> 
                        {{ f_num::get($data['pagos_ventas']['efectivo']) }} 
                    </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Ventas',2);">
                        {{ f_num::get($data['pagos_ventas']['credito']) }} </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Ventas',3);">
                        {{ f_num::get($data['pagos_ventas']['cheque']) }} 
                    </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Ventas',4);">
                        {{ f_num::get($data['pagos_ventas']['tarjeta']) }} 
                    </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Ventas',5);">
                        {{ f_num::get($data['pagos_ventas']['deposito']) }} </td> 
                    <td class="right"> {{ f_num::get($data['pagos_ventas']['total']) }} </td> 
                </tr>
                <tr>
                    <td>Abonos</td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('AbonosVentas',1);"> 
                        {{ f_num::get($data['abonos_ventas']['efectivo']) }} 
                    </td> 
                    <td class="right">       {{ f_num::get($data['abonos_ventas']['credito']) }} </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('AbonosVentas',3);">
                        {{ f_num::get($data['abonos_ventas']['cheque']) }} 
                    </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('AbonosVentas',4);" > 
                        {{ f_num::get($data['abonos_ventas']['tarjeta']) }} 
                    </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('AbonosVentas',5);"> 
                        {{ f_num::get($data['abonos_ventas']['deposito']) }} 
                    </td> 
                    <td class="right">       {{ f_num::get($data['abonos_ventas']['total'])   }} </td> 
                </tr>
                <tr>
                    <td>Soporte</td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Soporte',1);">
                        {{ f_num::get($data['soporte']['efectivo']) }} 
                    </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Soporte',2);">
                        {{ f_num::get($data['soporte']['credito'] ) }} 
                    </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Soporte',3);">
                        {{ f_num::get($data['soporte']['cheque']  ) }} 
                    </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Soporte',4);">
                        {{ f_num::get($data['soporte']['tarjeta'] ) }} 
                    </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Soporte',5);">
                        {{ f_num::get($data['soporte']['deposito']) }} 
                    </td> 
                    <td class="right">       {{ f_num::get($data['soporte']['total'])   }} </td> 
                </tr>
                <tr>
                    <td>Adelantos</td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Adelantos',1);">
                       {{ f_num::get($data['adelantos']['efectivo']) }} 
                    </td> 
                    <td class="right"> 
                        {{ f_num::get($data['adelantos']['credito'] ) }} 
                    </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Adelantos',3);">
                       {{ f_num::get($data['adelantos']['cheque']  ) }} 
                    </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Adelantos',4);">
                       {{ f_num::get($data['adelantos']['tarjeta'] ) }} 
                    </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Adelantos',5);">
                       {{ f_num::get($data['adelantos']['deposito']) }} 
                    </td> 
                    <td class="right"> {{ f_num::get($data['adelantos']['total']) }} </td> 
                </tr>
                <tr>
                    <td>Ingresos</td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Ingresos',1);">
                       {{ f_num::get($data['ingresos']['efectivo']) }} 
                    </td> 
                    <td class="right"> 
                        {{ f_num::get($data['ingresos']['credito'] ) }} 
                    </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Ingresos',3);">
                       {{ f_num::get($data['ingresos']['cheque']  ) }} 
                    </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Ingresos',4);">
                       {{ f_num::get($data['ingresos']['tarjeta'] ) }} 
                    </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Ingresos',5);">
                       {{ f_num::get($data['ingresos']['deposito']) }} 
                    </td> 
                    <td class="right"> {{ f_num::get($data['ingresos']['total'])  }} </td> 
                </tr>
                <tr>
                    <td>Gastos</td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Gastos',1);">
                        ({{ f_num::get(($data['gastos']['efectivo'] == 0) ?  '0.00':$data['gastos']['efectivo']) }})
                    </td> 
                    <td class="right"> 
                        {{ f_num::get($data['gastos']['credito'] ) }} 
                    </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Gastos',3);">
                         {{ f_num::get($data['gastos']['cheque']  ) }} 
                     </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Gastos',4);">
                         {{ f_num::get($data['gastos']['tarjeta'] ) }} 
                     </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Gastos',5);">
                         {{ f_num::get($data['gastos']['deposito']) }} 
                     </td> 
                    <td class="right"> {{ f_num::get($data['gastos']['total']) }} </td> 
                </tr>
                <tr>
                    <td>Egresos</td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Egresos',1);">
                        ({{ f_num::get(($data['egresos']['efectivo'] == 0) ?  '0.00':$data['egresos']['efectivo']) }})
                    </td> 
                    <td class="right"> 
                        {{ f_num::get($data['egresos']['credito'] ) }} 
                    </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Egresos',3);">
                        {{ f_num::get($data['egresos']['cheque']  ) }} 
                    </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Egresos',4);">
                        {{ f_num::get($data['egresos']['tarjeta'] ) }} 
                    </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Egresos',5);">
                        {{ f_num::get($data['egresos']['deposito']) }} 
                    </td> 
                    <td class="right"> {{ f_num::get($data['egresos']['total']) }} </td> 
                </tr>
                <tr>
                    <td>Notas de Credito</td>
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('Egresos',1);">
                        ({{ f_num::get(($data['notas_creditos']['efectivo'] == 0) ?  '0.00':$data['notas_creditos']['efectivo']) }})
                    </td> 
                    <td class="right"> 
                        {{ f_num::get($data['notas_creditos']['credito'] ) }} 
                    </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('notas_creditos',3);">
                        {{ f_num::get($data['notas_creditos']['cheque']  ) }} 
                    </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('notas_creditos',4);">
                        {{ f_num::get($data['notas_creditos']['tarjeta'] ) }} 
                    </td> 
                    <td class="right hover" v-on="click: getAsignarInfoEnviar('notas_creditos',5);">
                        {{ f_num::get($data['notas_creditos']['deposito']) }} 
                    </td> 
                    <td class="right"> {{ f_num::get($data['notas_creditos']['total']) }} </td> 
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>Efectivo esperado en caja</th>
                    <th class="right" style="padding-right: 10px !important;">
                        <?php 
                            $caja_negativos = $data['notas_creditos']['efectivo'] + $data['egresos']['efectivo'] + $data['gastos']['efectivo'];

                            $caja_positivos = $data['ingresos']['efectivo'] + $data['adelantos']['efectivo'] + $data['soporte']['efectivo'] + $data['pagos_ventas']['efectivo'] + $data['abonos_ventas']['efectivo'];

                            $caja =  $caja_positivos - $caja_negativos;
                            echo f_num::get($caja);
                        ?>
                    </th>
                    <th></th>
                    <th class="right" style="padding-right: 10px !important;">
                        <?php 
                            $total_cheque = $data['pagos_ventas']['cheque'] + $data['abonos_ventas']['cheque'] + $data['soporte']['cheque'] + $data['ingresos']['cheque'] + $data['adelantos']['cheque'] ;
                            echo f_num::get($total_cheque);
                         ?>
                    </th> 
                    <th class="right" style="padding-right: 10px !important;">
                        <?php 
                            $total_tarjeta = $data['pagos_ventas']['tarjeta'] + $data['abonos_ventas']['tarjeta'] + $data['soporte']['tarjeta'] + $data['ingresos']['tarjeta'] + $data['adelantos']['tarjeta'];
                            echo f_num::get($total_tarjeta);
                         ?>
                    </th> 
                    <th class="right" style="padding-right: 10px !important;">
                        <?php 
                            $total_deposito = $data['pagos_ventas']['deposito'] + $data['abonos_ventas']['deposito'] + $data['soporte']['deposito'] + $data['ingresos']['deposito'] + $data['adelantos']['deposito'];
                            echo f_num::get($total_deposito);
                         ?>
                    </th> 
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
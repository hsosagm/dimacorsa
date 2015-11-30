<div class="panel-body" style="padding:0px;">
    <table class="table table-default cierre_caja" width="100%">
        <thead>
            <tr>
                <th class="center">Descripcion</th>
                <th class="center">Efectivo</th>
                <th class="center">Credito</th>
                <th class="center">Cheque</th>
                <th class="center">Tarjeta</th>
                <th class="center">Deposito</th>
                <th class="center">Notas C.</th>
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
                    {{ f_num::get($data['pagos_ventas']['deposito']) }}
                </td>
                <td class="right hover" v-on="click: getAsignarInfoEnviar('Ventas', 6);">
                    {{ f_num::get($data['pagos_ventas']['notaCredito']) }}
                </td>
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
                <td class="right">0.00</td>
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
                <td class="right">0.00</td>
                <td class="right"> {{ f_num::get($data['soporte']['total']) }} </td>
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
                <td class="right">0.00</td>
                <td class="right"> {{ f_num::get($data['ingresos']['total'])  }} </td>
            </tr> 
            <tr>
                <td>Devoluciones</td>
                <td class="right hover" v-on="click: getAsignarInfoEnviar('Devolucion', 1);">
                   ({{ f_num::get($data['devolucion']['efectivo']) }})
                </td>
                <td class="right">
                    {{ f_num::get($data['devolucion']['credito']) }}
                </td>
                <td class="right hover" v-on="click: getAsignarInfoEnviar('Devolucion', 3);">
                   {{ f_num::get($data['devolucion']['cheque']) }}
                </td>
                <td class="right hover">
                   {{ f_num::get($data['devolucion']['tarjeta']) }}
                </td>
                <td class="right hover" v-on="click: getAsignarInfoEnviar('Devolucion', 5);">
                   {{ f_num::get($data['devolucion']['deposito']) }}
                </td>
                <td class="right hover"  v-on="click: getAsignarInfoEnviar('Devolucion', 4);">
                    {{ f_num::get($data['devolucion']['notaCredito']) }}
                </td>
                <td class="right"> {{ f_num::get($data['devolucion']['total'])  }} </td>
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
                 <td class="right">0.00</td>
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
                <td class="right">0.00</td>
                <td class="right"> {{ f_num::get($data['egresos']['total']) }} </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th class="left">Efectivo esperado</th>
                <th class="right">
                    <?php
                        $caja_negativos =  $data['egresos']['efectivo'] + $data['gastos']['efectivo'] + $data['devolucion']['efectivo'];
                        $caja_positivos = $data['ingresos']['efectivo'] + $data['soporte']['efectivo'] + $data['pagos_ventas']['efectivo'] + $data['abonos_ventas']['efectivo'];
                        $caja =  $caja_positivos - $caja_negativos;

                        echo f_num::get($caja);
                    ?>
                </th>
                <th></th>
                <th class="right">
                    <?php
                        $total_cheque = $data['pagos_ventas']['cheque'] + $data['abonos_ventas']['cheque'] + $data['soporte']['cheque'] + $data['ingresos']['cheque'];

                        echo f_num::get($total_cheque);
                     ?>
                </th>
                <th class="right">
                    <?php
                        $total_tarjeta = $data['pagos_ventas']['tarjeta'] + $data['abonos_ventas']['tarjeta'] + $data['soporte']['tarjeta'] + $data['ingresos']['tarjeta'];

                        echo f_num::get($total_tarjeta);
                     ?>
                </th>
                <th class="right">
                    <?php
                        $total_deposito = $data['pagos_ventas']['deposito'] + $data['abonos_ventas']['deposito'] + $data['soporte']['deposito'] + $data['ingresos']['deposito'];

                        echo f_num::get($total_deposito);
                     ?>
                </th>
                <th></th>
                <th></th>
            @if(@$cierre_caja != null)
            </tr>
                <tr>
                    <td class="left">Monto Real</td>
                    <td class="right"> {{ f_num::get(@$cierre_caja->efectivo) }} </td>
                    <td></td>
                    <td class="right"> {{ f_num::get(@$cierre_caja->cheque) }} </td>
                    <td class="right"> {{ f_num::get(@$cierre_caja->tarjeta) }} </td>
                    <td class="right"> {{ f_num::get(@$cierre_caja->deposito) }} </td>
                    <td></td>
                </tr>
                <tr>
                    <th class="left">Diferencia</th>
                    <th class="right"> {{ f_num::get(@$cierre_caja->efectivo - $caja) }} </th>
                    <th></th>
                    <th class="right"> {{ f_num::get(@$cierre_caja->cheque - $total_cheque) }} </th>
                    <th class="right"> {{ f_num::get(@$cierre_caja->tarjeta - $total_tarjeta) }} </th>
                    <th class="right"> {{ f_num::get(@$cierre_caja->deposito - $total_deposito) }} </th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <td colspan="8" class="center">
                        *** Corte Realizado por {{ @$cierre_caja->user->nombre.' '.@$cierre_caja->user->apellido }} ***
                        <br>
                        - del {{ @$cierre_caja->fecha_inicial }} al {{ @$cierre_caja->fecha_final }} -
                    </td>
                </tr>
            @endif
        </tfoot>
    </table>
</div>

@if(@$cierre_caja != null)
    <script type="text/javascript">
        graph_container.fecha_inicial = '{{ @$cierre_caja->fecha_inicial }}';
        graph_container.fecha_final = '{{ @$cierre_caja->fecha_final }}';
        graph_container.caja_id = {{ @$cierre_caja->caja_id }};
    </script>
@endif

<style>
    .right{
        text-align: right;
        padding-right: 10px !important;
    }

    .left{
        text-align: left;
    }

    .center{
        text-align: center;
    }
</style>

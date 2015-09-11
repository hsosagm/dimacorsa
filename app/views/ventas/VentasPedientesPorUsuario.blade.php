<div class="rounded shadow"> 
    <div class="panel_heading">
        <div id="table_length" class="pull-left"></div>
        <div class="DTTT btn-group"></div>
        <div class="pull-right">
            <i class="fa fa-file-excel-o fa-lg" v-on="click: exportarVentasPendientesDeUsuarios('xlsx')"> </i>
            <i class="fa fa-file-pdf-o fa-lg" v-on="click: exportarVentasPendientesDeUsuarios('pdf')"> </i>
            <button v-on="click: closeMainContainer" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="no-padding table">
        <table id="example" class="display" width="100%" cellspacing="0">
            <thead>
                <tr id="hhh">
                    <th style="display:none">Fecha</th>
                    <th>Usuario</th>
                    <th>Tienda</th>
                    <th>Total Ventas</th>
                    <th>Saldo Total</th>
                    <th>Saldo Vencido</th>
                    <th>     </th>
                </tr>
            </thead>

            <tbody>
                @foreach($ventas as $q)
                    <tr id="{{$q->user_id}}" class="{{($q->saldo_vencido > 0)? 'red':''}}">
                        <td style="display:none" width="10%"> {{ $q->fecha }} </td>
                        <td class="" width="21%"> {{ $q->usuario }} </td>
                        <td class="" width="21%"> {{ $q->tienda }} </td>
                        <td class="right" width="15%"> {{ f_num::get($q->total) }} </td>
                        <td class="right" width="15%"> {{ f_num::get($q->saldo_total) }} </td>
                        <td class="right" width="15%"> {{ f_num::get($q->saldo_vencido) }} </td>
                        <td class="center" width="3%">
                            <i id="{{$q->user_id}}" class="fa fa-search btn-link theme-c" style="margin-left:5px" v-on="click: DetalleVentasPendientesPorUsuario($event, {{$q->user_id}})" ></i>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
 
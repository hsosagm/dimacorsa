<div class="rounded shadow">
    <div class="panel_heading">
        <div id="table_length" class="pull-left"></div>
        <div class="DTTT btn-group"></div>
        <div class="pull-right">
            <button v-on="click: closeMainContainer" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="no-padding table">
        <table id="example" class="display" width="100%" cellspacing="0">
            <thead>
                <tr id="hhh">
                    <th>Cliente</th>
                    <th>Direccion</th>
                    <th>Total Ventas</th>
                    <th>Saldo Total</th>
                    <th>Saldo Vencido</th>
                    <th>     </th>
                </tr>
            </thead>

            <tbody>
                @foreach($ventas as $q)
                    <tr class="" id="{{$q->id}}">
                        <td class="" width="20%"> {{ $q->cliente }} </td>
                        <td class="" width="30%"> {{ $q->direccion }} </td>
                        <td class="right" width="15%"> {{ f_num::get($q->total) }} </td>
                        <td class="right" width="15%"> {{ f_num::get($q->saldo_total) }} </td>
                        <td class="right" width="15%"> {{ f_num::get($q->saldo_vencido) }} </td>
                        <td class="center" width="5%">
                            <i id="{{$q->id}}" class="fa fa-plus-square btn-link theme-c" onClick="VentasPendientesPorCliente(this,{{$q->id}})" ></i>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
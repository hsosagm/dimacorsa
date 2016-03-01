<?php $caja = Caja::whereUserId(Auth::user()->id)->get(); ?>

<div class="rounded shadow">
    <div class="panel_heading">
        <div id="table_length" class="pull-left"></div>
        <div class="DTTT btn-group"></div>
        <div class="pull-right">
            <i class="fa fa-file-excel-o fa-lg" v-on="click: exportarEstadoDeCuentaDeClientes('xlsx')"> </i>
            <i class="fa fa-file-pdf-o fa-lg" v-on="click: exportarEstadoDeCuentaDeClientes('pdf')"> </i>
            <button v-on="click: closeMainContainer" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="no-padding table">
        <table id="example" class="display" width="100%" cellspacing="0">
            <thead>
                <tr id="hhh">
                    <th style="display:none">Fecha</th>
                    <th>Cliente</th>
                    <th>Direccion</th>
                    <th>Total</th>
                    <th>Saldo</th>
                    <th>Saldo Vencido</th>
                    <th>Operaciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $q)
                    <tr id="{{$q->cliente_id}}" class="{{($q->saldo_vencido > 0)? 'red':''}}">
                        <td style="display:none" width="10%"> {{ $q->fecha }} </td>
                        <td width="23%" v-on="click: goToCustomer({{$q->cliente_id}})" style="cursor:pointer;">{{ $q->cliente }} <i class="fa fa-search" style="float: right; margin-right:5px;"></i></td>
                        <td class="" width="22%"> {{ $q->direccion }} </td>
                        <td class="right" width="10%"> {{ f_num::get($q->total) }} </td>
                        <td class="right" width="10%"> {{ f_num::get($q->saldo_total) }} </td>
                        <td class="right" width="10%"> {{ f_num::get($q->saldo_vencido) }} </td>
                        <td class="center" width="10%">
                            <i class="fa fa-search btn-link theme-c" style="margin-left:5px" v-on="click: VentasPendientesPorCliente($event, {{$q->cliente_id}})" ></i>
                            @if (Auth::user()->tienda->cajas)
                                @if(count($caja))
                                    <i class="fa fa-paypal fg-theme" style="margin-left:5px" v-on="click: payFromTable($event, {{$q->cliente_id}})"></i>
                                @endif
                            @else
                                <i class="fa fa-paypal fg-theme" style="margin-left:5px" v-on="click: payFromTable($event, {{$q->cliente_id}})"></i>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

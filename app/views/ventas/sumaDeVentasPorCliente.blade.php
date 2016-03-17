<div class="rounded shadow">
    <div class="panel_heading">
        <div id="table_length" class="pull-left"></div>
        <div class="pull-right">
            <i class="fa fa-file-excel-o fa-lg" v-on="click: exportarSumaDeVentasPorClientes(false)"> </i>
            <i class="fa fa-file-pdf-o fa-lg" v-on="click: exportarSumaDeVentasPorClientes(true)"> </i>
            <button v-on="click: closeMainContainer" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="no-padding table">
        <table id="example" class="display" width="100%" cellspacing="0">
            <thead>
                <tr id="hhh">
                    <th width="1%">No.</th>
                    <th width="40%">Cliente</th>
                    <th width="45%">Direccion</th>
                    <th width="15%">Total</th>
                </tr>
            </thead>
            <tbody>
                @php($num = 1)
                @foreach($clientes as $cl)
                    <tr>
                        <td width="1%"> {{ $num }} </td>
                        <td width="40%"> {{ $cl->cliente }} </td>
                        <td width="45%"> {{ $cl->direccion }} </td>
                        <td class="right" width="15%"> {{ f_num::get($cl->total) }} </td>
                    </tr>
                    @php($num++)
                @endforeach
            </tbody>
        </table>
    </div>
</div>

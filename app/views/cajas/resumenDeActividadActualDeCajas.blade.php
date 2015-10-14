<div class="panel_heading">
    <div class="pull-right">
        <button onclick="$('#graph_container').hide();" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
    </div>
</div>
<div class="panel-body" style="padding:0px;">
    <table class="table table-default cierre_caja" width="100%">
        <thead>
            <tr>
                <th>Caja</th>
                <th>Usuario</th>
                <th>Efectivo</th>
                <th>Cheque</th>
                <th>Tarjeta</th>
                <th>Deposito</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $dt)
                <tr>
                    <td> {{ $dt['caja'] }} </td>
                    <td> {{ $dt['usuario'] }} </td>
                    <td class="right"> {{ f_num::get($dt['efectivo']) }} </td>
                    <td class="right"> {{ f_num::get($dt['cheque']) }} </td>
                    <td class="right"> {{ f_num::get($dt['tarjeta']) }} </td>
                    <td class="right"> {{ f_num::get($dt['deposito']) }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

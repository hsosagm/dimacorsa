<table width="100%">
    <tr>
        <td colspan="5" align="center">
            <h3>Constancia de devolucion</h3>
        </td>
    </tr>

    <tr style="background-color: #ECECEC">
        <th>Cantidad</th>
        <th colspan="2">Producto</th>
        <th>Precio @php($total=0)</th>
        <th>Total @php($i=0)</th>
    </tr>

    <tr><td colspan="5" style="border-bottom:1px solid #444444; "></td></tr>

    @foreach($devolucion->devolucion_detalle as $dt)
        <tr style="{{($i==0)? '' : 'background-color: #ECECEC'}}">
            <td> {{ $dt->cantidad }} </td>
            <td colspan="2"> {{ $dt->producto->descripcion.' ['.$dt->producto->marca->nombre.']' }} </td>
            <td align="right"> {{ f_num::get($dt->precio) }} @php($total += ($dt->precio * $dt->cantidad ))</td>
            <td align="right"> {{ f_num::get($dt->precio * $dt->cantidad) }} @php(($i == 0)? $i=1 : $i=0)</td>
        </tr>
    @endforeach

    <tr><td colspan="5" style="border-bottom:1px solid #444444; "></td></tr>
    <tr>
        <td colspan="3"></td>
        <td>Total</td>
        <td align="right"> {{ f_num::get($total) }} </td>
    </tr>

    <tr><td colspan="5" style="border-bottom:1px solid #444444; "></td></tr>
    <tr><td colspan="5" style="border-bottom:1px solid #444444; "></td></tr>
    <tr><td colspan="5" height="20"></td></tr>

    <tr>
        <td colspan="5" align="center">
            <h3>Pagos Efectuados</h3>
        </td>
    </tr>
    <tr style="background-color: #ECECEC">
        <th colspan="4">Metodo de pago @php($total=0)</th>
        <th>monto @php($i=0)</th>
    </tr>

    <tr><td colspan="5" style="border-bottom:1px solid #444444; "></td></tr>

    @foreach($devolucion->devolucion_pagos as $dt)
        <tr style="{{($i==0)? '' : 'background-color: #ECECEC'}}">
            <td colspan="4"> {{ $dt->metodo_pago->descripcion }} @php($total += ($dt->monto) )</td>
            <td align="right"> {{ f_num::get($dt->monto) }} @php(($i == 0)? $i=1 : $i=0)</td>
        </tr>
    @endforeach

    <tr><td colspan="5" style="border-bottom:1px solid #444444; "></td></tr>

    <tr>
        <td colspan="3"></td>
        <td>Total</td>
        <td align="right"> {{ f_num::get($total) }} </td>
    </tr>

    <tr><td colspan="5" style="border-bottom:1px solid #444444; "></td></tr>
    <tr><td colspan="5" style="border-bottom:1px solid #444444; "></td></tr>
    <tr><td colspan="5" height="5"></td></tr>

    <tr>
        <td colspan="5">
            {{ ($devolucion->observaciones != "")? 'Nota: '.$devolucion->observaciones:'' }}
        </td>
    </tr>
    
    <tr><td colspan="5" height="50"></td></tr>

    <tr><td colspan="5" align="center">___________________________________________________</td></tr>
    <tr><td colspan="5" align="center">
        {{ $devolucion->cliente->nombre }}
        {{ ($devolucion->cliente->telefono != "")? 'Tel:'.$devolucion->cliente->telefono:'' }}
    </td></tr>
    <tr><td colspan="5" align="center"> {{ $devolucion->cliente->direccion }} </td></tr>
</table>

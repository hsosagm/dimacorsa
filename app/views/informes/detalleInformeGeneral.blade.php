<table width="100%" class="DT_table_div">
    <tr>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">Ventas</td>
        <td align="right">Compras</td>
        <td align="right">Descargas</td>
        <td align="right">Traslados</td>
        <td align="right">Esperado</td>
        <td align="right">Real</td>
    </tr>

    <tr>
        <td>Inversion</td>
        <td align="right"> {{f_num::get($data['inversionActual'])}} </td>
        <td align="right"> {{f_num::get($data['ventas'])}} </td>
        <td align="right"> {{f_num::get($data['compras'])}} </td>
        <td align="right"> {{f_num::get($data['descargas'])}} </td>
        <td align="right"> {{f_num::get($data['traslados'])}} </td>
        <td align="right">
            {{f_num::get(
                ($data['inversionActual'] + $data['compras']) -
                ($data['ventas'] + $data['descargas'] + $data['traslados'])
            )}}
        </td>
        <td align="right">{{f_num::get($data['inversionReal'])}}</td>
    </tr>

    <tr> <td colspan="8" height="50"></td> </tr>

    <tr>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">Creditos</td>
        <td align="right">Abonos</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>

    <tr>
        <td>Cuentas por cobrar</td>
        <td align="right"> {{f_num::get($data['cuentasCobrarActual'])}} </td>
        <td align="right"> {{f_num::get($data['ventas_credito'])}} </td>
        <td align="right"> {{f_num::get($data['abonos_ventas'])}} </td>
        <td align="right" colspan="2"></td>
        <td align="right">
            {{f_num::get(
                ($data['cuentasCobrarActual'] + $data['ventas_credito']) -
                ($data['abonos_ventas'])
            )}}
        </td>
        <td align="right">{{f_num::get($data['cuentasCobrarReal'])}}</td>
    </tr>

    <tr> <td colspan="8" height="50"> </td> </tr>

    <tr>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">Creditos</td>
        <td align="right">Abonos</td>
        <td align="right" colspan="2"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>

    <tr>
        <td>Cuentas por pagar</td>
        <td align="right"> {{f_num::get($data['cuentasPagarActual'])}} </td>
        <td align="right"> {{f_num::get($data['compras_credito'])}} </td>
        <td align="right"> {{f_num::get($data['abonos_compras'])}} </td>
        <td align="right" colspan="2"></td>
        <td align="right">
            {{f_num::get(
                ($data['cuentasPagarActual'] + $data['compras_credito']) -
                ($data['abonos_compras'])
            )}}
        </td>
        <td align="right">{{f_num::get($data['cuentasPagarReal'])}}</td>
    </tr>
</table>

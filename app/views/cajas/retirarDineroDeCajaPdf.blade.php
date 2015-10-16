<table width="100%">
    <tr>
        <td width="20%"></td>
        <td colspan="3" width="80%"></td>
    </tr>
    <tr>
        <td colspan="4" align="center"><h2>Retiro De Caja</h2></td>
    </tr>

    <tr> <td colspan="4" style="border-bottom:1px solid #444444;"></td></tr>
    <tr> <td colspan="4" style="border-bottom:1px solid #444444;"></td></tr>

    <tr>
        <td> Usuario:</td>
        <td colspan="3"> {{ Auth::user()->nombre.' '.Auth::user()->apellido }} </td>
    </tr>
    <tr>
        <td> Fecha/Hora:</td>
        <td colspan="3"> {{ Carbon::now() }} </td>
    </tr>

    <tr>
        <td> Caja Actual :</td>
        <td colspan="3"> {{ $caja->nombre }} </td>
    </tr>

    <tr> <td colspan="4" style="border-bottom:1px solid #444444; "></td></tr>

    <tr>
        <td colspan="1">Efectivo Anterior: </td>
        <td colspan="3"> {{ f_num::get($efectivo) }} </td>
    </tr>
    <tr>
        <td colspan="1">Efectivo Salida : </td>
        <td colspan="3"> {{ f_num::get($monto) }} </td>
    </tr>
    <tr>
        <td colspan="1">Efectivo Actual : </td>
        <td colspan="3">{{ f_num::get($efectivo - $monto) }} </td>
    </tr>

    <tr> <td colspan="4" style="border-bottom:1px solid #444444; "></td></tr>
    <tr> <td colspan="4" style="border-bottom:1px solid #444444; "></td></tr>
    <tr> <td colspan="4" height="50"></td> </tr>
    <tr> <td colspan="4" style="border-bottom:1px solid #444444; ">Recibido Por:</td></tr>
    <tr> <td colspan="4" height="100"></td></tr>

    <tr> <td colspan="4" align="center">___________________________________________</td></tr>
    <tr> <td colspan="4" align="center">Firma</td></tr>

</table>

<table width="100%">
    <tr>
        <td colspan="4" align="center"><h2>Comprobante de Adelanto</h2></td>
    </tr>

    <tr> <td colspan="4" style="border-bottom:1px solid #444444; "></td></tr>
    <tr> <td colspan="4" style="border-bottom:1px solid #444444; "></td></tr>

    <tr>
        <td colspan="4">
            Usuario: {{ $notaCredito->user->nombre.' '.$notaCredito->user->apellido }}
        </td>
    </tr> 
    <tr>
        <td colspan="4">
            Cliente : {{ $notaCredito->cliente->nombre }} , {{ $notaCredito->cliente->direccion }}
        </td>
    </tr>

    <tr> <td colspan="4" style="border-bottom:1px solid #444444; "></td></tr>

    <tr>
        <td colspan="4">Fecha : {{ $notaCredito->created_at }} </td>
    </tr>

    <tr> <td colspan="4" style="border-bottom:1px solid #444444; "></td> </tr>

    <tr>
        <td colspan="4">Monto : {{ $notaCredito->monto }} </td>
    </tr>

    <tr> <td colspan="4" style="border-bottom:1px solid #444444; "></td></tr>
    <tr> <td colspan="4" style="border-bottom:1px solid #444444; "></td></tr>
    <tr> <td colspan="4" height="100"></td></tr>

    <tr> <td colspan="4" align="center">___________________________________________</td></tr>
    <tr> <td colspan="4" align="center">Firma</td></tr>
</table>

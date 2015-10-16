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
        <td colspan="4"> Nota :<strong> {{ $notaCredito->nota }} </strong> </td>
    </tr>

    <tr> <td colspan="4" style="border-bottom:1px solid #444444; "></td></tr>
    <tr> <td colspan="4" style="border-bottom:1px solid #444444; "></td> </tr>

    <tr style="background-color: #ECECEC;">
        <td colspan="3"  align="center"> <strong>  Metodo de Pago </strong> </td>
        <td  align="center"> <strong> Monto </strong> <?php $total = 0; ?></td>
    </tr>

    @foreach($notaCredito->adelanto as $dt)
        <tr>
            <td colspan="3" style="padding-left:15px;"> {{ $dt->metodoPago->descripcion }} </td>
            <td  align="right" style="padding-right:15px;"> {{ f_num::get($dt->monto) }} <?php $total+= $dt->monto; ?></td>
        </tr>
    @endforeach

    <tr> <td colspan="4" style="border-bottom:1px solid #444444; "></td></tr>

    <tr>
        <td colspan="3"  align="right"> <strong>  Total: </strong> </td>
        <td  align="right"  style="padding-right:12px;"> <strong> {{ f_num::get($total) }} </strong> </td>
    </tr>

    <tr> <td colspan="4" style="border-bottom:1px solid #444444; "></td></tr>
    <tr> <td colspan="4" style="border-bottom:1px solid #444444; "></td></tr>
    <tr> <td colspan="4" height="100"></td></tr>
    
    <tr> <td colspan="4" align="center">___________________________________________</td></tr>
    <tr> <td colspan="4" align="center">Firma</td></tr>
</table>

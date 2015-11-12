<table width="100%">
    <tr> <td colspan="3" style="border-bottom:1px solid #444444; "></td> </tr>
    <tr> <td colspan="3" style="border-bottom:1px solid #444444; "></td> </tr>
    <tr>
        <td>host:</td>
        <td colspan="2"> {{ $_SERVER['HTTP_HOST'] }} </td>
    </tr>
    <tr>
        <td>Tienda:</td>
        <td colspan="2"> {{ $tienda->nombre }} </td>
    </tr>
    <tr>
        <td>Direccion:</td>
        <td colspan="2"> {{ $tienda->diereccion }} </td>
    </tr>
    <tr> <td colspan="3" style="border-bottom:1px solid #444444; "></td> </tr>
    <tr> <td colspan="3" style="border-bottom:1px solid #444444; "></td> </tr>
    <tr>
        <td>Correos:</td>
        <td colspan="2"></td>
    </tr>
    <tr> <td colspan="3" style="border-bottom:1px solid #444444; "></td> </tr>
    @foreach($correos as $dt)
        <tr>
            <td></td>
            <td colspan="2"> {{ $dt->correo }} </td>
        </tr>
    @endforeach
    <tr> <td colspan="3" style="border-bottom:1px solid #444444; "></td> </tr>
    <tr> <td colspan="3" style="border-bottom:1px solid #444444; "></td> </tr>
</table>

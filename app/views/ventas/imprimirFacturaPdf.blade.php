<table style="font-size:12px;">
    <tr>
        <td colspan="4" height="40"></td>
    </tr>
    <tr>
        <td colspan="4">
            Cliente: {{ $venta->cliente->nombre }}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Nit: {{ $venta->cliente->nit }}
         </td>
    </tr>
    <tr>
        <td colspan="4"> Direccion: {{ $venta->cliente->direccion }} </td>
    </tr>
    <tr>
        <td colspan="4" height="20"></td>
    </tr>
</table>

<table width="100%" style="font-size:12px;">
    <tr style="text-align:center;">
        <td width="8%"></td>
        <td width="72%"></td>
        <td width="10%"></td>
        <td width="10%"><?php $total = 0;  $espacio = 200; ?></td>
    </tr>
    <tbody>
        @foreach($venta->detalle_venta as $key => $dt)
            <tr>
                <td>  {{ $dt->cantidad }} </td>
                <td>  {{ $dt->producto->descripcion}} {{ $dt->producto->marca->nombre}} </td>
                <td class="right"> {{ f_num::get($dt->precio) }} </td>
                <td class="right">
                    {{ f_num::get($dt->cantidad * $dt->precio)}}
                    <?php
                        $total = $total +($dt->cantidad * $dt->precio);
                        $espacio = $espacio - 13;
                    ?>
                </td>
            </tr>
        @endforeach
    </tbody>
    <tr>
        <td colspan="4" height="{{$espacio}}"></td>
    </tr>
</table>

<table style="font-size:12px;" width="100%">
    <tr>
        <td colspan="2">
            @php($convertir = new Convertidor)
            {{ $convertir->ConvertirALetras($total) }}
        </td>
        <td>Total:</td>
        <td class="right"> {{f_num::get($total)}} </td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td colspan="4" height="40"> </td>
    </tr>
</table>

<table style="font-size:12px;">
    <tr>
        <td colspan="4" height="50"></td>
    </tr>
    <tr>
        <td colspan="4">
            Cliente: {{ $venta->cliente->nombre }}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Nit: {{ $venta->cliente->nit }}
         </td>
    </tr>
    <tr>
        <td colspan="4"> Direccion: {{ $venta->cliente->direccion }} </td>
    </tr>
    <tr>
        <td colspan="4" height="20"></td>
    </tr>
</table>

<table width="100%" style="font-size:12px;">
    <tr style="text-align:center;">
        <td width="8%"></td>
        <td width="72%"></td>
        <td width="10%"></td>
        <td width="10%"><?php $total = 0;  $espacio = 210; ?></td>
    </tr>
    <tbody>
        @foreach($venta->detalle_venta as $key => $dt)
            <tr>
                <td>  {{ $dt->cantidad }} </td>
                <td>  {{ $dt->producto->descripcion}} {{ $dt->producto->marca->nombre}} </td>
                <td class="right"> {{ f_num::get($dt->precio) }} </td>
                <td class="right">
                    {{ f_num::get($dt->cantidad * $dt->precio)}}
                    <?php
                        $total = $total +($dt->cantidad * $dt->precio);
                        $espacio = $espacio - 15;
                    ?>
                </td>
            </tr>
        @endforeach
    </tbody>
    <tr>
        <td colspan="4" height="{{$espacio}}"></td>
    </tr>
</table>

<table style="font-size:12px;" width="100%">
    <tr>
        <td colspan="2"> {{ $convertir->ConvertirALetras($total) }} </td>
        <td>Total:</td>
        <td class="right"> {{f_num::get($total)}} </td>
    </tr>
</table>

<style media="screen">
    .right {
        text-align: right;
    }
</style>

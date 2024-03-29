<table style="font-size:12px;">
    <tr>
        <td colspan="4" height="60"></td>
    </tr>
    <tr>
        <td colspan="4">
            Cliente: {{ $venta->cliente->nombre }}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Nit: {{ $venta->cliente->nit }}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Fecha: {{ Carbon::now() }}
         </td>
    </tr>
    <tr>
        <td colspan="4"> Direccion: {{ $venta->cliente->direccion }} </td>
    </tr>
    <tr>
        <td colspan="4" height="15"></td>
    </tr>
</table>

<table width="100%" style="font-size:12px;">
    <tr style="text-align:center;">
        <td width="8%"></td>
        <td width="72%"></td>
        <td width="10%"></td>
        <td width="10%"><?php $total = 0;  $espacio = 165; ?></td>
    </tr>
    <tbody>
        @foreach($venta->detalle_venta as $key => $dt)
            <tr>
                <td>  {{ $dt->cantidad }} </td>
                <td>  {{ $dt->producto->descripcion }} {{ $dt->producto->marca->nombre }} </td>
                <td class="right">{{ number_format($dt->precio + $dt->precio * $porsentaje, 4) }}</td>
                <td class="right">
                    {{ number_format($dt->cantidad * ($dt->precio + $dt->precio * $porsentaje), 2) }}
                    <?php
                        $total = $total + ($dt->cantidad * $dt->precio);
                        $espacio = $espacio - 13;
                    ?>
                </td>
            </tr>
        @endforeach

        <?php
            $total = $total + $recargo;
        ?>
    </tbody>
    <tr>
        <td colspan="4" height="{{ $espacio }}"></td>
    </tr>
</table>

<table style="font-size:12px;" width="100%">
    <tr>
        <td colspan="2">
            @php($convertir = new Convertidor)
            {{ $convertir->ConvertirALetras($total) }}
        </td>
        <td>Total:</td>
        <td class="right"> {{ number_format($total, 2) }} </td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td colspan="4" height="65"> </td>
    </tr>
</table>

<table style="font-size:12px;">
    <tr>
        <td colspan="4" height="70"></td>
    </tr>
    <tr>
        <td colspan="4">
            Cliente: {{ $venta->cliente->nombre }}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Nit: {{ $venta->cliente->nit }}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Fecha: {{ Carbon::now() }}
         </td>
    </tr>
    <tr>
        <td colspan="4"> Direccion: {{ $venta->cliente->direccion }} </td>
    </tr>
    <tr>
        <td colspan="4" height="10"></td>
    </tr>
</table>

<table width="100%" style="font-size:12px;">
    <tr style="text-align:center;">
        <td width="8%"></td>
        <td width="72%"></td>
        <td width="10%"></td>
        <td width="10%"><?php $total = 0;  $espacio = 170; ?></td>
    </tr>
    <tbody>
        @foreach($venta->detalle_venta as $key => $dt)
            <tr>
                <td>  {{ $dt->cantidad }} </td>
                <td>  {{ $dt->producto->descripcion }} {{ $dt->producto->marca->nombre }} </td>
                <td class="right">{{ number_format($dt->precio + $dt->precio * $porsentaje, 4) }}</td>
                <td class="right">
                    {{ number_format($dt->cantidad * ($dt->precio + $dt->precio * $porsentaje), 2) }}
                    <?php
                        $total = $total + ($dt->cantidad * $dt->precio);
                        $espacio = $espacio - 13;
                    ?>
                </td>
            </tr>
        @endforeach

        <?php
            $total = $total + $recargo;
        ?>
    </tbody>
    <tr>
        <td colspan="4" height="{{$espacio}}"></td>
    </tr>
</table>

<table style="font-size:12px;" width="100%">
    <tr>
        <td colspan="2"> {{ $convertir->ConvertirALetras($total) }} </td>
        <td>Total:</td>
        <td class="right"> {{ number_format($total, 2) }} </td>
    </tr>
</table>

<style media="screen">
    .right {
        text-align: right;
        padding-right: 15px;
    }
</style>

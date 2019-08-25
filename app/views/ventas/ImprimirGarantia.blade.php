<div class="Garantia">
    <table style="font-size:12px">
        <tr>
            <td> <img src="images/logo.jpg" width="100"  height="85"/> </td>
        </tr>
        <tr>
            <td colspan="4"> {{ $tienda->direccion }}  Telefono: {{ $tienda->telefono }} </td>
        </tr>
        <tr>
            <td colspan="4"> Fecha: {{ @$venta->created_at }} Garantia No. : {{ @$venta->id }}</td>
        </tr>
        <tr>
            <td colspan="4"> Direccion: {{ @$venta->cliente->direccion.' ' }}  Nit: {{ ' '.@$venta->cliente->nit }} </td>
        </tr>
        <tr>
            <td colspan="4"> Nombre: {{ @$venta->cliente->nombre.' '.@$venta->cliente->apellido }}</td>
        </tr>

    </table>
    <div style="height:650px;">
        <table width="100%" style="font-size:11px;">
            <tr style="text-align:center;">
                <td width="8%">Cantidad</td>
                <td width="72%">Descripcion</td>
                <td width="10%">Precio</td>
                <td width="10%">Totales</td>
            </tr>

            @php($total = 0)
            @php($serials = "")

            @foreach($venta->detalle_venta as $key => $dt)
                <tr>
                    <td>  {{ $dt->cantidad }} </td>
                    <td>  {{ $dt->producto->descripcion}} {{ $dt->producto->marca->nombre}} </td>
                    <td align="right">{{ number_format($dt->precio + $dt->precio * $porsentaje, 4) }}</td>
                    <td align="right">{{ number_format($dt->cantidad * ($dt->precio + $dt->precio * $porsentaje), 2) }}</td>
                </tr>
                @if ($dt->serials != null)
                <tr>
                    <td></td>
                    <td align="justify"><strong>S/N:</strong> {{ str_replace(',',', ',$dt->serials) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                @endif
                @php($total = $total + ($dt->cantidad * $dt->precio))
            @endforeach
            <?php
                $total = $total + $recargo;
            ?>
            <tr>
                <td colspan="2"></td>
                <td>Total:</td>
                <td align="right"> {{number_format($total, 2)}} </td>
            </tr>
        </table>
    </div>
    <div style="font-size:9px">
        <p align="justify" colspan="4">
        </p>
    </div><br>
    <table width="100%">
        <tr>
            <td align="center" colspan="2">________________________</td>
            <td align="center" colspan="2">________________________</td>
        </tr>
        <tr>
            <td align="center"  colspan="2">Firma del vendedor</td>
            <td align="center"  colspan="2">Sello</td>
        </tr>
    </table>
</div>

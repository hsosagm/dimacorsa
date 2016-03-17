<div class="Garantia">
    <table style="font-size:12px">
        <tr>
            <td> <img src="images/logo.jpg" width="125"  height="90"/> </td>
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
    <div style="height:550px;">
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
                    <td align="right"> {{ f_num::get($dt->precio) }} </td>
                    <td align="right"> {{ f_num::get($dt->cantidad * $dt->precio)}} </td>
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
            <tr>
                <td colspan="2"></td>
                <td>Total:</td>
                <td align="right"> {{f_num::get($total)}} </td>
            </tr>
        </table>
    </div>
    <div style="font-size:9px">
        <p align="justify" colspan="4">
            IMPORTANTE:  {{ $tienda->nombre }}, garantiza este producto en todos sus componentes funcionales  y mano de obra contra cualquier defecto de fabricación a partir de  la fecha de entrega, de acuerdo con las siguientes condiciones. VIGENCIAS:  Computadoras portátiles y de mesa, monitores, ups y respaldos de energía (excluye cargador y batería en portátiles y fuente de poder en desktops): 1 año.    Cargador, batería y fuente de poder 3 meses.   Sistemas de audio, Bocinas, Cámaras Digitales. 6 meses.    Accesorios, impresoras, ratones, teclados, audífonos, unidades de almacenamiento internas y externas, unidades ópticas, lectores de medios y cables de todo tipo 3 meses.CONDICIONES: 1.Para hacer efectiva esta garantía, deberán presentar el producto al lugar donde fue adquirido junto con una copia de su garantía proporcionada por la empresa. 2.El tiempo de reparación en ningún caso será mayor de 15 días habiles contados a partir de la fecha de recepción del producto por parte  de {{ $tienda->nombre }}.  3.Favor de Leer Cuidadosamente las Instrucciones de Uso é Instalación del fabricante, antes de encender el equipo, así como los Términos de la Presente Póliza. Su garantia perdera validez en los siguientes casos: 1.Cuando el producto ha sido utilizado en condiciones distintas a las indicadas en sus especificaciones ambientales.  2.Cuando el producto no ha sido operado de acuerdo con el manual de uso proporcionado.  3.Cuando el producto haya sufrido daños por sobrecarga eléctrica, daños físicos, daños accidentales, derrame de líquidos o cualquier otro tipo de mal uso por parte del consumidor. 4.Cuando el producto ha sido alterado ó reparado por personas  no autorizadas por la empresa. 5.Si el sello de garantía ha sido removido o alterado por personal ajeno a la empresa.  6.La Garantía NO cubre desgaste normal de la unidad o mantenimientos Preventivos.  7.Esta garantía no cubre el software instalado en computadoras, por lo que el Cliente acepta completa responsabilidad por su software y datos, incluyendo la responsabilidad de tener sus respaldos (copia de seguridad). 8.La reparación o reemplazo de un producto durante la garantía, no extenderá el término original  de la  garantía.
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

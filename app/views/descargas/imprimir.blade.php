<div width="Impresiones">
    <div width="ImpresionesBody">
        <h1> Constancia de Descarga : {{ $descarga->id }} </h1>
        <table width="100%" class="table table-condensed">
            <tr>
                <th width="15%">Cantidad</th>
                <th width="55%">Descripcion</th>
                <th width="15%">Precio</th>
                <th width="15%">Total</th>
            </tr>
            <?php $total = 0; ?>
            @foreach($descarga->detalle_descarga as $key => $dt)
            <tr height="1"  style="font-size:12px; ">
                <td width="15%"> {{ $dt->cantidad }} </td>   
                <td width="55%"> {{ $dt->producto->descripcion}} </td>
                <td width="15%" style="text-align:right; padding-right:15px">{{ f_num::get($dt->precio) }} </td>
                <td width="15%" style="text-align:right; padding-right:15px">{{ f_num::get($dt->cantidad * $dt->precio)}} </td>   
            </tr>
            <?php $total = $total +($dt->cantidad * $dt->precio); ?>
            @endforeach
            <tfoot height="15">
                <tr>
                    <td style="font-size:12px; " colspan="3"> Total: </td>
                    <td style="text-align:right; padding-right:15px"> {{f_num::get($total)}} </td>
                </tr>
            </tfoot>
        </table>
        <br><br>
        <table width="100%" class="table table-bordered">
            <tr>
                <td width="33%" align="center"> Usuario :  </td>
                <td width="33%" align="center"> Fecha de  creacion : </td>
                <td width="33%" align="center"> Fecha de impresion : </td>
            </tr>
            <tr>
                <td width="33%" align="center"> {{ Auth::user()->nombre .' '.Auth::user()->apellido }} </td>
                <td width="33%" align="center"> {{ $descarga->created_at }}</td>
                <td width="33%" align="center"> {{ date('Y-m-d h:i:s')}} </td>
            </tr>
        </table>
        <br>
        Nota:
        <table width="100%" class="table table-bordered">
            <tr> <td width="100%">{{ $descarga->descripcion }}</td>  </tr>
            <tr> <td width="100%">-</td> </tr>
            <tr> <td width="100%">-</td> </tr>
        </table>
    </div>
</div>
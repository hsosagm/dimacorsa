<div align="center">
    <h1> Constancia de Descarga : {{ $descarga->id }} </h1>
    <table width="100%" class="table">
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
    <br> <br>
    <div>
        <table width="100%">
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
    </div>
    <br>
    <div align="left">
        Nota:
        <table width="100%" class="table nota">
            <tr> <td width="100%">{{ $descarga->descripcion }}</td>  </tr>
            <tr> <td width="100%">-</td> </tr>
            <tr> <td width="100%">-</td> </tr>
        </table>
    </div>
</div>
 
<style>
    .table .nota tr td{ padding: 25px !important; }

    .table {
        border-spacing: 0;
        margin-top:25px;
    }

    .table {
        color:#666;
        font-size:12px;
        background:#eaebec;
        border:#ccc 1px solid;
    }

    .table tr th {
        padding:10px 25px 11px 25px !important;
        background: #fafafa;
        text-align: center !important;
        border-bottom:1px solid #e0e0e0 !important;
    }

    .table tr td {
        padding:10px !important;
        border-bottom:1px solid #e0e0e0 !important;
        border-left: 1px solid #e0e0e0 !important;
        background: #fafafa;
    }
  
    .table tr:last-child td{
        border-bottom:0;
    }
</style>
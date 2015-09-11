<?php 
    $brtdTop = "border-top:1px solid #444444;";
    $brtdBottom = "border-bottom:1px solid #444444; ";
    $brtdBT = "border-bottom:1px solid #444444; border-top:1px solid #444444; ";
 ?>

   <div align="center"> 
        <h2> Constancia de Traslado </h2>
   </div>
   <br>
	<table style="width:100%">
        <tr>
            <td width="15%" align="center" style="{{$brtdTop}}"> Origen :  </td>
            <td width="85%" style="{{$brtdTop}}"> {{ $tienda['origen']}} </td>
        </tr>
        <tr>
            <td style="{{$brtdBottom}}" width="15%" align="center"> Destino: </td>
            <td style="{{$brtdBottom}}" width="85%"> {{ $tienda['destino']}} </td>
        </tr>
    </table>
<br>
<br>
    <table style="width:100%">
        <tr>
            <th width="15%" style="{{$brtdBT}}">Cantidad</th>
            <th width="55%" style="{{$brtdBT}}">Descripcion</th>
            <th width="15%" style="{{$brtdBT}}">Precio</th>
            <th width="15%" style="{{$brtdBT}}">Total</th>
        </tr>
        <?php $total = 0; ?>
        @foreach($traslado->detalle_traslado as $key => $dt)
        <tr style="font-size:12px; ">
            <td width="15%"> {{ $dt->cantidad }} </td>   
            <td width="55%"> {{ $dt->producto->descripcion}} </td>
            <td width="15%" style="text-align:right; padding-right:15px">{{ f_num::get($dt->precio) }} </td>
            <td width="15%" style="text-align:right; padding-right:15px">{{ f_num::get($dt->cantidad * $dt->precio)}} </td>   
        </tr>
        <?php $total = $total +($dt->cantidad * $dt->precio); ?>
        @endforeach
        <tfoot height="15">
            <tr>
                <td style="font-size:12px;{{$brtdTop}} " colspan="3"> Total: </td>
                <td style="text-align:right; padding-right:15px; {{$brtdTop}}"> {{f_num::get($total)}} </td>
            </tr>
        </tfoot>
    </table>
    <br><br>
    <table style="width:100%">
        <tr style="{{$brtdTop}}">
            <td width="33%" align="center" style="{{$brtdBT}}"> Usuario :  </td>
            <td width="33%" align="center" style="{{$brtdBT}}"> Fecha de  creacion : </td>
            <td width="33%" align="center" style="{{$brtdBT}}"> Fecha de impresion : </td>
        </tr>
        <tr>
            <td width="33%" align="center"> {{ Auth::user()->nombre .' '.Auth::user()->apellido }} </td>
            <td width="33%" align="center"> {{ $traslado->created_at }}</td>
            <td width="33%" align="center"> {{ date('Y-m-d h:i:s')}} </td>
        </tr>
    </table>
    <br>
    Nota:
    <table style="width:100%;">
        <tr> <td width="100%" style="{{$brtdBT}}">-{{ $traslado->nota }}</td>  </tr>
        <tr> <td width="100%" style="{{$brtdBottom}}">-</td> </tr>
    </table>

<table width="100%" style="font-size:13px">
    <tr>
        <td colspan="3" width="75%"> <img src="images/logo.jpg" width="150"  height="90"/> </td>
        <td  align="left" style="font-size:12px;"> 
            <p>
                Cotizacion No:  {{ $cotizacion->id }}  <br>
                Fecha : {{ $cotizacion->created_at }}
            </p>
        </td>
    </tr>
	<tr>
		<td colspan="4" align="center"> <strong>Señor(a) :</strong>  {{ $cotizacion->cliente->nombre }} </td>
	</tr>
    <tr>
		<td colspan="4" align="center"> <strong>Direccion :</strong> {{ $cotizacion->cliente->direccion }} </td>
	</tr>
	<tr>
		<td colspan="4" align="center"> <strong>Telefono :</strong> {{ $cotizacion->cliente->telefono }} </td>
	</tr>
    <tr>
        <td colspan="4" align="center"> <strong>Nit :</strong> {{ $cotizacion->cliente->nit }} </td>
    </tr>
    <tr>
        <td colspan="4" align="center"></td>
    </tr>
     <tr>
        <td colspan="4" align="center"> <p style="margin-left:75px; margin-right:75px; font-size:14px"><strong>Estimados señores</strong><br>  Deseandole toda clase de exitos en sus labores diarias, es para nosotros un gusto poder brindarle la propuesta economica de los siguientes productos. </p> </td>
    </tr>
</table>

<br>
<div style="height:485px; font-size:13px">
    <table width="100%">
        <tr style="background:rgba(199, 199, 199, 0.21);">
    		<td colspan="4" style="border-bottom:1px solid #444444; "></td>
    	</tr>
        <tr style="background:rgba(199, 199, 199, 0.21);">
            <td style="text-align:center;" >Cantidad</td>
            <td style="text-align:center;" >Descripcion</td>
            <td style="text-align:center;" >Precio</td>
            <td style="text-align:center;" >Total</td>
        </tr>
        <tr style="background:rgba(199, 199, 199, 0.21);">
    		<td colspan="4" style="border-bottom:1px solid #444444; "></td>
    	</tr> <?php $i = 0; $total = 0; ?>

        @foreach($cotizacion->detalle_cotizacion as $dt)

        <tr style="{{($i == 1)?'background-color: #ECECEC;':'background-color: #FFFFFF;'}}">
            <td> {{ $dt->cantidad }} </td>
            <td> {{ $dt->descripcion }} </td>
            <td style="text-align:right;"> {{ $dt->precio }} <?php $total += $dt->cantidad * $dt->precio; ?></td>
            <td style="text-align:right;"> {{ f_num::get($dt->cantidad * $dt->precio) }} <?php ($i == 0)? $i=1:$i=0; ?> </td>
        </tr>

        @endforeach
        <tr>
    		<td colspan="4" style="border-bottom:1px solid #444444; "></td>
    	</tr>
        <tr>
    		<td colspan="4" style="border-bottom:1px solid #444444; "></td>
    	</tr>
        <tr>
            <td>  </td>
            <td> </td>
            <td style="text-align:right;"> Total: </td>
            <td style="text-align:right;"> {{ f_num::get($total) }} </td>
        </tr>
        <tr>
    		<td colspan="4" style="border-bottom:1px solid #444444; "></td>
    	</tr>
        <br>
		<tr>
			<td colspan="4" align="center">
                - Cotización valida por 10 días, precios sujetos a cambio sin previo aviso, sujeto a disponibilidad de producto -
            </td>
    	</tr>
         
    </table>
</div>
<table width="100%" style="font-size:13px">
    {{--@if(file_exists("images/firmas/".Auth::user()->id.".png"))
        <tr>
            <td width="30%"></td>
            <td align="center" style="height: 100px; border-bottom:1px solid #444444;" width="40%">
                    <img src="images/firmas/{{Auth::user()->id}}.png" height="125" /> 
            </td>
            <td align="center">
                    <img src="images/firmas/sello.png" height="125"/>
            </td>
        </tr>
    @else   --}}
        <tr>
            <td colspan="4" style="height: 100px;"></td>
        </tr>
        <tr>
            <td colspan="4" align="center">_____________________________________________</td>
        </tr>
   {{-- @endif --}}
    <tr>
        <td colspan="4" align="center"> {{ Auth::user()->nombre.' '.Auth::user()->apellido.', '.Auth::user()->puesto->descripcion.', Correo: '.Auth::user()->email }} </td>
    </tr>
    <tr>
        <td colspan="4" style="text-align:center">
            - {{ $tienda->direccion }} Telefono: {{ $tienda->telefono }} - <br>
           
        </td>
    </tr>
</table
 
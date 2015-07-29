<html>

	<table style="font-weight: 100 !important; font-size:9pt; font-face:\'Courier New\';">

		<tr height="25"> 
			<td colspan="2"> Nit: {{$venta->cliente->nit}}  Fecha : {{ date('d-m-Y')}} </td>
		</tr >

		<tr height="25"> 
			<td colspan="4"> 
				{{ $venta->cliente->nombre .' '.$venta->cliente->apellido}}
				{{ $venta->cliente->direccion}}
			</td>
		</tr>
	</table>

	<table style="display: block; height: 200px; padding-top: 10px; padding-bottom: 70px; font-weight: 100 !important; font-size:9pt; font-face:\'Courier New\';">
	    <?php $total = 0; ?>

		@foreach($venta->detalle_venta as $key => $dt)
		    <tr>
		        <td valign="top" width="50"> {{ $dt->cantidad }} </td>
		        <td valign="top" width="375"> {{ $dt->producto->descripcion }} </td>
				<td valign="top" width="65" align="right"> {{ f_num::get($dt->precio) }} </td>
				<td valign="top" width="65" align="right"> {{ f_num::get($dt->cantidad * $dt->precio)}} </td>
		    </tr>
		@endforeach
	</table>

	<table style="font-weight: 100 !important; font-size:9pt; font-face:\'Courier New\';">
		<tr>
			<td width="60"></td>	
			<td width="430">Veintiseis mil seiscientos cincuenta y cinco quetzales con 15/100 centavos</td>
			<td width="65" align="right">90,909.99</td>
		</tr>
	</table>

</html>
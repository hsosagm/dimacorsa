<html>

<head>
	<style type="text/css">

		body
		{
			margin-top: 35px;
			margin-left: 10px;
		}

	</style>
</head>

	<table style="font-weight: 100 !important; font-size:9pt; font-face:\'Courier New\';">

		<tr height="25"> 
			<td colspan="2"> Nits: {{$venta->cliente->nit}}  Fecha : {{ date('d-m-Y')}} </td>
		</tr >

		<tr height="25"> 
			<td colspan="4"> 
				{{ $venta->cliente->nombre .' '.$venta->cliente->apellido}}
				{{ $venta->cliente->direccion}}
			</td>
		</tr>
	</table>

<div style="display: block; height: 200px; padding-top: 10px; padding-bottom: 35px; width:555px;">
	<table style="font-weight: 100 !important; font-size:9pt; font-face:\'Courier New\';">
	    <?php $total = 0; ?>

		@foreach($venta->detalle_venta as $key => $dt)
		    <tr>
		        <td valign="top" width="30"> {{ $dt->cantidad }} </td>
		        <td valign="top" width="385"> {{ $dt->producto->descripcion }} </td>
				<td valign="top" width="70" align="right"> {{ f_num::get($dt->precio) }} </td>
				<td valign="top" width="70" align="right"> {{ f_num::get($dt->cantidad * $dt->precio)}} </td>
		    </tr>
		@endforeach
	</table>
</div>

	<table style="font-weight: 100 !important; font-size:9pt; font-face:\'Courier New\';">
		<tr>
			<td width="65"></td>	
			<td width="425">Veintiseis mil seiscientos cincuenta y cinco quetzales con 15/100 centavos</td>
			<td width="65" align="right">90,909.99</td>
		</tr>
	</table>

</html>
<html>
<head>
	<style type="text/css">

		body
		{
			margin-top: 35px;
			margin-left: 10px;
		}

		body, td
		{
			font-size: 9pt;
			font-family: "monospace";
		}

		#factura_detalle {
			display: block;
			height: 200px;
			padding-top: 10px;
			padding-bottom: 70px;
		}
	</style>
</head>
<body>

	<table>
		<tr height="25"> 
			<td colspan="2">
				Nit: {{$venta->cliente->nit}}  Fecha : {{ date('d-m-Y')}}
			</td>
		</tr >
		<tr height="25"> 
			<td colspan="4"> 
				{{ $venta->cliente->nombre .' '.$venta->cliente->apellido}}
				{{ $venta->cliente->direccion}}
			</td>
		</tr>
	</table>

	<div id="factura_detalle">
		<table face="monospace" border="1px">
			<tbody>
				<?php $total = 0; ?>
				@foreach($venta->detalle_venta as $key => $dt)
				<tr height="3cm">
					<td valign="top" width="50">  {{ $dt->cantidad }} </td>


				    <?php $descripcion = str_replace(" ", "&nbsp;", $dt->producto->descripcion); ?>
				    <?php $descripcion = str_replace("’", "'", $descripcion); ?>
				    <?php $descripcion = str_replace("-", "&#8209;", $descripcion); ?>

					<td valign="top" width="375"> {{ $descripcion }} </td>
					<td valign="top" width="65" align="right">
						{{ f_num::get($dt->precio) }}
					</td>
					<td valign="top" width="65" align="right">
						{{ f_num::get($dt->cantidad * $dt->precio)}}
					</td>	
				</tr>
				<?php $total = $total +($dt->cantidad * $dt->precio); ?>
				@endforeach
			</tbody>
		</table>
	</div>

	<table>
		<tr>
			<td width="60"></td>	
			<td width="430">Veintiseis mil seiscientos cincuenta y cinco quetzales con 15/100 centavos</td>
			<td width="65" align="right">90,909.99</td>
		</tr>
	</table>

</body>
</html>
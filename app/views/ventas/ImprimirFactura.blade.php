<html>
	<head>
		<style type="text/css">
			body, td
			{
				font-size: 9pt;
				margin: 0px;
				font-family: "monospace";
			}

			#factura_detalle {
				display: block;
				height: 180px;
				padding-top: 20px;
				padding-bottom: 20px;
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
		<table>
			<tbody>
				<?php $total = 0; ?>
				@foreach($venta->detalle_venta as $key => $dt)
				<tr>
					<td>  {{ $dt->cantidad }} </td>	
					<td> {{ $dt->producto->descripcion}} </td>
					<td align="right">
						{{ f_num::get($dt->precio) }}
					</td>
					<td align="right">
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
			<td>Veintiseis mil seiscientos cincuenta y cinco quetzales con 15/100 centavos</td>
			<td align="right">90909</td>
		</tr>
	</table>

</body>
</html>
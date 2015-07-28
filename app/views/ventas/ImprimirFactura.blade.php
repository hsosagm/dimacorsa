<html>
	<head>
		<style type="text/css">

			body
			{
				margin-top: 20px;
				margin-left: 10px;
			}

			body, td
			{
				font-size: 9pt;
				font-family: "monospace";
			}

			#factura_detalle {
				display: block;
				height: 180px;
				padding-top: 30px;
				padding-bottom: 30px;
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
					<td width="50">  {{ $dt->cantidad }} </td>	
					<td width="600"> {{ $dt->producto->descripcion}} </td>
					<td width="100" align="right">
						{{ f_num::get($dt->precio) }}
					</td>
					<td width="100" align="right">
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
			<td width="750">Veintiseis mil seiscientos cincuenta y cinco quetzales con 15/100 centavos</td>
			<td width="100" align="right">90,909.99</td>
		</tr>
	</table>

</body>
</html>
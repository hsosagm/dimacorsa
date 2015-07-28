<html>
<head>
	<style type="text/css">
		body, td
		{
			font-family: Consolas, "Andale Mono", "Lucida Console", "Lucida Sans Typewriter", Monaco, "Courier New", monospace;
			font-size: 9pt;
		}

		tbody {
		    display:block;
		    height:275px;
		}
	</style>
</head>
<body>

	<table>

	    <thead>
			<tr height="35"></tr>
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
			<tr height="35"></tr>
		</thead>

		<tbody>
			<?php $total = 0; ?>
			@foreach($venta->detalle_venta as $key => $dt)
				<tr>
					<td>  {{ $dt->cantidad }} </td>	
					<td> {{ $dt->producto->descripcion}} </td>
					<td style="text-align:right">
						{{ f_num::get($dt->precio) }}
					</td>
					<td style="text-align:right">
						{{ f_num::get($dt->cantidad * $dt->precio)}}
					</td>	
				</tr>
				<?php $total = $total +($dt->cantidad * $dt->precio); ?>
			@endforeach
		</tbody>

		<tfoot>
			<tr>
				<td colspan="3">Veintiseis mil seiscientos cincuenta y cinco quetzales con 15/100 centavos</td>
				<td>90909</td>
			</tr>
		</tfoot>

	</table>
</body>
</html>
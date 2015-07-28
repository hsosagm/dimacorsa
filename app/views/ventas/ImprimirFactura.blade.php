<body>
	<div width="750">
		<table border="0" width="750" style="font-family: Lucida Sans Typewriter,Lucida Typewriter,monospace , bold; font-size: 12px !important; font-variant: normal;font-weight: 500;" >
			<thead valign="top" style="height:115px !important;" >
				<tr height="35" > 
					<td width="5%"></td> 
					<td width="65%"></td> 
					<td width="15%"></td> 
					<td width="15%"></td>
				</tr>
				<tr height="25" > 
					<td colspan="2">
						Nit: {{$venta->cliente->nit}} &nbsp;&nbsp;&nbsp;&nbsp; Fecha : {{ date('d-m-Y')}}
					</td>
					<td colspan="2"> </td>
				</tr >
				<tr height="25"> 
					<td colspan="4" width="100%"> 
						{{ $venta->cliente->nombre .' '.$venta->cliente->apellido}} &nbsp;&nbsp;&nbsp;&nbsp;
						{{ $venta->cliente->direccion}}
					</td>
				</tr>
				<tr height="30" > 
					<td colspan="4"> </td>
				</tr>
			</thead>
			<tbody style="height:275px !important;">
				<?php $total = 0; ?>
				@foreach($venta->detalle_venta as $key => $dt)
					<tr height="1">
						<td>  {{ $dt->cantidad }} </td>	
						<td> {{ $dt->producto->descripcion}} </td>
						<td style="text-align:right; padding-right:15px">
							{{ f_num::get($dt->precio) }}
						</td>
						<td style="text-align:right; padding-right:15px">
							{{ f_num::get($dt->cantidad * $dt->precio)}}
						</td>	
					</tr>
					<?php $total = $total +($dt->cantidad * $dt->precio); ?>
				@endforeach
				<tr>
					<td colspan="4" style="height:100% !important;"> </td>	
				</tr>
			</tbody>
			<tfoot height="15">
				<tr>
					<td style="padding-left: 116px; " colspan="3">
						<?php $convertir =new Convertidor;?> 
						{{$convertir->ConvertirALetras($total);}}
					</td>
					<td style="text-align:right; padding-right:15px"> Q {{f_num::get($total)}}</td>
				</tr>
			</tfoot>
		</table>	
	</div>
</body>
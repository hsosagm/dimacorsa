

		<table border="0" width="750" style="padding-right:15px; font-size: 7px">
			<thead>
				<tr height="35" > 
					<td width="5%"></td> 
					<td width="65%"></td> 
					<td width="15%"></td> 
					<td width="15%"></td>
				</tr>
				<tr height="25" > 
					<td colspan="2">
						Nit: {{$venta->cliente->nit}}  Fecha : {{ date('d-m-Y')}}
					</td>
					<td colspan="2"> </td>
				</tr >
				<tr height="25"> 
					<td colspan="4" width="100%"> 
						{{ $venta->cliente->nombre .' '.$venta->cliente->apellido}}
						{{ $venta->cliente->direccion}}
					</td>
				</tr>
				<tr height="30" > 
					<td colspan="4"> </td>
				</tr>
			</thead>
			<tbody style="height:275px;">
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
				<tr>
					<td colspan="4" style="height:100%;"> </td>	
				</tr>
			</tbody>
			<tfoot height="15">
				<tr>
					<td colspan="3">
						<?php $convertir =new Convertidor;?> 
						{{$convertir->ConvertirALetras($total);}}
					</td>
					<td>90909</td>
				</tr>
			</tfoot>
		</table>	


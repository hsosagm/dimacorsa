
<body>
	<div align="center">
		<div class="" width="750" height="" >
			<table border="0" width="750" id="table">

				<tbody height="390"  valign="top" style="font-size:13px;  height:340 !important;" >
					<tr height="35" > 
						<td width="70%"> </td>
						<td width="15%"></td>
						<td width="15%"></td>
					</tr >
					<tr height="25" > 
						<td width="70%">Nit: {{$venta->cliente->nit}} &nbsp;&nbsp;&nbsp;&nbsp; Fecha : {{ date('d-m-Y')}}</td>
						<td width="15%"></td>
						<td width="15%"></td>
					</tr >
					<tr height="25"> 
						<td colspan="3" width="100%"> 
							{{ $venta->cliente->nombre .' '.$venta->cliente->apellido}} &nbsp;&nbsp;&nbsp;&nbsp;
							{{ $venta->cliente->direccion}}
						</td>
					</tr>
					<tr height="30" > 
						<td width="70%"> </td>
						<td width="15%"></td>
						<td width="15%"></td>
					</tr >
					<tr>
						<td colspan="3" width="100%">
							<div style="height:300 !important; ">
								<table width="100%"	>
									<?php $total = 0; ?>
									@foreach($venta->detalle_venta as $key => $dt)
									<tr height="1"  style="font-size:12px; ">
										<td width="15%"> 
											{{ $dt->cantidad }}
										</td>	
										<td width="55%"> 
											{{ $dt->producto->descripcion}}
										</td>
										<td width="15%" style="text-align:right; padding-right:15px">
											{{ f_num::get($dt->precio) }}
										</td>
										<td width="15%" style="text-align:right; padding-right:15px">
											{{ f_num::get($dt->cantidad * $dt->precio)}}
										</td>	
									</tr>
									<?php $total = $total +($dt->cantidad * $dt->precio); ?>
									@endforeach
									<tr>
										<td colspan="4"><div style="height:100% !important;"></div></td>	
									</tr>
								</table>
							</div>
						</td>
					</tr>
				</tbody>


				<tfoot height="15">
					<tr>
						<td style="font-size:12px; " colspan="2">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<?php 
							$convertir =new Convertidor;
							echo $convertir->ConvertirALetras($total);
							?>
						</td>
						<td style="text-align:right; padding-right:15px"> Q {{f_num::get($total)}}</td>
					</tr>
				</tfoot>
			</table>	

		</div>
	</div>
</body>
<style>

	td {
		font-family: Lucida Sans Typewriter,Lucida Typewriter,monospace , bold;
		font-size: 13px !important;
		font-variant: normal;
		font-weight: 500;
	}
</style>
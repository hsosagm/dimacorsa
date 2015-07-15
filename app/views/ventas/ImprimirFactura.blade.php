<?php $factura = 0 ?>
<?php $factura_pie = 1 ?>
<?php $lineas = 0; ?>
<body>
	@foreach($venta->detalle_venta as $key => $dt)

		@if($factura == 0)
			@include('ventas.EncabezadoFactura')
			<?php $factura = 1; ?>
			<?php $total = 0; ?>
		@endif

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

		@if(strlen ($dt->producto->descripcion) > 50)
			<?php $lineas = $lineas + 2; ?>
		@else
			<?php $lineas++; ?>
		@endif

		@if($lineas >= 16 )
			<?php $factura_pie   = 0 ; ?>
			<?php $factura       = 0 ; ?>
			<?php $lineas = 0; ?>
		@endif
		
		@if($factura_pie == 0)
			@include('ventas.PieFactura')
			<?php $factura_pie = 1 ; ?>
		@endif
		
	@endforeach
	
	@include('ventas.PieFactura')
</body>
<style>

	td {
		font-family: Lucida Sans Typewriter,Lucida Typewriter,monospace , bold;
		font-size: 13px !important;
		font-variant: normal;
		font-weight: 500;
	}
</style>
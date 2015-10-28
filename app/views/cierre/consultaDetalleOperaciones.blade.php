@if(count($dataDetalle[$metodoDePago]['pagosVentas']) || count($dataDetalle[$metodoDePago]['abonosVentas']) || count($dataDetalle[$metodoDePago]['pagosCompras']) || count($dataDetalle[$metodoDePago]['abonosCompras']) || count($dataDetalle[$metodoDePago]['soporte']) || count($dataDetalle[$metodoDePago]['ingresos']) || count($dataDetalle[$metodoDePago]['gastos']) || count($dataDetalle[$metodoDePago]['egresos']))
<div style="border-bottom:solid 1px #000000">
<h5> <strong>&nbsp;&nbsp;&nbsp;{{ ucfirst($metodoDePago.'s')}} del dia</strong> </h5>
	<table width="100%" class="">
		<thead>
			<tr class="bg-theme" style="opacity: 0.6;">
				<th width="30%">&nbsp;&nbsp;&nbsp;Usuario</th>
				<th width="40%" style="text-align: center;">Descripcion</th>
				<th width="15%"style="text-align: center;">Monto</th>
				<th width="15%" style="text-align: center;">Tipo</th>
			</tr>
		</thead>
		<tbody>
		@foreach($dataDetalle[$metodoDePago]['pagosVentas'] as $pv)
			<tr>
				<td> {{ $pv->venta->user->nombre.' '.$pv->venta->user->apellido }} </td>
				<td>   </td>
				<td class="right"> {{ f_num::get($pv->monto) }} </td>
				<td> Pagos ventas </td>
			</tr>
			@endforeach
			@foreach($dataDetalle[$metodoDePago]['abonosVentas']as $ac)
			<tr>
				<td> {{ $ac->user->nombre.' '.$ac->user->apellido }} </td>
				<td> {{ $ac->observaciones }} </td>
				<td class="right"> {{ f_num::get($ac->monto) }} </td>
				<td> Abono ventas </td>
			</tr>
			@endforeach
			@foreach($dataDetalle[$metodoDePago]['pagosCompras'] as $pc)
			<tr>
				<td> {{ $pc->compra->user->nombre.' '.$pc->compra->user->apellido }} </td>
				<td>   </td>
				<td class="right"> {{ f_num::get($pc->monto) }} </td>
				<td> Pagos compras </td>
			</tr>
			@endforeach
			@foreach($dataDetalle[$metodoDePago]['abonosCompras']as $ac)
			<tr>
				<td> {{ $ac->user->nombre.' '.$ac->user->apellido }} </td>
				<td> {{ $ac->observaciones }} </td>
				<td class="right"> {{ f_num::get($ac->monto) }} </td>
				<td> Abono compras </td>
			</tr>
			@endforeach
			@foreach($dataDetalle[$metodoDePago]['soporte']as $op)
			<tr>
				<td> {{ $op->soporte->user->nombre.' '.$op->soporte->user->apellido }} </td>
				<td> {{ $op->descripcion }} </td>
				<td class="right"> {{ f_num::get($op->monto) }} </td>
				<td> Soporte </td>
			</tr>
			@endforeach
			@foreach($dataDetalle[$metodoDePago]['ingresos']as $op)
			<tr>
				<td> {{ $op->ingreso->user->nombre.' '.$op->ingreso->user->apellido }} </td>
				<td> {{ $op->descripcion }} </td>
				<td class="right"> {{ f_num::get($op->monto) }} </td>
				<td> Ingresos </td>
			</tr>
			@endforeach
			@foreach($dataDetalle[$metodoDePago]['gastos']as $op)
			<tr>
				<td> {{ $op->gasto->user->nombre.' '.$op->gasto->user->apellido }} </td>
				<td> {{ $op->descripcion }} </td>
				<td class="right"> {{ f_num::get($op->monto) }} </td>
				<td> Gastos </td>
			</tr>
			@endforeach
			@foreach($dataDetalle[$metodoDePago]['egresos']as $op)
			<tr>
				<td> {{ $op->egreso->user->nombre.' '.$op->egreso->user->apellido }} </td>
				<td> {{ $op->descripcion }} </td>
				<td class="right"> {{ f_num::get($op->monto) }} </td>
				<td> Egresos </td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endif

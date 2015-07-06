<table class="DT_table_div" width="100%">

    <tr class="DT_table_div_detail">
        	<td class="center">No. Venta</td>
			<td class="center">Total</td>
			<td class="center">Monto Abonado </td>
			<td class="center">Saldo Anterior</td>
			<td class="center">Nuevo Saldo</td>
    </tr>

	<tbody >
		
		@foreach($detalle as $key => $dt)
		<?php
		        $total = f_num::get($dt->total,2,'.',',');
		        $monto = f_num::get($dt->monto,2,'.',',');
		        
		        $abonos = DetalleAbonosVenta::select(DB::raw('sum(monto) as total'))
		        ->where('venta_id','=',$dt->venta_id)
		        ->where('created_at','<',$dt->fecha)->first();

		        $pagos = PagosVenta::select(DB::raw('sum(monto) as total'))
		        ->where('venta_id','=',$dt->venta_id)
		        ->where('metodo_pago_id','!=', 2)
		        ->where('created_at','<',$dt->fecha)->first();

		        $saldo_ant = $dt->total - ($abonos->total + $pagos->total);
		        $saldo_anterior = f_num::get($saldo_ant ,2,'.',',');
		        $saldo = f_num::get(($saldo_ant - $dt->monto),2,'.',',');
	        ?>
		<tr>
			<td>{{$dt->venta_id}}</td>
			<td class="right">{{$total}}</td>
			<td class="right">{{$monto}}</td>
			<td class="right">{{$saldo_anterior}}</td>
			<td class="right">{{$saldo}}</td>
		</tr>
		@endforeach
	    
	</tbody>

	<tfoot width="100%">

	</tfoot>

</table>
	 	 	 	


<table class="DT_table_div" width="100%">

    <tr class="DT_table_div_detail">
        	<td>No. Compra</td>
			<td>Total</td>
			<td>Monto Abonado </td>
			<td>Saldo Anterior</td>
			<td>Nuevo Saldo</td>
    </tr>

	<tbody >
		
		@foreach($detalle as $key => $dt)
		<?php
		        $total = number_format($dt->total,2,'.',',');
		        $monto = number_format($dt->monto,2,'.',',');
		        
		        $abonos = DetalleAbonosCompra::select(DB::raw('sum(monto) as total'))
		        ->where('compra_id','=',$dt->compra_id)
		        ->where('created_at','<',$dt->fecha)->first();

		        $pagos = PagosCompra::select(DB::raw('sum(monto) as total'))
		        ->where('compra_id','=',$dt->compra_id)
		        ->where('metodo_pago_id','!=', 2)
		        ->where('created_at','<',$dt->fecha)->first();

		        $saldo_ant = $dt->total - ($abonos->total + $pagos->total);
		        $saldo_anterior = number_format($saldo_ant ,2,'.',',');
		        $saldo = number_format(($saldo_ant - $dt->monto),2,'.',',');
	        ?>
		<tr>
			<td>{{$dt->compra_id}}</td>
			<td class="align_right">{{$total}}</td>
			<td class="align_right">{{$monto}}</td>
			<td class="align_right">{{$saldo_anterior}}</td>
			<td class="align_right">{{$saldo}}</td>
		</tr>
		@endforeach
	    
	</tbody>

	<tfoot width="100%">

	</tfoot>

</table>
	 	 	 	


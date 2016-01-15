<table class="DT_table_div" width="100%">

    <tr class="DT_table_div_detail">
        	<td align="center">No. Documento</td>
			<td align="center">Total</td>
			<td align="center">Monto Abonado </td>
			<td align="center">Saldo Anterior</td>
			<td align="center">Nuevo Saldo</td>
    </tr>

	<tbody >
		
		@foreach($detalle as $key => $dt)
		<?php
		        $total = f_num::get($dt->total);
		        $monto = f_num::get($dt->monto);
		        
		        $abonos = DetalleAbonosCompra::select(DB::raw('sum(monto) as total'))
		        ->where('compra_id','=',$dt->compra_id)
		        ->where('created_at','<',$dt->fecha)->first();

		        $pagos = PagosCompra::select(DB::raw('sum(monto) as total'))
		        ->where('compra_id','=',$dt->compra_id)
		        ->where('metodo_pago_id','!=', 2)
		        ->where('created_at','<',$dt->fecha)->first();

		        $saldo_ant = $dt->total - ($abonos->total + $pagos->total);
		        $saldo_anterior = f_num::get($saldo_ant );
		        $saldo = f_num::get(($saldo_ant - $dt->monto));
	        ?>
		<tr>
			<td>{{$dt->numero_documento}}</td>
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
	 	 	 	


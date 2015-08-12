<?php 
	$total_saldo = 0;
	$saldo_vencido = 0;
?>

<div class="rounded shadow">
    <div class="panel_heading">
                <div id="table_length" class="pull-left"></div>
                <div class="DTTT btn-group"></div>
        <div class="pull-right">
            <button v-on="click: closeMainContainer" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="no-padding table">
		<table id="example" class="display" width="100%" cellspacing="0">
		    <thead>
		        <tr>
		            <th>Usuario</th>
		            <th>Fecha</th>
		            <th>Cliente</th>
		            <th>Total</th>
		            <th>Saldo</th>
		            <th>Operaciones</th>
		        </tr>
		    </thead>
			<tbody>
				@foreach($ventas as $q)
				    <?php
				        $saldo = number_format($q->saldo,2,'.',',');
				        $total = number_format($q->total,2,'.',',');
				        $fecha_entrada = $q->fecha;
		                $fecha_entrada = date('Ymd', strtotime($fecha_entrada));
		                $fecha_vencida = date('Ymd',strtotime("-30 days"));
			        ?>
					@if( $fecha_entrada < $fecha_vencida )
			            <tr id="{{ $q->id }}" class="red">
				            <td                width="17%"> {{ $q->usuario }} </td>
				            <td class="center" width="13%"> {{ $q->fecha }} </td>
				            <td                width="40%"> {{ $q->cliente }} </td>
				            <td class="right"  width="9%"> {{ $total }} </td>
				            <td class="right"  width="9%"> {{ $saldo }} </td>
				            <td class="widthS center font14"  width="12%"> 
				                <a href="javascript:void(0);" title="Ver detalle" onclick="showSalesDetail(this)" class="fa fa-plus-square show_detail"> 
				            </td>
				        </tr>
					@else
				        <tr id="{{ $q->id }}">
				            <td                width="17%"> {{ $q->usuario }} </td>
				            <td class="center" width="13%"> {{ $q->fecha }} </td>
				            <td                width="40%"> {{ $q->cliente }} </td>
				            <td class="right"  width="9%"> {{ $total }} </td>
				            <td class="right"  width="9%"> {{ $saldo }} </td>
				            <td class="widthS center font14"  width="12%"> 
				                <a href="javascript:void(0);" title="Ver detalle" onclick="showSalesDetail(this)" class="fa fa-plus-square show_detail">
				            </td>
				        </tr>
					@endif
				@endforeach
			</tbody>
		</table>
    </div>
</div>
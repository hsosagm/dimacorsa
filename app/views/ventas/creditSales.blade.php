<?php 
$total_saldo = 0;
$saldo_vencido = 0;
?>

<table id="example" class="display" width="100%" cellspacing="0">

    <thead>
        <tr id="hhh">
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Saldo</th>
            <th>Operaciones</th>
        </tr>
    </thead>

	<tbody>

		@foreach($ventas as $q)
		    <?php
		        $total_saldo = $total_saldo + $q->saldo;
		        $saldo = number_format($q->saldo,2,'.',',');
		        $total = number_format($q->total,2,'.',',');

		        $fecha_entrada = $q->fecha;
                $fecha_entrada = date('Ymd', strtotime($fecha_entrada));
                $fecha_vencida = date('Ymd',strtotime("-30 days"));
	        ?>

			@if( $fecha_entrada < $fecha_vencida )
			    <?php
			        $saldo_vencido = $saldo_vencido + $q->saldo;
		        ?>
	            <tr id="{{ $q->id }}" class="red">
		            <td                width="21%"> {{ $q->usuario }} </td>
		            <td class="center" width="15%"> {{ $q->fecha }} </td>
		            <td class="right"  width="12%"> {{ $total }} </td>
		            <td class="right"  width="12%"> {{ $saldo }} </td>
		            <td class="widthS center font14"  width="12%"> 
		                <a href="javascript:void(0);" title="Ver detalle" onclick="showSalesDetail(this)" class="fa fa-plus-square show_detail"> 
		            </td>
		        </tr>
			@else
		        <tr id="{{ $q->id }}">
		            <td                width="21%"> {{ $q->usuario }} </td>
		            <td class="center" width="15%"> {{ $q->fecha }} </td>
		            <td class="right"  width="12%"> {{ $total }} </td>
		            <td class="right"  width="12%"> {{ $saldo }} </td>
		            <td class="widthS center font14"  width="12%"> 
		                <a href="javascript:void(0);" title="Ver detalle" onclick="showSalesDetail(this)" class="fa fa-plus-square show_detail">
		            </td>
		        </tr>

			@endif

		@endforeach

	</tbody>

</table>
<?php $total_saldo = number_format($total_saldo,2,'.',','); ?>
<?php $saldo_vencido = number_format($saldo_vencido,2,'.',','); ?>

{{ Form::hidden('total_saldo', $total_saldo) }}
{{ Form::hidden('saldo_vencido', $saldo_vencido) }}

<script type="text/javascript">
    $(document).ready(function() {

        $('#example').dataTable({});

    });
</script>
<?php 
	$total_saldo = 0;
	$saldo_vencido = 0;
?>

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

<?php $total_saldo = number_format($total_saldo,2,'.',','); ?>
<?php $saldo_vencido = number_format($saldo_vencido,2,'.',','); ?>

{{ Form::hidden('total_saldo', $total_saldo) }}
{{ Form::hidden('saldo_vencido', $saldo_vencido) }}

<script type="text/javascript">
    $(document).ready(function() {
                setTimeout(function()
                {
                    $('#example_length').prependTo("#table_length");

                    var saldo = ($('input[name=total_saldo]').val());
                    var saldo_vencido = ($('input[name=saldo_vencido]').val());

                    $( "#home" ).append('<i style="width:150px; text-align:right;"> Ventas al credito: </i>');
                    $( "#home" ).append('<i style="width:60px; text-align:right;">Saldo total:</i>');
                    $( "#home" ).append('<i id="saldo_por_busqueda" class="home_num">'+saldo+'</i>');
                    $( "#home" ).append('<i style="width:85px; text-align:right;">Saldo vencido:</i>');
                    $( "#home" ).append('<i id="saldo_por_busqueda_vencido" class="home_num">'+saldo_vencido+'</i>');

                    $('.dt-container').show(); 
                    
                    oTable = $('#example').dataTable();

                    $('#iSearch').keyup(function() {
			            if ($.trim($(this).val()).length != 0) {

	                        oTable.fnFilter( $(this).val() );

	                        var table = $('#example').DataTable();

	                        var s_filter_applied = table.column( 4, {"filter": "applied"} ).data().sum();
	                        var s_filter_applied = accounting.formatMoney(s_filter_applied,"", 2, ",", ".");
	                        $('#saldo_por_busqueda').text(s_filter_applied);

	                        var sv_filter_applied=0;

	                        $("tbody tr.red").each(function () {
	                            var getValue = $(this).find("td:eq(4)").text();
	                            var filteresValue=getValue.replace(/\,/g, '');
	                            sv_filter_applied +=Number(filteresValue)
	                        });
	                        sv_filter_applied = accounting.formatMoney(sv_filter_applied,"", 2, ",", ".");
	                        $('#saldo_por_busqueda_vencido').text(sv_filter_applied);

			            } else {
			                $('#saldo_por_busqueda').text(saldo);
			                $('#saldo_por_busqueda_vencido').text(saldo_vencido);
			            }
                    })
                }, 300);
    });

</script>
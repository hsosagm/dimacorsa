<div class="row">

	<div class="col-md-6">
		{{ Form::open(array('url' => '/user/ventas/detalle', 'data-remote-md-d', 'data-success' => 'Venta Generada', 'status' => '0')) }}
		{{ Form::hidden('producto_id') }}
		{{ Form::hidden('venta_id', $venta_id) }}
		{{ Form::hidden('ganancias', 0) }}
		<table class="master-table">
			<tr>
				<td>Codigo:</td>
				<td>Cantidad:</td>
				<td>Precio:</td>
			</tr>
			<tr>
				<td>
					<input type="text" id="search_producto"> 
					<i class="fa fa-search btn-link theme-c" id="md-search"></i>
				</td>
				<td><input class="input input_numeric" type="text" name="cantidad"></td>
				<td><input class="input_numeric" id="precio-publico" type="text" name="precio"></td>
				<td>
					<i onclick="ingresarProductoAlDetalle(this)" class="fa fa-check fg-theme"></i>
				</td>
			</tr>
		</table>
		{{ Form::close() }}
	</div>

	<div class="col-md-6">
		<div class="row master-precios">
			<div class="col-md-4 precio-publico" style="text-align:left;"> </div>
			<div class="col-md-3 existencia" style="text-align:right;"> </div>
		</div>
		<div class="row master-descripcion">
			<div class="col-md-11 descripcion"> </div>
		</div>
	</div>

</div>

<div class="body-detail">
	@include('ventas.detalle_body')
</div>

<div class="form-footer" >
	<div class="row">
		<div class="col-md-6">
			<i class="fa fa-print fa-lg icon-print" onclick="ImprimirVentaModal(this, {{$venta_id}} );"></i>
		</div>
		<div class="col-md-6" align="right">
			<i class="fa fa-trash fa-lg icon-delete" onclick="RemoveSale();"></i>
			<i class="fa fa-check fa-lg icon-success" onclick="OpenModalSalesPayments( {{$venta_id}} );"></i>
		</div>
	</div>
</div>
</div>


<script>
	app.venta_id = {{ $venta_id }};
	$('.numeric').autoNumeric({ aNeg:'', mDec:2, mRound:'S', vMax: '999999.99', lZero: 'deny', mNum:10});

	$(function() {
		$(document).on("enter","#precio-publico",function(event) {
			if($.trim($(this).val()) == ""){
				if($(this).attr('status') == "1") {
					$(this).val($(this).attr('placeholder'));
					$(this).select();  
					$(this).attr('status',0);  
				}
				else{
					$(this).val("");
					$(this).attr('status',1);
				}
				event.preventDefault();
				event.stopPropagation()
			}
		});
	});

</script>
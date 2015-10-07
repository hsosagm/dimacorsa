<div class="row" style="padding:10px">
	<input type="hidden" name="cliente_id" id="cliente_id">

	<div class="row" style="padding:10px; padding-top:0px;">
		<div class="col-md-12">
			<input type="text" id="cliente" placeholder="Buscar Cliente...." class="input form-control">
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 infoCliente" align="center">
			{{ $cliente->nombre.' '.$cliente->direccion }}
		</div>
		<div class="col-md-12" align="center">
			{{ Input::get('nota') }}
		</div>
	</div>
</div>

{{ Form::open(array('url' => '/user/notaDeCredito/detalle', 'data-remote-md-d', 'data-success' => 'Ingresado', 'status' => '0')) }}

	{{ Form::hidden('nota_credito_id', $nota_credito_id) }}

	<div class="row" style="padding-top:10px; border-top:1px solid #C8C8C8;">
		<div class="col-md-6" style="padding-top:5px">
			<div class="col-md-11">
				<input type="text" name="monto" class="form-control" placeholder="Monto">
			</div>
		</div>
		<div class="col-md-5">
			<div class="col-md-11">
				{{ Form::select('metodo_pago_id', MetodoPago::where('id','!=',2)->where('id','!=',6)->where('id','!=',7)
	         	->lists('descripcion', 'id') ,'', array('class'=>'form-control')) }}
			</div>
		</div>
		<div class="col-md-1">
			<i onclick="ingresarProductoAlDetalle(this)" class="fa fa-check fg-theme"></i>
		</div>
	</div>

{{ Form::close() }}
<div class="body-detail" style="min-height: 160px ! important;"></div>

<script type="text/javascript">
	$('#cliente').autocomplete({
		serviceUrl: '/user/cliente/search',
		onSelect: function (data) {
			$('#cliente_id').val(data.id);
			$(".infoCliente").html(data.value);
		}
	});
</script>

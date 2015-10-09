<div class="row" style="padding:10px">
	<input type="hidden" name="cliente_id" id="cliente_id_nota" value="{{ $cliente->id }}">

	<div class="row" style="padding:10px; padding-top:0px;">
		<div class="col-md-10">
			<input type="text" id="cliente_nota" placeholder="Buscar Cliente...." class="input form-control">
		</div>
		<div class="col-md-2">
			<i class="fa fa-plus-square btn-link theme-c" onclick="crearClienteNotaCredito(this)"></i>
			<i class="fa fa-pencil btn-link theme-c" onclick="actualizarClienteNotaCredito(this, 'detalle')"></i>
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

<div class="formCrearCliente" status="0" style="display:none">
	{{ Form::open(array('id' => 'formCrearCliente')) }}
		<div class="form-group row">
			<div class="col-sm-3">
				<h4>Nuevo cliente</h4>
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-6">
				<input type="text" name="nombre" style="width: 100% !important;" class="input sm_input" placeholder="Nombre">
			</div>
			<div class="col-sm-6">
				<input type="text" name="direccion" style="width: 100% !important;" class="input sm_input" placeholder="Direccion">
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-4">
				<input type="text" name="nit" style="width: 100% !important;" class="input sm_input" placeholder="Nit">
			</div>
			<div class="col-sm-4">
				<input type="text" name="telefono" style="width: 100% !important;" class="input sm_input" placeholder="Telefono">
			</div>
			<div class="col-sm-4">
				<input type="text" name="email" style="width: 100% !important;" class="sm_input" placeholder="Email">
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-9"></div>
			<div class="col-sm-3" style="text-align:right;">
				<button type="button" onclick="guardarClienteNuevoDetalleNotaCredito(this)" class="bg-theme">Guardar..!</button>
			</div>
		</div>
	{{ Form::close() }}
</div>

<div class="formActualizarCliente" status="0" style="display:none"></div>

{{ Form::open(array('url'=>'/user/notaDeCredito/detalle', 'data-remote-md-d', 'data-success'=>'Ingresado', 'status'=>'0', 'id'=>'adelantoMetodoDePagoForm')) }}

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
			<i onclick="ingresarAdelantoMetodoDePago(this)" class="fa fa-check fg-theme"></i>
		</div>
	</div>

{{ Form::close() }}
<div class="body-detail" style="min-height: 160px ! important;"></div>

<div class="form-footer" >
	<div class="row">
		<div class="col-md-6">
				<i class="fa fa-print fa-lg icon-print" onclick="imprimirNotaDeCretidoAdelanto(this, {{$nota_credito_id}});"></i>
		</div>
		<div class="col-md-6" align="right">
			<i class="fa fa-trash-o fa-lg icon-delete" onclick="eliminarNotaDeCretidoAdelanto({{$nota_credito_id}});"></i>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#cliente_nota').autocomplete({
		serviceUrl: '/user/cliente/search',
		onSelect: function (data) {
			$('#cliente_id_nota').val(data.id);
			var nombre = data.value;
			$.ajax({
                type: "POST",
                url: '/user/notaDeCredito/updateClienteId',
                data: {cliente_id: data.id , nota_credito_id: $("input[name='nota_credito_id']").val() },
            }).done(function(data) {
                if (data.success == true) {
					$(".infoCliente").html(nombre);
                    return msg.success('Cliente Actualizado', 'Listo!');
                }
                msg.warning(data, 'Advertencia!');
            });

		}
	});
</script>

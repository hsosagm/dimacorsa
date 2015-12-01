<div class="master-detail-body">
	{{ Form::open(array('data-remote', 'data-success' => 'Nota de Credito  Generada' ,"onsubmit"=>" return false")) }}
	<input type="hidden" name="cliente_id" id="cliente_id_nota">
	<div class="row" style="padding:10px">
		<div class="col-md-7">
			<input type="text" id="cliente_nota" placeholder="Buscar Cliente...." class="input form-control">
		</div>
		<div class="col-md-1">
			<i class="fa fa-plus-square btn-link theme-c" onclick="crearClienteNotaCredito(this)"></i>
			<i class="fa fa-pencil btn-link theme-c" onclick="actualizarClienteNotaCredito(this, 'create')"></i>
		</div>
		<div class="col-md-4">
			<input type="text" name="monto" class="input_numeric form-control" autocomplete="off">
		</div>
	</div>
	<br>
	<div class="row">
		<h4>
			<label class="col-md-12 cliente_informacion center"></label>
		</h4>
	</div>
	<div class="form-footer" >
		<div class="row">
			<div class="col-md-12" align="right">
				<input class="btn theme-button" type="submit" value="Enviar!" autocomplete="off">
			</div>
		</div>
	</div>
	{{ Form::close() }}
	<div class="formCrearCliente" status="0" style="display:none">
		{{ Form::open(array('id' => 'formCrearCliente')) }}
			<div class="form-group row">
				<div class="col-sm-12">
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
		        	<button type="button" onclick="guardarClienteNuevoNotaCredito(this)" class="bg-theme">Guardar..!</button>
		        </div>
		    </div>
		{{ Form::close() }}
	</div>
	<div class="formActualizarCliente" status="0" style="display:none"></div>
</div>

<script type="text/javascript">
	$('#cliente_nota').autocomplete({
		serviceUrl: '/user/cliente/search',
		onSelect: function (data) {
			$('#cliente_id_nota').val(data.id);
			$('.cliente_informacion').html(data.value);
		}
	});
</script>

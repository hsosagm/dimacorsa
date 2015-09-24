<div class="row" style="padding:10px">
	<label class="col-md-2">Nombre:</label>
	<label class="col-md-7"> {{ $cliente->nombre }} </label>
	<label class="col-md-3">Tel: {{ $cliente->telefono }} </label>
	<label class="col-md-2">Direccion:</label>
	<label class="col-md-7"> {{ $cliente->direccion }} </label>
	<label class="col-md-3">nit: {{ $cliente->nit }} </label>
	<br>
	<label class="col-md-2">Nota:</label>
	<label class="col-md-10"> {{ Input::get('nota') }} </label>
</div>

{{ Form::open(array('url' => '/user/notaDeCredito/detalle', 'data-remote-md-d', 'data-success' => 'Ingresado', 'status' => '0')) }}

	{{ Form::hidden('nota_credito_id', $nota_credito_id) }}

	<div class="row" style="padding-top:10px; border-top:1px solid #C8C8C8;">
		<div class="col-md-6" style="padding-top:5px">
			<label class="col-md-4">Monto:</label>	
			<div class="col-md-8">
				<input type="text" name="monto" class="form-control">
			</div>	
		</div>
		<div class="col-md-6">
			<label class="col-md-4">M. Pago:</label>	
			<div class="col-md-8">
				{{ Form::select('metodo_pago_id', MetodoPago::where('id','!=',2)->where('id','!=',6)->where('id','!=',7)
	         	->lists('descripcion', 'id') ,'', array('class'=>'form-control')) }}
			</div>	
		</div>
	</div>

{{ Form::close() }}
<div class="body-detail"></div>  
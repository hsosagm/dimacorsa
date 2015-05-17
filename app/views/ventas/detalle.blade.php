<div class="row">

	<div class="col-md-6">
	    {{ Form::open(array('url' => '/user/ventas/detalle', 'data-remote-md-d', 'data-success' => 'Venta Generada', 'status' => '0')) }}
			{{ Form::hidden('producto_id') }}
			{{ Form::hidden('serials') }}
			{{ Form::hidden('venta_id', $id) }}
			{{ Form::hidden('ganancias', 0) }}
			<table class="master-table">
				<tr>
					<td>
						Codigo: 
						<i class="fa fa-search btn-link theme-c" id="md-search"></i>
					</td>
					<td>Cantidad:</td>
					<td>Precio:</td>
				</tr>
				<tr>
					<td>
						<input type="text" id="search_producto"> 
					</td>
					<td><input class="input input_numeric" type="text" name="cantidad"> </td>
					<td><input class="input_numeric" type="text" name="precio" id="venta_save_producto"> </td>
					<td>
						<button type="button" class="btn btn-default btn-lg" id="serial-venta">
							<span class="glyphicon glyphicon-barcode" aria-hidden="true" ></span>
						</button>
					</td>
				</tr>
			</table>
	    {{ Form::close() }}
	</div>

	<div class="col-md-6">
		<div class="row master-precios">
			<div class="col-md-4 precio-publico" style="text-align:center;"> </div>
			<div class="col-md-3 existencia" style="text-align:right;"> </div>
		</div>
		<div class="row master-descripcion">
			<div class="col-md-11 descripcion"> </div>
		</div>
	</div>

</div>

<div class="body-detail"> </div>

<div class="form-footer" align="right">
	{{ Form::button('Eliminar!', ['class'=>'btn btn-warning','onClick'=>'RemoveSale();']);}}
	{{ Form::button('Finalizar!', ['class'=>'btn btn-info theme-button']) }}
</div>
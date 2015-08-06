  
<div class="row">
	<div class="col-md-6">
		{{ Form::open(array('url' => '/admin/compras/detalle', 'data-remote-md-d', 'data-success' => 'Producto Ingresado', 'status' => '0')) }}
		{{ Form::hidden('producto_id') }}
		{{ Form::hidden('compra_id',@$id) }}
		{{ Form::hidden('serials','') }}
		<table class="master-table" id="compra_save_producto">
			<tr>
				<td>
					Codigo: 
					<i class="fa fa-pencil btn-link theme-c" style="margin-left:10px;" id="_edit_producto"></i>
					<i class="fa fa-plus-square btn-link theme-c" id="_add_producto"></i>
					<i class="fa fa-print btn-link theme-c" id="print_code_producto" ></i>
					<i class="fa fa-search btn-link theme-c" id="md-search"></i>
				</td>
				<td>Cantidad:</td>
				<td>Costo Unitario:</td>
				<td> </td>
			</tr>
			<tr>
				<td>
					<input type="text" id="search_producto"> 
				</td>
				<td><input type="text" name="cantidad" class="input input_numeric" > </td>
				<td><input type="text" id="precio-costo" name="precio" class="input_numeric master-serials"> </td>
				<td>
					<button type="button" class="btn btn-default btn-lg" id="OpenModalPurchaseItemSerials">
						<span class="glyphicon glyphicon-barcode" aria-hidden="true" ></span>
					</button>
				</td>
			</tr>
		</table>
		{{ Form::close() }}
	</div>

	<div class="col-md-6">
		<div class="row master-precios">
			<div class="col-md-4 precio-costo" style="text-align:left;" > </div>
			<div class="col-md-4 precio-publico" style="text-align:center;" > </div>
			<div class="col-md-3 existencia" style="text-align:right;" > </div>
		</div>
		<div class="row master-descripcion">
			<div class="col-md-11 descripcion"></div>
		</div>
	</div>
</div>
<div><br>
	<div class="contenedor_producto" style="display:none"></div>
	<div class="body-detail" >  
		@include('compras.detalle_body')
	</div>
</div>

<div class="form-footer" align="right">
	{{Form::button('Eliminar!', ['class'=>'btn btn-warning','compra_id'=> @$id,'onClick'=>'DeletePurchaseInitial(this);']);}}
	{{ Form::button('Finalizar!', ['class'=>'btn btn-info theme-button','id'=> @$id,'onClick'=>'ModalPurchasePayment(this);']) }}
</div>

  
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
					<i class="fa fa-print btn-link theme-c"></i>
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
				<td><input type="text" name="precio" class="input_numeric"> </td>
				<td>
					<button type="button" class="btn btn-default btn-lg" id="serial-compra">
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
<div>
	<table class="table-detail">
		<thead>
			<tr>
				<th class="hide">id</th>
				<th width="10%">Cantidad</th>
				<th width="70%" style="margin-left:25px;">Descripcion</th>
				<th width="10%">Precio</th>
				<th width="10%">Totales</th>
				<th width="5%"> </th>
			</tr>
		</thead>
		<tr> 
			<td colspan="5"  width="100%"> 
				<div class="table-scroll" width="100%">
					<div class="body-detail" > 

					</div>
				</div>
			</td>
		</tr>
	</table>

</div>
<div class="row">
	<div class="col-md-8"> <textarea name="nota" cols="30" rows="2"></textarea></div>
	<div class="col-md-4">
	</div>
</div>

<div class="form-footer" align="right">
	{{Form::button('Eliminar!', ['class'=>'btn btn-warning','onClick'=>'DeleteCompraInicial();']);}}
	{{ Form::button('Finalizar!', ['class'=>'btn btn-info theme-button','onClick'=>'Ingresar_abono_compra();']) }}
</div>

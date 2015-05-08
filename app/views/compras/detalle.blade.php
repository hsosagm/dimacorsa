  
<div class="row">
	<div class="col-md-6">
		{{ Form::open(array('data-remote-md-d', 'data-success' => 'Producto Ingresado...!')) }}
		{{ Form::hidden('producto_id') }}
		{{ Form::hidden('compra_id',@$id) }}
		{{ Form::hidden('serials','') }}
		<table class="master-table">
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
				<td><input type="text" name="cantidad" > </td>
				<td><input type="text" name="precio" id="compra_save_producto"> </td>
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
	<table class="table-detail-compra">
		<thead>
			<tr>
				<th class="hide">id</th>
				<th width="70">Cantidad</th>
				<th width="750">Descripcion</th>
				<th width="70">Precio</th>
				<th width="70">Totales</th>
				<th width="90"></th>
			</tr>
		</thead>
		<tr> 
			<td colspan="5"  width="100%"> 
				<div class="table-scroll" width="100%">
					<table width="100%"> 
					<tbody> 
						<div class="body-detail" > </div>
					</tbody>
					</table>
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

	<div class="row">
		<div class="col-md-6">
			<div class="col-md-2">
				<label>Codigo</label>
			</div>
			<div class="col-md-10">
				<input type="text" v-on="keyup: findProducto | key 'enter'" name="codigo" class="codigo">
				<i class="fa fa-search btn-link theme-c" v-on="click: get_table_productos_para_venta()" style="margin-left:30px; margin-right:10px; font-size: 24px !important"></i>
				<i v-on="click: findProducto" class="fa fa-check fg-theme" style="font-size: 24px !important"></i>
			</div>
		</div>

		<div v-if="producto.id" class="col-md-6">
			<div class="row master-precios col-md-12">
				<label class="col-md-12" v-html="producto.descripcion"></label>
				<label class="col-md-3">Precio:</label>
				<label class="col-md-3" v-html="producto.precio | currency ''"></label>
				<label class="col-md-3">Existencia:</label>
				<label class="col-md-3" v-html="producto.existencia"></label>
			</div>
			<div class="row master-descripcion">
				<div class="col-md-11 descripcion"></div>
			</div>
		</div>
	</div>

	<div class="body-detail">
		<table width="100%">
		    <thead v-show="detalleTable.length > 0">
				<tr style="font-size:14px">
					<th width="10%">Cantidad</th>
					<th width="70%">Descripcion</th>
					<th width="10%">Precio</th>
					<th width="10%">Totales</th>
					<th width="5%"></th>
				</tr>
		    </thead>

			<tbody>
			    <tr v-repeat="dt: detalleTable" v-class="editing: this == editedTodo" style="font-size:14px">
	                <td width="10%" class="view number" v-on="dblclick: editItem($event, 'cantidad', dt.cantidad)">@{{ dt.cantidad }}</td>
	                <td width="10%" class="detail-input-edit">
	                    <input type="text" v-model="dt.cantidad | parseInt" class="input_numeric"
	                        v-on="keyup: doneEdit(this) | key 'enter', keyup: cancelEdit(this, $event, 'cantidad') | key 'esc'">
	                </td>
	                <td width="70%">@{{ dt.descripcion }}</td>
	                <td width="10%" class="view" v-on="dblclick: editItem($event, 'precio', dt.precio)" style="text-align:right; padding-right: 20px !important;">@{{ dt.precio | currency '' }}</td>
	                <td width="10%" class="detail-input-edit">
	                    <input type="text" v-model="dt.precio | parseFloat" class="input_numeric"
	                        v-on="keyup: doneEdit(this) | key 'enter', keyup: cancelEdit(this, $event, 'precio') | key 'esc'">
	                </td>
	                <td width="10%" style="text-align:right; padding-right: 20px !important;">@{{ dt.total | currency '' }}</td>
	                <td width="5%">
	                	<i v-on="click: removeItem($index, dt.id)" class="fa fa-trash-o pointer btn-link theme-c" style="font-size:18px"></i>
	                </td>
	                <td width="5%">
	                	{{-- <i class="fa fa-barcode fg-theme"  v-on="click: getSerialsForm($index)"></i> --}}
	                </td>
	            </tr>
			</tbody>

			<tfoot width="100%" style="border-top: 1px solid #CACACA; text-align:right">
				<tr>
					<td>
						<div class="row">
							<div class="col-md-6"></div>
							<div class="col-md-3">
								<label v-if="metodo_pago != 'efectivo'">Subtotal</label>
								<label v-if="metodo_pago == 'efectivo'">Total</label>
							</div>
							<div class="col-md-3">
								<label v-html="totalVenta | currency ''" style="padding-right:50px;"></label>
							</div>
						</div>
					</td>
				</tr>
				<tr v-if="metodo_pago == 'tarjeta'">
					<td>
						<div class="row">
							<div class="col-md-7"></div>
							<div class="col-md-2">
								<label>Recargo</label>
							</div>
							<div class="col-md-3">
								<label v-html="recargo | currency ''" style="padding-right:50px;"></label>
							</div>
						</div>
					</td>
				</tr>
				<tr v-if="metodo_pago == 'tarjeta'">
					<td>
						<div class="row">
							<div class="col-md-7"></div>
							<div class="col-md-2">
								<label>Total</label>
							</div>
							<div class="col-md-3">
								<label v-html="total_con_recargo | currency ''" style="padding-right:50px;"></label>
							</div>
						</div>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>

	<div class="form-footer" style="text-align: right; padding-top:15px">
		<i v-on="click: eliminarVenta" class="md-icon fa fa-trash-o fa-lg icon-delete icon-6" title="Eliminar venta"></i>
		@if (Auth::user()->tienda->cajas)
			@if($caja)
				{{-- <i v-on="click: imprimirGarantia($event)" class="fa fa-file-text-o fa-lg text-info icon-5" title="Imprimir Garantia"></i> --}}
				<i class="md-icon fa fa-money fa-lg icon-success icon-6" v-on="click: getPaymentForm" title="Ingresar pagos"></i>
			@else
				<i class="fa fa-paper-plane-o fa-lg icon-success" v-on="click: enviarACaja"></i>
			@endif
		@else
			{{-- <i v-on="click: imprimirGarantia($event)" class="fa fa-file-text-o fa-lg text-info g-icon icon-5" title="Imprimir Garantia"></i> --}}
			<i class="md-icon fa fa-money fa-lg icon-success icon-6" v-on="click: getPaymentForm" title="Ingresar pagos"></i>
		@endif
	</div>

	<script>
		ventas.venta_id = {{ $venta_id }};
		venta_compile();
		$('.parseInt').autoNumeric({ mDec:0, mRound:'S', vMin: '0', vMax: '9999', lZero: 'deny', mNum:10 });
		$('.parseFloat').autoNumeric({ mDec:2, mRound:'S', vMin: '0', vMax: '999999', lZero: 'deny', mNum:10 });
	</script>

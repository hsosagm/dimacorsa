<div class="row">
	<div class="col-md-6">
		<table class="master-table">
			<tr>
				<td>Codigo:</td>
				<td>Cantidad:</td>
				<td>Precio:</td>
			</tr>
			<tr>
				<td>
					<input type="text" v-on="keyup: findProducto | key 'enter'" name="codigo">
					<i class="fa fa-search btn-link theme-c" v-on="click: get_table_productos_para_venta()" style="margin-left:10px"></i>
				</td>
				<td>
				    <input v-on="keyup: postVentaDetalle | key 'enter'" class="parseInt" type="text" name="cantidad">
				</td>
				<td>
				    <input v-on="keyup: postVentaDetalle | key 'enter'" class="parseFloat" type="text" name="precio" id="precio-publico">
				</td>
				<td>
				    <i v-on="click: postVentaDetalle" class="fa fa-check fg-theme" style="margin-left:40px"></i>
				</td>
			</tr>
		</table>
	</div>

	<div v-if="producto_detalle.id" class="col-md-6">
		<div class="row master-precios col-md-12">
			<label class="col-md-12" v-html="producto_detalle.descripcion"></label>
			<label class="col-md-3">Precio:</label>
			<label class="col-md-3" v-html="producto_detalle.precio | currency ''"></label>
			<label class="col-md-3">Existencia:</label>
			<label class="col-md-3" v-html="producto_detalle.existencia"></label>
		</div>
		<div class="row master-descripcion">
			<div class="col-md-11 descripcion"></div>
		</div>
	</div>
</div>

<div class="body-detail">
	<table width="100%">
	    <thead v-show="detalleTable.length > 0">
	        <tr>
	            <th width="10%">Cantidad</th>
	            <th width="70%">Descripcion</th>
	            <th width="10%">Precio</th>
	            <th width="10%">Totales</th>
	            <th width="5%"></th>
	        </tr>
	    </thead>

		<tbody>
		    <tr v-repeat="dt: detalleTable" v-class="editing: this == editedTodo">
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
                	<i v-on="click: removeItem($index, dt.id)" class="fa fa-trash-o pointer btn-link theme-c"></i>
                </td>
                <td width="5%">
                	<i class="fa fa-barcode fg-theme"  v-on="click: getSerialsForm($index)"></i>
                </td>
            </tr>
		</tbody>

		<tfoot width="100%">
			<tr>
			    <td>
					<div class="row" style="font-size:13px !important">
						<div class="col-md-7"></div>
						<div class="col-md-2">Total a cancelar</div>
						<div class="col-md-3" v-html="totalVenta | currency ''" class="td_total_text" style="text-align:right; padding-right:50px;"></div>
					</div>
			    </td>
		    </tr>
		</tfoot>
	</table>
</div>

<div class="form-footer" style="text-align: right;">
    <i v-on="click: eliminarVenta" class="fa fa-trash-o fa-lg icon-delete" title="Eliminar venta"></i>
</div>

<script>
	kits.kit_id = {{ $kit_id }};
	kits_compile();
	$('.parseInt').autoNumeric({ mDec:0, mRound:'S', vMin: '0', vMax: '9999', lZero: 'deny', mNum:10 });
	$('.parseFloat').autoNumeric({ mDec:2, mRound:'S', vMin: '0', vMax: '999999', lZero: 'deny', mNum:10 });
</script>
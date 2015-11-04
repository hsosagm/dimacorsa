<div class="row">
	<div class="col-md-6">
		<table class="master-table">
			<tr>
				<td>Codigo:</td>
				<td>Cantidad:</td>
			</tr>
			<tr>
				<td>
					<input type="text" v-on="keyup: findProducto | key 'enter'" name="producto">
					<i class="fa fa-search btn-link theme-c" id="md-search" style="margin-left:10px"></i>
				</td>
				<td>
				    <input v-on="keyup: postDevolucionDetalle | key 'enter'" class="numeric" type="text" name="cantidad">
				    <i v-on="click: postDevolucionDetalle" class="fa fa-check fg-theme" style="margin-left:40px"></i>
				</td>
			</tr>
		</table>
	</div>

	<div v-if="producto.id" class="col-md-6">
		<div class="row master-precios col-md-12">
			<label class="col-md-12" v-html="producto.descripcion"></label>
			<label class="col-md-3">Precio venta:</label>
			<label class="col-md-3" v-html="producto.precio | currency ''"></label>
			<label class="col-md-3">Cantidad vendida:</label>
			<label class="col-md-3" v-html="producto.cantidad"></label>
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
		    <tr v-repeat="dt: detalleTable" v-class="editing : this == editedTodo">
                <td width="10%" class="view" v-text="dt.cantidad" v-on="dblclick: editItem"></td>
                <td width="10%" class="detail-input-edit">
                    <input field="cantidad" type="text" v-model="dt.cantidad | cleanNumber" class="input_numeric" 
                        v-on="keyup : doneEdit(this) | key 'enter', keyup : cancelEdit(this, $event) | key 'esc'">
                </td>
                <td width="70%">@{{ dt.descripcion }}</td>

                <td style="text-align:right; padding-right: 20px !important;" width="10%">@{{ dt.precio | currency '' }}</td>
                <td width="10%" style="text-align:right; padding-right: 20px !important;">@{{ dt.total | currency '' }}</td>
                <td width="5%">
                	<i v-on="click: removeItem($index, dt.id)" class="fa fa-trash-o pointer btn-link theme-c"></i>
                </td>
                <td width="5%">
                	<i class="fa fa-barcode fg-theme"  v-on="click: getSerialsForm(dt.serials, $index)"></i>
                </td>
            </tr>
		</tbody>

		<tfoot width="100%">
			<tr>
			    <td>
					<div class="row" style="font-size:13px !important">
						<div class="col-md-8">Total a devolver</div>
						<div class="col-md-4" v-html="totalDevolucion | currency ''" class="td_total_text" style="text-align:right; padding-right:50px;"></div>
					</div>
			    </td>
		    </tr>
		</tfoot>
	</table>
</div>

<div class="form-footer">
	<div class="row">
		<div align="right">
			<i v-on="click: eliminarDevolucion" class="fa fa-trash-o fa-lg icon-delete"></i>
			<i class="fa fa-check fa-lg icon-success" v-on="click: getPaymentForm"></i>
		</div>
	</div>
</div>

<script>
	devoluciones.devolucion_id = {{ $devolucion_id }};
	devoluciones_compile();
	$('.numeric').autoNumeric({ mDec:0, mRound:'S', vMin: '0', vMax: '999999', lZero: 'deny', mNum:10});
</script>
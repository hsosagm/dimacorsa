@if (count(@$detalle) > 0)

	<table width="100%">
	    <thead >
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
                <td width="10%" class="view" v-text="dt.cantidad" v-on="dblclick: editItem(this)"></td>
                <td width="10%" class="edit">
                    <input type="text" v-model="dt.cantidad" v-item-focus="this == editedTodo" class="input_numeric" 
                        v-on="keyup : doneEdit(this) | key 'enter', keyup : cancelEdit(this) | key 'esc'">
                </td>
                <td width="70%"> @{{ dt.descripcion }} </td>
                <td style="text-align:right; padding-right: 20px !important;" width="10%">@{{ dt.precio | currency }}</td>
                <td width="10%" style="text-align:right; padding-right: 20px !important;"> @{{ dt.total | currency }} </td>
                <td width="5%" ><i  v-on="click: removeItem($index, dt.id)" class="fa fa-trash-o pointer btn-link theme-c"> </i></td>
            </tr>
		</tbody>

		<tfoot width="100%">
			<tr style="border: solid 1px black">
			    <td>
					<div class="row">
						<div class="col-md-8" >  Total a cancelar </div>
						<div class="col-md-4" v-html="totalVenta | currency" class="td_total_text" style="text-align:right; padding-right:50px;"></div>
					</div>
			    </td>
		    </tr>
		</tfoot>
	</table>
	<script type="text/javascript">
	    app.detalleTable = {{ $detalle }};
	</script>

@endif
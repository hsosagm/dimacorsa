<script> serialsDetalleCompra = []; </script>

<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
		<input type="text" name="serials" class="form-control" id="serialsDetalleCompra" autofocus>
	</div>
	<div class="col-md-1"> 
		<i onclick="guardarSerieDetalleCompra()" class="fa fa-plus fg-theme"></i>
	</div>
</div>
<br>
<div class="serial-detalle">
	<table class="SerialTable">
		<thead>
			<th width="95%"></th>
			<th width="5%"></th>
		</thead>
		<tbody id="listaSeriesDetalleCompra">
			@if(count($serials) > 0)
				@for($i = 0; $i < count($serials); $i++)
					<tr>
						<td>{{ $serials[$i] }}</td>
						<td>
							<i class="fa fa-trash fg-red" onclick="eliminarSerialsDetalleCompra(this,'{{ $serials[$i] }}');"></i>
							<script> serialsDetalleCompra.push('{{$serials[$i]}}') </script>
						</td>
					</tr>
				@endfor
			@endif
		</tbody>
	</table>
</div>
<div class="modal-footer">
	<i onclick="guardarSeriesDetalleCompra(this , {{Input::get('detalle_compra_id')}})" class="fa fa-check fg-theme"></i>
</div>

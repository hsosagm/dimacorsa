<script> serialsDetalleTraslado = []; </script>

<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
		<input type="text" name="serials" class="form-control" id="serialsDetalleTraslado" autofocus>
	</div>
	<div class="col-md-1"> 
		<i onclick="guardarSerieDetalleTraslado()" class="fa fa-plus fg-theme"></i>
	</div>
</div>
<br>
<div class="serial-detalle">
	<table class="SerialTable">
		<thead>
			<th width="95%"></th>
			<th width="5%"></th>
		</thead>
		<tbody id="listaSeriesDetalleTraslado">
			@if(count($serials) > 0)
				@for($i = 0; $i < count($serials); $i++)
					<tr>
						<td>{{ $serials[$i] }}</td>
						<td>
							<i class="fa fa-trash fg-red" onclick="eliminarSerialsDetalleTraslado(this,'{{ $serials[$i] }}');"></i>
							<script> serialsDetalleTraslado.push('{{$serials[$i]}}') </script>
						</td>
					</tr>
				@endfor
			@endif
		</tbody>
	</table>
</div>
<div class="modal-footer">
	<i onclick="guardarSeriesDetalleTraslado(this , {{Input::get('detalle_traslado_id')}})" class="fa fa-check fg-theme"></i>
</div>

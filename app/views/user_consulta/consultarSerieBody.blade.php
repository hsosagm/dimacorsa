<div align="center">
	<h4>

		{{ (@$detalleCompra->producto->descripcion == "")? @$detalleVenta->producto->descripcion:@$detalleCompra->producto->descripcion }}
	</h4>
</div>

<div class="row">

	<div class="col-md-6">

		<br>

		<div class="panel rounded shadow no-overflow">
			<div class="ribbon-wrapper top-left">
				<div class="ribbon ribbon-shadow">Compra</div>
			</div>
			<div class="panel-body">

				<br><br>

				@if(count($detalleCompra))
					<table class="table" width="100%">
						<tr>
							<td width="30%"> Fecha: </td>
							<td width="70%">  {{ @$detalleCompra->compra->fecha_documento }} </td>
						</tr>
						<tr>
							<td width="30%"> No. Factura: </td>
							<td width="70%">  {{ @$detalleCompra->compra->numero_documento }} </td>
						</tr>
						<tr>
							<td width="30%"> Proveedor: </td>
							<td width="70%"> {{ @$detalleCompra->compra->proveedor->nombre }} </td>
						</tr>
						<tr>
							<td width="30%"> Telefono: </td>
							<td width="70%"> {{ @$detalleCompra->compra->proveedor->telefono }} </td>
						</tr>
						<tr>
							<td width="30%"> Garantia: </td>
							<td width="70%">  
								{{  (date_diff( new DateTime(@$detalleCompra->compra->fecha_documento), Carbon::now())->format('%R%a days')).' Dias' }}
							</td>
						</tr>
					</table>	
				@else
					<p>
						No se encontro la serie en Compras...!
					</p>
				@endif			
			</div>
		</div>
	</div>

	<div class="col-md-6">

		<br>

		<div class="panel rounded shadow no-overflow">
			<div class="ribbon-wrapper">
				<div class="ribbon">Venta</div>
			</div>
			<div class="panel-body">

				<br><br>

				@if(count($detalleVenta))
					<table class="table" width="100%">
						<tr>
							<td width="30%"> Fecha: </td>
							<td width="70%"> {{ @$detalleVenta->venta->created_at }} </td>
						</tr>
						<tr>
							<td width="30%"> Usuario: </td>
							<td width="70%"> {{ @$detalleVenta->venta->user->nombre }} </td>
						</tr>
						<tr>
							<td width="30%"> Cliente: </td>
							<td width="70%"> {{ @$detalleVenta->venta->cliente->nombre }} </td>
						</tr>
						<tr>
							<td width="30%"> Telefono: </td>
							<td width="70%"> {{ @$detalleVenta->venta->cliente->telefono }} </td>
						</tr>
						<tr>
							<td width="30%"> Garantia: </td>
							<td width="70%">  
								{{ (date_diff( new DateTime(@$detalleVenta->venta->created_at), Carbon::now())->format('%R%a days')).' Dias' }}
							</td>
						</tr>
					</table>
				@else
					<p>
						No se encontro la serie en Ventas...!
					</p>
				@endif

			</div>
		</div>
	</div>
</div>
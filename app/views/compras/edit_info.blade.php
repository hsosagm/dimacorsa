{{ Form::_open('Informacion de Compra actualizada') }}

<div class="row">

	<div class="col-md-6 master-detail-info">
		{{ Form::hidden('proveedor_id',$compra->proveedor_id) }}
		{{ Form::hidden('compra_id',$compra->id) }}
		<table class="master-table">
			<tr>
				<td>Proveedor:</td>
				<td>
					<input type="text" id="proveedor_id" value="{{ $proveedor->nombre}}"> 
					<i class="fa fa-question-circle btn-link theme-c" id="proveedor_help"></i>
					<i class="fa fa-pencil btn-link theme-c" id="proveedor_edit"> </i>
					<i class="fa fa-plus-square btn-link theme-c" id="proveedor_create"></i>
				</td>
			</tr>
			<tr>
				<td>Factura No.: </td>
				<td>  <input type="text" name="numero_documento"  value="{{$compra->numero_documento}}"> </td>
			</tr>
			<tr >
				<td> Fecha de Doc.:</td>
				<td><input type="text" name="fecha_documento" data-value="{{$compra->fecha_documento}}">  </td>
			</tr>
		</table>
	</div>

	<div class="col-md-6">
		<div class="row">
			<div class="col-md-12 search-proveedor-info"> </div>
		</div>
		<div class="row">
			<div class="col-md-12 proveedor-credito"> </div>
		</div>
	</div>

</div>

{{ Form::_submit('Enviar') }}

{{ Form::close() }}


<div class="row form-proveedor">

	<div class="col-md-8 info-proveedor" >

		<table class="">
			<tr>
				<td> Nombre:</td>
				<td> {{ @$proveedor->nombre }} </td>
			</tr>

			<tr>
				<td> Direccion: </td>
				<td> {{  @$proveedor->direccion }} </td>
			</tr>

			<tr>
				<td> Nit: </td>
				<td> {{  @$proveedor->nit  }} </td>
			</tr>

			<tr>
				<td> Telefono: </td>
				<td> {{  @$proveedor->telefono }} </td>
			</tr>

		</table> 

	</div>

	<div class="col-md-4">

	</div>

</div>
<div class="" align="right">


</div>

<div class="proveedor-body">
	<hr>
	<div class="row">
		<div class="col-md-6 list-body"  >
			Lista de Contactos:
			<div class="row contactos-list">
				<ul>
					@foreach($contactos as $key => $ct)
						<li>
							<a id="contacto_view_info" contacto_id="{{$ct->id}}" class="btn-link theme-c">
							{{$ct->nombre.' '.$ct->apellido}}
							</a> 
						</li>
					@endforeach
				</ul>
			</div>
		</div>

		<div class="col-md-6 contactos-body">
			
		</div>

	</div>

	<div class="form-footer" align="right">
		<button class="btn btn-warning" data-dismiss="modal" type="button">Cerrar!</button>
	</div>

</div>

<style type="text/css">

	.bs-modal .Lightbox{
		width: 850px !important;
	}

</style>

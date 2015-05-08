{{ Form::open(array('data-remote-proveedor-e')) }}

<div class="row form-proveedor">

	<div class="col-md-8 info-proveedor" >

		<table class="">
		{{ Form::hidden('id', @$proveedor->id) }}
			<tr>
				<td> Nombre:</td>
				<td> {{ Form::text("nombre", @$proveedor->nombre , array())}} </td>
			</tr>

			<tr>
				<td> Direccion: </td>
				<td> {{ Form::text("direccion", @$proveedor->direccion, array())}} </td>
			</tr>

			<tr>
				<td> Nit: </td>
				<td> {{ Form::text("nit", @$proveedor->nit , array())}} </td>
			</tr>

			<tr>
				<td> Telefono: </td>
				<td> {{ Form::text("telefono", @$proveedor->telefono , array())}} </td>
			</tr>

		</table> 

	</div>

	<div class="col-md-4">

	</div>

</div>
<div class="" align="right">

	{{ Form::submit('Actualizar datos del proveedor!', array('class'=>'theme-button')) }}

</div>
{{ Form::close() }}

<div class="proveedor-body">
	<hr>
	<div class="row" align="center"> <button type="" id="contacto_nuevo">Nuevo</button></div>
	{{Form::open(array('data-remote-contact'))}} 
	<div class="row">
		<div class="col-md-6 list-body"  >
			Lista de Contactos:
			<div class="row contactos-list">
				<ul>
					@foreach($contactos as $key => $ct)
						<li>
							<a id="contacto_view" contacto_id="{{$ct->id}}" class="btn-link theme-c">
							{{$ct->nombre.' '.$ct->apellido}}
							</a> 
						</li>
					@endforeach
				</ul>
			</div>
		</div>

		{{ Form::hidden('proveedor_id', @$proveedor->id) }}

		<div class="col-md-6 contactos-body">

			
		</div>
	</div>

	<div class="form-footer" align="right">
		{{ Form::submit('Guardar Contacto!', array('class'=>'theme-button')) }}
		<button class="btn btn-warning" data-dismiss="modal" type="button">Finalizar!</button>
	</div>

	{{Form::close()}}
</div>

<style type="text/css">

	.bs-modal .Lightbox{
		width: 850px !important;
	}

</style>

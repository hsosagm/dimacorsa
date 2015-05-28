
<div class="row form-cliente">

	<div class="col-md-6 info-cliente" >

		<table class="">
			<tr>
				<td> Nombre:</td>
				<td> {{ @$cliente->nombre }} </td>
			</tr>

			<tr>
				<td> Direccion: </td>
				<td> {{  @$cliente->direccion }} </td>
			</tr>

			<tr>
				<td> Nit: </td>
				<td> {{  @$cliente->nit  }} </td>
			</tr>

			<tr>
				<td> Telefono: </td>
				<td> {{  @$cliente->telefono }} </td>
			</tr>

		</table> 

	</div>

	<div class="col-md-6 separador-contactos">
	Contactos:
		<div class="contactos-list">
			@foreach($contactos as $key => $ct)
			{{$ct->nombre.' '.$ct->apellido.' ['.$ct->telefono1.']'}}
			<i id="cliente_contacto_view_info" contacto_id="{{$ct->id}}" class="fa fa-chevron-down btn-link theme-c"></i> 
			<div class="info-contactos-body contactos-body-{{$ct->id}}"> </div>
			<br>

			@endforeach
		</div>

	</div>

</div>
<div class="" align="right">


</div>

<div class="cliente-body">

	<div class="form-footer" align="right">
		<button class="btn btn-warning" data-dismiss="modal" type="button">Cerrar!</button>
	</div>

</div>

<style type="text/css">

	.bs-modal .Lightbox{
		width: 750px !important;
	}

	.info-cliente{
		line-height: 140%;
		font-size: 13px !important;
	}

	.info-cliente  table tr td {
		font-size: 13px !important;
		line-height: 100% !important;
	}

	.contactos-list{
		font-size: 13px !important;
	}
	
	.separador-contactos{
	 	border-left: 1px solid #A3A2A2;
	 	min-height: 100px !important;
	 }

</style>

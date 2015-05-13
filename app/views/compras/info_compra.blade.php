<div class="col-md-6 head_compra_info">  

	<div class="row">
		<div class="col-md-3"> Proveedor:</div>
		<div class="col-md-7"> <strong>{{$proveedor->nombre}}</strong> </div>
		<div class="col-md-2"><i class="fa fa-refresh fa-2 btn-link theme-c" id="edit_info_compra"></i></div>
	</div>

	<div class="row">
		<div class="col-md-3"> Factura No:</div>
		<div class="col-md-7"><strong>{{ $compra->numero_documento }}</strong> </div>
		<div class="col-md-2"> </div>
	</div>

	<div class="row">
		<div class="col-md-3"> Fecha de Doc:</div>
		<div class="col-md-7"><strong>{{ $compra->fecha_documento }}</strong> </div>
		<div class="col-md-2"> </div>
	</div>

</div>

<div class="col-md-6 head_compra_info"> 

	<div class="row">
		<div class="col-md-12"> 
			<strong>Direccion:</strong>  
			{{ $proveedor->nombre.' '.$proveedor->direccion }}<br>

			@if($contacto != '')
			<strong>Contacto:</strong> 
			{{ $contacto->nombre.' '.$contacto->apellido.' ['.$contacto->telefono1.']' }}
			@endif
		</div>
	</div>

	<div class="row"> 
		<div class="col-md-12">
			<strong>Saldo Q: </strong>
			{{ $saldo }}
		</div> 
	</div> 

</div>
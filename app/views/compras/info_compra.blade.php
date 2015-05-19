<div class="col-md-6 head_compra_info">  

	<div class="row">
		<div class="col-md-3"> Proveedor:</div>
		<div class="col-md-7"> <strong>{{$proveedor->nombre}}</strong> </div>
		<div class="col-md-2"><i class="fa fa-refresh fa-2 btn-link theme-c" id="OpenModalPurchaseInfo"></i></div>
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
			Direccion:
			<strong>
			{{ $proveedor->nombre.' '.$proveedor->direccion }}<br>
			</strong>  

			@if($contacto != '')
			Contacto:
			<strong> 
			{{ $contacto->nombre.' '.$contacto->apellido.' ['.$contacto->telefono1.']' }}
			</strong> 
			@endif
		</div>
	</div>

	<div class="row"> 
		<div class="col-md-12">
			Saldo Q: 
			<strong>{{ $saldo }}</strong>
		</div> 
	</div> 

</div>
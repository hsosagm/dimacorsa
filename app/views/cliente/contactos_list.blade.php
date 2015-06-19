
 <?php  $contacto = ClienteContacto::where('cliente_id','=', @$cliente_id)->get(); ?>
<div class="list-group">
	<a href="javascript:void(0);" class="list-group-item disabled">
		Lista de contactos
	</a>
	
	@foreach($contacto as $key => $dt)
	<a href="javascript:void(0);" class="list-group-item">
		<div class="row">
			<div class="col-md-8">{{ $dt->nombre.' '.$dt->apellido }} </div>
			<div class="col-md-2">
				<i contacto_id="{{$dt->id}}"  id="contacto_view" class="fa fa-pencil btn-link theme-c"></i>
			</div>
			<div class="col-md-2">
				<i class="btn-link fa fa-trash-o" style="color:#FF0000;;" onclick="cliente_contacto_delete(this,{{$dt->id}})"></i>
			</div>
		</div>
	</a>
	@endforeach

</div>
<br>

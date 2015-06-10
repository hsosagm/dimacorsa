 <?php  $contacto = ClienteContacto::where('cliente_id','=', @$cliente_id)->get(); ?>
 <ul>
 	@foreach($contacto as $key => $dt)
 	<li contacto_id="{{$dt->id}}"  id="cliente_contacto_view" class="btn-link theme-c"> {{ $dt->nombre.' '.$dt->apellido }}</li>
 		@endforeach
 	<br>
 </ul>
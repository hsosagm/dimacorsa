 <?php  $producto = ProveedorContacto::where('proveedor_id','=', @$proveedor_id)->get(); ?>
 <ul>
 	@foreach($producto as $key => $dt)
 	<li contacto_id="{{$dt->id}}"  id="contacto_view" class="btn-link theme-c"> {{ $dt->nombre.' '.$dt->apellido }}</li>
 		@endforeach
 	<br>
 </ul>
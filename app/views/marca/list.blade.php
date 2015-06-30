<?php $marcas = Marca::all(); ?>
<ul>
	@foreach($marcas as $cat)
	<li >{{$cat->nombre}} <i class="fa fa-pencil btn theme-c" onClick="marca_edit(this , {{$cat->id}})"></i></li>
	@endforeach
</ul>
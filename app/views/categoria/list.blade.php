<?php $categorias = Categoria::all(); ?>
<ul>
	@foreach($categorias as $cat)
		<li >{{$cat->nombre}} <i class="fa fa-pencil btn theme-c" onClick="categoria_edit(this , {{$cat->id}})"></i></li>
	@endforeach
</ul>
<?php $sub_categorias = SubCategoria::where('categoria_id','=',Input::get('categoria_id'))->get(); ?>
<ul>
	@foreach($sub_categorias as $cat)
		<li >{{$cat->nombre}} <i class="fa fa-pencil btn theme-c" onClick="sub_categoria_edit(this , {{$cat->id}})"></i></li>
	@endforeach
</ul>
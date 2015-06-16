

{{ Form::open(array('data-remote-cat','data-success' => 'Categoria Ingresada'))}}

<br>
{{ Form::_text('nombre') }}
<br>

<div class="categorias-detail lista-col2">
	<?php $categorias = Categoria::all(); ?>
	{{-- {{HTML::ul(Categoria::lists('nombre'))}}  --}}
	<ul>
		@foreach($categorias as $cat)
			<li >{{$cat->nombre}} <i class="fa fa-pencil btn theme-c" onClick="categoria_edit(this,{{$cat->id}})"></i></li>
		@endforeach
	</ul>

</div>

<div class="form-footer" align="right">

	{{ Form::submit('Crear!', array('class'=>'theme-button')) }}

</div>

{{ Form::close() }}

<style type="text/css">

	.Lightbox .modal-dialog {
		width: 650px !important;
	}

</style>

<script>
	$('form[data-remote-cat] input[name=nombre]').keyup(function(event) {
		var texto = $(this).val().toLowerCase();

		$(".categorias-detail ul li").css("display", "block");
		$(".categorias-detail ul li").each(function(){
			if($(this).text().toLowerCase().indexOf(texto) < 0)
				$(this).css("display", "none");
		});
	});
</script>

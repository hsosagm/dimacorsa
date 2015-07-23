{{ Form::open(array('data-remote-cat','data-success' => 'Sub Categoria Ingresada', 'class' => 'form-horizontal all'))}}
	<br>
	<?php $categoria = Categoria::find(Input::get('categoria_id')); ?>
	<input type="hidden" name="categoria_id" value="{{Input::get('categoria_id')}}">
	<div class="form-group">
		{{ Form::label('body', 'Categoria', array('class'=>'col-sm-2 control-label')) }} 
		<div class="col-sm-9 select-categorias">
			<input type="text" class="form-control" value="{{$categoria->nombre}}" readonly>
		</div>
	</div>
	{{ Form::_text('nombre') }}
	<div class="form-footer" align="right">
		{{ Form::submit('Crear!', array('class'=>'theme-button')) }}
	</div>
{{ Form::close() }}
<div class="edit_categorias"> </div>
<div class="categorias-detail lista-col1">
	<?php $sub_categorias = SubCategoria::where('categoria_id','=',Input::get('categoria_id'))->get(); ?>
	<ul>
		@foreach($sub_categorias as $cat)
			<li >{{$cat->nombre}} <i class="fa fa-pencil btn theme-c" onClick="sub_categoria_edit(this , {{$cat->id}})"></i></li>
		@endforeach
	</ul>
</div>

<style type="text/css">
	.Lightbox .modal-dialog {
		width: 650px !important;
	}
</style>

<script>
	$(function(){
		$("form[data-remote-cat] select[name=categoria_id]").change(function(){
			$.ajax({
				type: 'get',
				url: 'admin/sub_categorias/filtro',
				data: {categoria_id: $(this).val()},
				success: function (data) {
					$('.categorias-detail').html(data.lista);
					$('.select_sub_categorias').html(data.select);
				}
			});
		});
	});
</script>

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

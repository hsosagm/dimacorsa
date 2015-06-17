

{{ Form::open(array('data-remote-cat','data-success' => 'Sub Categoria Ingresada', 'class' => 'form-horizontal all'))}}
<br>
<div class="form-group">

	{{ Form::label('body', 'Categoria', array('class'=>'col-sm-2 control-label')) }} 

	<div class="col-sm-9 select-categorias">

		{{ Form::select('categoria_id',Categoria::lists('nombre', 'id'),'', array('class'=>'form-control'));}} 

	</div>

</div>

{{ Form::_text('nombre') }}

<div class="form-footer" align="right">

	{{ Form::submit('Crear!', array('class'=>'theme-button')) }}

</div>

{{ Form::close() }}


<div class="edit_categorias">
	
</div>

<div class="categorias-detail lista-col1">

	<ul>
		<li>Unasigned</li>
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
				},
				error: function(errors){
					msg.error('Hubo un error, intentelo de nuevo', 'Advertencia!');
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



{{ Form::_open($message) }}

<br>

{{ Form::_open('Producto creado') }}

<div class="form-producto">

	{{ Form::hidden('id', @$producto->id) }}

	{{ Form::_text("codigo", @$producto->codigo )}} 

	{{ Form::_text("descripcion",  @$producto->descripcion )}} 

	{{ Form::_text("p_publico",  @$producto->p_publico )}} 

	<div class="form-group">

		{{ Form::label('body', 'Marca', array('class'=>'col-sm-2 control-label')) }} 

		<div class="col-sm-9 select_marcas">

			{{ Form::select('marca_id',Marca::lists('nombre', 'id'),@$producto->marca_id, array('class'=>'form-control'));}} 

		</div>

	</div>

	<div class="form-group">

		{{ Form::label('body', 'Categoria', array('class'=>'col-sm-2 control-label')) }} 

		<div class="col-sm-9 select_categorias">

			{{ Form::select('categoria_id',Categoria::lists('nombre', 'id'),@$producto->categoria_id, array('class'=>'form-control'));}} 

		</div>

	</div>

	<div class="form-group">

		{{ Form::label('body', 'SubCategoria', array('class'=>'col-sm-2 control-label')) }} 

		<div class="col-sm-9 select_sub_categorias">

			{{Form::select('sub_categoria_id',array('unasigned'),@$producto->sub_categoria_id ,array('class'=>'form-control'))}} 

		</div>

	</div>

	<div class="form-group">

		{{ Form::label('body', 'Inactivo', array('class'=>'col-sm-2 control-label')) }}

		<div class="col-sm-9">

			@if($producto->inactivo==1)

			{{ Form::checkbox('Inactivo', '1', true); }} 

			@else

			{{ Form::checkbox('Inactivo', '0', false); }} 

			@endif

		</div>

	</div>

</div>

<div class="form-footer" align="right">

	{{ Form::submit('Actualizar!', array('class'=>'theme-button')) }}

</div>

{{ Form::close() }}

<style type="text/css">

	.bs-modal .modal-dialog{
		width: 450px !important;
	}

</style>

<style type="text/css">

    .bs-modal .Lightbox{
        width: 450px !important;
    }

</style>

<script>
	$(function(){
		$("form[data-remote] select[name=categoria_id]").change(function(){
			
			$.ajax({
				type: 'get',
				url: 'admin/sub_categorias/filtro',
				data: {categoria_id: $(this).val()},
				success: function (data) {
					$('.select_sub_categorias').html(data.select);
				},
				error: function(errors){
					msg.error('Hubo un error, intentelo de nuevo', 'Advertencia!');
				}
			});
		});
	});
</script>

<br> 

	{{Form::open(array('data-remote-product' ,'data-success' => 'Producto Creado'))}} 

	<div class="form-producto">

		{{ Form::_text('codigo') }}

		{{ Form::_text('descripcion') }}

		{{ Form::_text('p_publico') }}
		<div class="form-group">

			{{ Form::label('body', 'Marca', array('class'=>'col-sm-2 control-label')) }} 

			<div class="col-sm-9 select_marcas">

				{{ Form::select('marca_id',Marca::lists('nombre', 'id'),'', array('class'=>'form-control'));}} 

			</div>

		</div>

		<div class="form-group">

			{{ Form::label('body', 'Categoria', array('class'=>'col-sm-2 control-label')) }} 
			
			<div class="col-sm-9 select_categorias">

				{{ Form::select('categoria_id',Categoria::lists('nombre', 'id'),'', array('class'=>'form-control'));}} 

			</div>

		</div>

		<div class="form-group">

			{{ Form::label('body', 'SubCategoria', array('class'=>'col-sm-2 control-label')) }} 
			
			<div class="col-sm-9 select_sub_categorias">

				{{ Form::select('categoria_id', SubCategoria::where('categoria_id','=',1)->lists('nombre', 'id') , 1 , array('class' => 'form-control'));}}

			</div>

		</div>

		<div class="form-group">

			{{ Form::label('body', 'Inactivo', array('class'=>'col-sm-2 control-label')) }} 

			<div class="col-sm-9">

				{{ Form::checkbox('inactivo', '', false, array('class'=>'form-control') ); }} 

			</div>

		</div>

	</div>

	<div class="form-footer" align="right">
		{{ Form::button('Cancelar', array('class' => 'return_compras btn btn-warning'))}}
		{{ Form::submit('Crear!', array('class'=>'theme-button')) }}

	</div>

	{{ Form::close() }}

<style type="text/css">

	.producto-container {
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
		$("form[data-remote-product] select[name=categoria_id]").change(function(){
			
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

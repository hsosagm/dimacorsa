
{{Form::open(array('data-remote', 'data-success' => 'Producto Actualizado'))}}

{{ Form::hidden('id', @$producto->id) }}
<div class="form-edit-producto">
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-3"> Codigo: </div>
		<div class="col-md-7">
			<input type="text" name="codigo" value="{{$producto->codigo}}" class="form-control">
		</div>
		<div class="col-md-1"></div>
	</div>

	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-3"> Descripcion: </div>
		<div class="col-md-7">
			<input type="text" name="descripcion" maxlength="90" value="{{$producto->descripcion}}" class="form-control">
		</div>
		<div class="col-md-1"></div>
	</div>

	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-3"> Precio Publico: </div>
		<div class="col-md-7">
			<input type="text" name="p_publico" value="{{$producto->p_publico}}" class="form-control numeric">
		</div>
		<div class="col-md-1"></div>
	</div>

	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-3"> Marca: </div>
		<div class="col-md-7 select_marcas">
			{{ Form::select('marca_id',Marca::lists('nombre', 'id'),@$producto->marca_id, array('class'=>'form-control'));}}
		</div>
		<div class="col-md-1"></div>
	</div>

	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-3"> Categoria: </div>
		<div class="col-md-7 select_categorias">
			{{ Form::select('categoria_id',Categoria::lists('nombre', 'id'),@$producto->categoria_id, array('class'=>'form-control'));}}
		</div>
		<div class="col-md-1"></div>
	</div>

	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-3"> SubCategoria: </div>
		<div class="col-md-7 select_sub_categorias">
			{{Form::select('sub_categoria_id',array('unasigned'),@$producto->sub_categoria_id ,array('class'=>'form-control'))}}
		</div>
		<div class="col-md-1"></div>
	</div>


	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-3"> Existencia Minima: </div>
		<div class="col-md-7 select_sub_categorias">
			{{ Form::input('text', 'stock_minimo', '0', array('class' => 'form-control')) }} 
		</div>
		<div class="col-md-1"></div>
	</div>

	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-3"> Inactivo: </div>
		<div class="col-md-7">

			@if($producto->inactivo==1)
			{{ Form::checkbox('Inactivo', '1', true); }}
			@else
			{{ Form::checkbox('Inactivo', '0', false); }}
			@endif

		</div>
		<div class="col-md-1"></div>
	</div>
</div>
<div class="modal-footer">
	<input class="btn theme-button" type="submit" value="Enviar!" autocomplete="off">
</div>

{{ Form::close() }}


<script type="text/javascript">
    $('.numeric').autoNumeric({aSep:',', aNeg:'', mDec:2, mRound:'S', vMax: '999999.99', wEmpty: 'zero', lZero: 'deny', mNum:10});
</script>


<style type="text/css">

	.bs-modal .Lightbox{
		width:700px !important;
	}
	.form-edit-producto .row {
		margin-bottom:5px;
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


{{--  --}}

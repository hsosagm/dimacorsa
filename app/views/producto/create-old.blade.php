<div class="row">
<br>
	<div class="col-md-6">
		{{Form::open(array('data-remote-product' ,'data-success' => 'Producto Creado'))}}
		<div class="form-producto">
			<div class="form-group">
				<label for="body" class="col-sm-2 control-label">Codigo</label>
				<div class="col-sm-9">
					<input class="form-control" autocomplete="off" name="codigo" type="text" autofocus>
				</div>
			</div>
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
				{{ Form::label('body', 'Proveedor 1', array('class'=>'col-sm-2 control-label')) }}
				<div class="col-sm-9">
					{{ Form::select('proveedor1', Proveedor::lists('nombre', 'id') , 1 , array('class' => 'form-control'));}}
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('body', 'Proveedor 2', array('class'=>'col-sm-2 control-label')) }}
				<div class="col-sm-9">
					{{ Form::select('proveedor2', Proveedor::lists('nombre', 'id') , 1 , array('class' => 'form-control'));}}
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('body', 'Proveedor 3', array('class'=>'col-sm-2 control-label')) }}
				<div class="col-sm-9">
					{{ Form::select('proveedor3', Proveedor::lists('nombre', 'id') , 1 , array('class' => 'form-control'));}}
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('body', 'Inactivo', array('class'=>'col-sm-2 control-label')) }}
				<div class="col-sm-9">
					{{ Form::checkbox('inactivo', '', false, array('class'=>'form-control') ); }}
				</div>
			</div>
		</div>
		<div align="right" style="margin-right:45px">
			{{ Form::submit('Crear!', array('class'=>'theme-button')) }}
		</div>
		{{ Form::close() }}
	</div>
</div>

<script>
	$(function(){

		$("form[data-remote-product] input[name=codigo]").focusout(function(event) {
				generar_codigo_producto();
		});

		$("form[data-remote-product] input[name=descripcion]").focusin(function(event) {
				generar_codigo_producto();
		});

		function generar_codigo_producto()
		{
			var d = new Date();
			var month = d.getMonth()+1;
			var day = d.getDate();
			codigo_generado = d.getFullYear() +((''+month).length<2 ? '0' : '') + month +
			((''+day).length<2 ? '0' : '') + day + d.getHours()+d.getMinutes()+d.getSeconds();

			cod = $("form[data-remote-product] input[name=codigo]").val();
			if($.trim(cod) == "")
			{
				$("form[data-remote-product] input[name=codigo]").val(codigo_generado);
			}
		}

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

<h4>Nuevo Producto</h4>
<div class="row">
	<div class="col-md-6">
		{{Form::open(array('data-remote-product' ,'data-success' => 'Producto Creado'))}}
		{{ Form::hidden('marca_id')}}
		{{ Form::hidden('categoria_id')}}
		{{ Form::hidden('sub_categoria_id')}}
		<div class="row">
			<div class="col-md-8">
				<input class="form-control" name="codigo" type="text"  placeholder="Codigo" autofocus>
			</div>
			<div class="col-md-4">
				<input class="form-control" name="stock_minimo"  type="text"  placeholder="Exist. Min.">
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<input class="form-control" name="descripcion" maxlength="90"type="text" placeholder="Descripcion">
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<input class="form-control" name="p_publico" value="" placeholder="Precio publico" type="text">
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-10">
						<input class="form-control" id="buscarMarca" placeholder="Marca" type="text">
					</div>
					<div class="col-md-2">
						<i class="fa fa-plus-square btn-link theme-c" onclick="new_marca()"></i>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-10">
						<input class="form-control" id="buscarCategoria" placeholder="Categoria" type="text">
					</div>
					<div class="col-md-2">
						<i class="fa fa-plus-square btn-link theme-c" onclick="new_categoria()"></i>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-10">
						<input class="form-control" id="buscarSubCategoria" placeholder="Sub Categoria" type="text">
					</div>
					<div class="col-md-2">
						<i class="fa fa-plus-square btn-link theme-c" onclick="new_sub_categoria()"></i>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">&nbsp;&nbsp;Inactivo</div>
			<div class="col-md-3">
				{{ Form::checkbox('Inactivo', '0', false); }}
			</div>
			<div class="col-md-6" align="right">
				{{ Form::submit('Crear!', array('class'=>'theme-button')) }}
			</div>
		</div>
		{{ Form::close() }}
	</div>
	<div class="col-md-6 contenedor_categorias">

	</div>
</div>

<script>
	$(function(){

		// $("form[data-remote-product] input[name=codigo]").focusout(function(event) {
		// 	generar_codigo_producto();
		// });

		// $("form[data-remote-product] input[name=descripcion]").focusin(function(event) {
		// 	generar_codigo_producto();
		// });

		// function generar_codigo_producto()
		// {
		// 	var d = new Date();
		// 	var month = d.getMonth()+1;
		// 	var day = d.getDate();
		// 	codigo_generado = d.getFullYear() +((''+month).length<2 ? '0' : '') + month +
		// 	((''+day).length<2 ? '0' : '') + day + d.getHours()+d.getMinutes()+d.getSeconds();

		// 	cod = $("form[data-remote-product] input[name=codigo]").val();
		// 	if($.trim(cod) == "")
		// 	{
		// 		$("form[data-remote-product] input[name=codigo]").val(codigo_generado);
		// 	}
		// }

		$("#buscarMarca").autocomplete({
			serviceUrl: 'admin/marcas/buscar',
			onSelect: function (q) {
				$("input[name='marca_id']").val(q.id);
			}
		});

		$("#buscarCategoria").autocomplete({
			serviceUrl: 'admin/categorias/buscar',
			onSelect: function (q) {
				$("input[name='categoria_id']").val(q.id);

				$("#buscarSubCategoria").autocomplete({
					serviceUrl: 'admin/sub_categorias/buscar/'+q.id+'',
					onSelect: function (q) {

						$("input[name='sub_categoria_id']").val(q.id);
					}
				});
			}
		});
	});
</script>

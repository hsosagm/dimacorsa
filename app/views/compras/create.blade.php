
{{ Form::open(array('data-remote-md', 'data-success' => 'Compra Generada')) }}
{{ Form::hidden('proveedor_id') }}
<div class="row info_head">

	<div class="col-md-6 master-detail-info">
		
		<table class="master-table">
			<tr>
				<td>Proveedor:</td>
				<td>
					<input type="text" id="proveedor_id"> 
					<i class="fa fa-question-circle btn-link theme-c" id="proveedor_help"></i>
					<i class="fa fa-pencil btn-link theme-c" id="proveedor_edit"> </i>
					<i class="fa fa-plus-square btn-link theme-c" id="proveedor_create"></i>
				</td>
			</tr>
			<tr>
				<td>Factura No.: </td>
				<td>  <input type="text" name="numero_documento" id="desabilitar_input"> </td>
			</tr>
			<tr >
				<td> Fecha de Doc.:</td>
				<td><input type="text" name="fecha_documento" data-value="now()" id="desabilitar_input">  </td>
			</tr>
		</table>
	</div>

	<div class="col-md-6">
		<div class="row">
			<div class="col-md-12 search-proveedor-info"> </div>
		</div>
		<div class="row">
			<div class="col-md-12 proveedor-credito"> </div>
		</div>
	</div>

</div>

<div class="form-footer" align="right">
	{{ Form::submit('Ok!', array('class'=>'theme-button')) }}
</div>

{{ Form::close() }}

<div class="master-detail"> 
	<div class="master-detail-body"></div>
	
</div>

<script>

	$(function() {
		$("#proveedor_id").autocomplete({
			source: function (request, response) {
				$.ajax({
					url: "user/buscar_proveedor",
					dataType: "json",
					data: request,
					success: function (data) {
						response(data);
					},
					error: function () {
						response([]);
					}
				});
			},
			minLength: 3,
			select:function( data, ui ){
				$("input[name='proveedor_id']").val(ui.item.id);
				$(".search-proveedor-info").html('<strong>Direccion:  '+ui.item.descripcion+'</strong><br><strong>Contacto:   '+ui.item.value+'</strong>');

				$proveedor_id = ui.item.id;

				$.ajax({
					type: 'POST',
					url: 'admin/proveedor/total_credito',
					data: {proveedor_id:$proveedor_id},
					success: function (data) 
					{
						$(".proveedor-credito").html('<strong>Saldo   Q: '+data+'</strong>');
					},
					error: function(errors)
					{
						msg.error('Hubo un error, intentelo de nuevo', 'Advertencia!');
					}
				});
			},
			autoFocus: true,
			open: function(event, ui) {
				$(".ui-autocomplete").css("z-index", 100000);
			}
		});
	});

	$('form[data-remote-md] input[name="fecha_documento"]').pickadate(
	{
		max: true,
		disable: [7]
	});

</script>

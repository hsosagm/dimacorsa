 
{{ Form::open(array('data-remote-md', 'data-success' => 'Compra Generada' ,"onsubmit"=>" return false")) }}
{{ Form::hidden('proveedor_id') }}

<div class="row info_head">

	<div class="col-md-6 master-detail-info">
		
		<table class="master-table">

			<tr>

				<td>Proveedor:</td>

				<td>
					<input type="text" id="proveedor_id" class="input"> 
					<i class="fa fa-question-circle btn-link theme-c" id="proveedor_help"></i>
					<i class="fa fa-pencil btn-link theme-c" id="proveedor_edit"> </i>
					<i class="fa fa-plus-square btn-link theme-c" id="proveedor_create"></i>
				</td>

			</tr>

			<tr>

				<td>Factura No.: </td>

				<td>  <input type="text" name="numero_documento" class="input"> </td>

			</tr>

			<tr >

				<td> Fecha de Doc.:</td>

				<td><input type="text" name="fecha_documento" data-value="now()">  </td>

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

	$("#proveedor_id").autocomplete({
		serviceUrl: 'admin/proveedor/buscar',
		onSelect: function (q) {
			$("input[name='proveedor_id']").val(q.id);
			$(".search-proveedor-info").html('<strong>Direccion:  '+q.value+'</strong><br>');

			$proveedor_id = q.id;

			$.ajax({
				type: 'POST',
				url: 'admin/proveedor/total_credito',
				data: {proveedor_id:$proveedor_id},
				success: function (data) 
				{
					$(".proveedor-credito").html('<strong> '+data+'</strong>');
				},
				error: function(errors)
				{
					msg.error('Hubo un error, intentelo de nuevo', 'Advertencia!');
				}
			});

			var position = $(this).index('input');
			$("input, select").eq(position+1).select();
		}
	});

 $('form[data-remote-md] input[name="fecha_documento"]').pickadate(
 {
 	max: true,
 	disable: [7]
 });

</script>

				
			
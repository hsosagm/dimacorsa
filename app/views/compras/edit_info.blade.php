{{ Form::_open('Informacion de Compra actualizada') }}

<div class="row">

	<div class="col-md-6 master-detail-info">
		{{ Form::hidden('proveedor_id_info',$compra->proveedor_id) }}
		{{ Form::hidden('id',$compra->id) }}
		<table class="master-table-info">
			<tr>
				<td>Proveedor:</td>
				<td>
					<input type="text" id="proveedor_id" value="{{ $proveedor->nombre}}"> 
				</td>
			</tr>
			<tr>
				<td>Factura No.: </td>
				<td>  <input type="text" name="numero_documento"  value="{{$compra->numero_documento}}"> </td>
			</tr>
			<tr >
				<td> Fecha de Doc.:</td>
				<td><input type="text" name="fecha_documento" data-value="{{$compra->fecha_documento}}">  </td>
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

{{ Form::_submit('Enviar') }}

{{ Form::close() }}

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
				$("input[name='proveedor_id_info']").val(ui.item.id);
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

	$('form[data-remote] input[name="fecha_documento"]').pickadate(
	{
		max: true,
		disable: [7]
	});

</script>

<style type="text/css">

    .bs-modal .Lightbox{
        width: 750px !important;
    }

</style>
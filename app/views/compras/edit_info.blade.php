{{ Form::open(array('url' => '/admin/compras/OpenModalPurchaseInfo', 'data-remote-md-info', 'data-success' => 'Compra Actualizada', 'status' => '0')) }}

<div class="row">

	<div class="col-md-6 master-detail-info">
		<input type="hidden"  name="proveedor_id" id="proveedor_id_info" value="{{$proveedor->id}}">
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

<div class="modal-footer">
	<input class="btn theme-button" type="submit" value="Enviar!" autocomplete="off">
</div>

{{ Form::close() }}
<script>

	$("#proveedor_id").autocomplete({
		serviceUrl: 'admin/proveedor/buscar',
		onSelect: function (q) {
			$("#proveedor_id_info").val(q.id);
			$(".search-proveedor-info").html('<strong>Direccion:  '+q.value+'</strong><br>');
			$proveedor_id = q.id;

			$.ajax({
				type: 'POST',
				url: 'admin/proveedor/total_credito',
				data: {proveedor_id:$proveedor_id},
				success: function (data) 
				{
					$(".proveedor-credito").html('Saldo Total: <strong> Q '+data.saldo_total+'</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Saldo Vencido: <strong> Q '+data.saldo_vencido+'</strong>');
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

 $('form[data-remote-md-info] input[name="fecha_documento"]').pickadate(
	{
		max: true,
		disable: [7]
	});

</script>

<style type="text/css">

    .bs-modal .Lightbox{
        width: 850px !important;
    }

</style>
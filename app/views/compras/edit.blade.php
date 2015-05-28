 
{{ Form::open(array('data-remote-md', 'data-success' => 'Compra Generada' ,"onsubmit"=>" return false")) }}
{{ Form::hidden('proveedor_id',$proveedor->id) }}

<div class="row info_head">
	@include('compras.info_compra')
</div>

{{ Form::close() }}

<div class="master-detail"> 

	<div class="master-detail-body">
		@include('compras.detalle')
	</div>
	
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
					$(".proveedor-credito").html('<strong>Saldo   Q: '+data+'</strong>');
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

				
			
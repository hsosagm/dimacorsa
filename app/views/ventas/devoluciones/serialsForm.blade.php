<div id="serialsForm">
	<div class="row" id="serialsForm">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<input v-on="keyup: pushSerial | key 'enter'" type="text" id="input_serie" class="form-control">
		</div>
		<div class="col-md-1"> 
			<i v-on="click: pushSerial" class="fa fa-plus fg-theme"></i>
		</div>
	</div>

	<div class="serial-detalle">
		<table class="SerialTable">
			<thead>
				<th width="95%"></th>
				<th width="5%"></th>
			</thead>
			<tbody>
	            <tr v-repeat="serial: serials">
	                <td width="10%" class="view">@{{ serial }}</td>

	                <td width="5%">
	                    <i v-on="click: removeSerial($index, serial)" class="fa fa-trash-o pointer btn-link theme-c"></i>
	                </td>
	            </tr>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">

	new Vue({

		el: '#serialsForm',

		data: {
			serials: {{ $serials }} ? {{ $serials }} : []
		},

		ready: function()
		{
			setTimeout(function(){
				$('#input_serie').focus()
			},1000)
		},

		methods: {

			pushSerial: function(e)
			{
				var that = this
				var serie = $('#input_serie').val()

				if (!serie) return

                $.ajax({
                    type: 'POST',
                    url: 'user/ventas/devoluciones/post_detalle_devolulcion_serie',
                    data: { devolucion_detalle_id: devoluciones.detalleTable[{{$serial_index}}].id, serie:serie },
                }).done(function(data) {
                    if (!data.success == true)
                    	return msg.warning(data)

					that.serials.push(serie)
					devoluciones.detalleTable[{{$serial_index}}].serials.push(serie)
					$('#input_serie').val("")
                })
			},

			removeSerial: function(index, serie)
			{
				var that = this;
                $.ajax({
                    type: 'POST',
                    url: 'user/ventas/devoluciones/post_detalle_devolulcion_serie_delete',
                    data: { devolucion_detalle_id: devoluciones.detalleTable[{{$serial_index}}].id, serie:serie },
                }).done(function(data) {
                    if (!data.success == true)
                    	return msg.warning(data)

					that.serials.$remove(index)
					devoluciones.detalleTable[{{$serial_index}}].serials.$remove(index)
                })
			}
		}
	});

</script>
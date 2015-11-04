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

	<br>

	<div class="serial-detalle">
		<table class="SerialTable">
			<thead>
				<th width="95%"></th>
				<th width="5%"></th>
			</thead>
			<tbody>
	            <tr v-repeat="serial: serials">
	                <td width="10%" class="view" v-on="dblclick: editItem">@{{ serial }}</td>

	                <td width="5%">
	                    <i v-on="click: removeSerial($index)" class="fa fa-trash-o pointer btn-link theme-c"></i>
	                </td>
	            </tr>
			</tbody>
		</table>
	</div>

	<div class="modal-footer">
		<i class="fa fa-check fg-theme"></i>
	</div>

	<pre>@{{ $data | json  }}</pre>
</div>

<script type="text/javascript">

	new Vue({

		el: '#serialsForm',

		data: {
			serials: {{ $serials }} ? {{ $serials }} : [] //array()
		},

		ready: function()
		{
			setTimeout(function(){
				$('#input_serie').focus();
			},1000)
		},

		methods: {

			pushSerial: function(e)
			{
				$serie = $('#input_serie').val()

				if (!$serie) return

				this.serials.push($serie)
				devoluciones.detalleTable[{{$serial_index}}].serials.push($serie)
				$('#input_serie').val("")
			},

			removeSerial: function(index)
			{
				this.serials.$remove(index)
				devoluciones.detalleTable[{{$serial_index}}].serials.$remove(index)
			},

			editItem: function()
			{

			}
		}
	});

</script>
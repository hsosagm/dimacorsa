{{ Form::_text('ingreso_series','','Serie') }}

<div class="serial-detalle">

<table id="SerialTable">

	@if(count($data)>0)

		@for($i = 0 ; $i < count($data); $i++)

			<tr>
				<td width="100%">{{$data[$i]}}</td>
				<td><i class="fa fa-times btn-link theme-c" id=",{{$data[$i]}}" onclick="DeleteSerialCompra(this)"></i>
				</td>
			</tr>

		@endfor

	@endif

</table>

</div>
                
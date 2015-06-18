{{ Form::_text('InsertPurchaseItemSerials','','Serie') }}

<div class="serial-detalle">

<table id="SerialTable">

	@if(count($data)>0)

		@for($i = 0 ; $i < count($data); $i++)

			<tr>
				<td width="100%">{{$data[$i]}}</td>
				<td>
				@if($data[$i] != '')
					<i class="fa fa-times btn-link theme-c" id=",{{$data[$i]}}" onclick="DeletePurchaseItemSerials(this)"></i>
				@endif
				</td>
			</tr>

		@endfor

	@endif

</table>

</div>
                
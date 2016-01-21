@if(!$pagos)
	<tr class="tr_no_data" width="100%" style="cursor: default;">
		<td> {{ 'No se encontro ningun dato' }} </td>
	</tr>
@else
	<div style="border:1px solid #D5CBCB; background: #FFFFFF;">
		<table class="" id="example" cellspacing='0'>
			<thead class="theme-table-footer">
				<tr>
					<td class="center" widtd="17%">Fecha</td>
					<td class="center" widtd="13%">Usuario</td>
					<td class="center" widtd="24%">Cliente</td>
					<td class="center" widtd="28%">Descripcion</td>
					<td class="center" widtd="9%">Total</td>
					<td class="center" widtd="9%">{{$metodo_pago->descripcion}}</td>
				</tr>
			</thead>
			<tbody style="cursor: default;">
				@foreach($pagos as $q)
					<tr id="{{ $q->id }}">
						<td width="17%"> {{ $q->fecha }} </td>
						<td width="13%"> {{ $q->usuario }} </td>
						<td width="26%"> {{ $q->cliente }} </td>
						<td width="28%"> {{ $q->descripcion }} </td>
						<td class="right"  width="9%"> {{ f_num::get($q->total) }} </td>
						<td class="right"  width="9%"> {{ f_num::get($q->pago) }} </td>
					</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td colspan="7">
						<div style="float:right" class="pagination_caja"> {{ @$pagos->links() }} </div>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
@endif

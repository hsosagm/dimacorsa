@if(!$notasCreditos)
	<tr class="tr_no_data" width="100%" style="cursor: default;">
		<td> {{ 'No se encontro ningun dato' }} </td>
	</tr>
@else
	<div style="border:1px solid #D5CBCB">
		<table class="" id="example" cellspacing='0'>
			<thead class="theme-table-footer">
				<tr>
					<td class="center" widtd="15%">Fecha</td>
					<td class="center" widtd="25%">Usuario</td>
					<td class="center" widtd="50%">Descripcion</td>
					<td class="center" widtd="10%">{{$metodo_pago->descripcion}}</td>
				</tr>
			</thead>
			<tbody style="cursor: default;">
				@foreach($notasCreditos as $q)
					<tr id="{{ $q->id }}">
						<td                width="15%"> {{ $q->fecha }} </td>
						<td 			   width="25%"> {{ $q->usuario }} </td>
						<td                width="50%"> {{ $q->descripcion }} </td>
						<td class="right"  width="10%"> {{ f_num::get($q->total) }} </td>
					</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td colspan="7">
						<div style="float:right" class="pagination_caja"> {{ @$notasCreditos->links() }} </div>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
@endif
 
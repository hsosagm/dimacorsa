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
					<td class="center" widtd="40%">Cliente</td>
					<td class="center" widtd="9%">Total</td>
					<td class="center" widtd="9%">{{$metodo_pago->descripcion}}</td>
					<td class="center" widtd="12%">Acciones</td>
				</tr>
			</thead>
			<tbody style="cursor: default;">
				@foreach($pagos as $q)
					<tr id="{{ $q->id }}">
						<td                width="17%"> {{ $q->fecha }} </td>
						<td 			   width="13%"> {{ $q->usuario }} </td>
						<td                width="40%"> {{ $q->nombre_extra }} </td>
						<td class="right"  width="9%"> {{ f_num::get($q->total) }} </td>
						<td class="right"  width="9%"> {{ f_num::get($q->pago) }}</td>
						<td class="widthS center font14"  width="12%"> 
							<a href="javascript:void(0);" title="Ver detalle" onclick="{{$linkDetalle}}(this)" class="fa fa-plus-square show_detail"> </a>
						</td>
					</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td colspan="7">
						<div style="float:right" class="pagination_cierre{{Input::get('grafica')}}"> {{ @$pagos->links() }} </div>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
@endif

<style>
	.bs-modal-cierres .Lightbox{
        width: 900px !important;
    }
    .modal-body {
  		padding: 0px;
	}
</style>
<table class="DT_table_div" width="100%">
    <tr>
        <td class="center" width="25%">Fecha</td>
        <td class="center" width="50%">Cliente</td>
        <td class="center" width="10%">Saldo</td>
        <td class="center" width="10%">Totales</td>
        <td class="center" width="5%"></td>
    </tr>
	<tbody>
		@foreach ($ventas as $v)
			<tr>
				<td> {{ $v->created_at }} </td>
				<td> {{ $v->cliente->nombre }} </td>
				<td> {{ f_num::get($v->saldo) }} </td>
				<td> {{ f_num::get($v->total) }} </td>
				<td> 
					<i class="fa fa-search btn-link theme-c" onclick="DetalleVentaCierre(this, {{$v->id}})"></i> 
				</td>
			</tr>
		@endforeach
	</tbody>
</table>

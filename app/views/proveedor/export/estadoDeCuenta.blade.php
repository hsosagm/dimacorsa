<table width="100%">
	<tr>
		<td colspan="7" height="15"> 
			<strong>
				ESTADO DE CUENTA AL 
				<span style="color:#FB1212"> {{ Carbon::now()->day; }} </span> DE 
				<span style="color:#FB1212"> 
					{{ strtoupper(Traductor::getMes(Carbon::now()->formatLocalized('%B'))) }}
				</span> 
				DEL <span style="color:#FB1212">{{ Carbon::now()->year;}} </span>
			</strong>
		</td>
	</tr>
	<tr>
		<td  colspan="7" height="15">
			<strong>PROVEEDOR: <span style="color:#FB1212"> {{ strtoupper($proveedor->nombre) }} </span>  
		</td>
	</tr>
	<tr>
		<td colspan="7" height="15">
			<strong>DIRECCION: {{ strtoupper($proveedor->direccion) }}</strong>
		</td>
	</tr>
	<tr>
		<td colspan="7" height="15"> </td>
	</tr>
	@php($i = 0)
	@php($total = 0)
	<tr style="background-color: #D5D5D5;" height="15">
		<td align="center" width="10%"> <strong>No. Documento </strong> </td>
		<td align="center" width="20%"> <strong>Usuario </strong> </td>
		<td align="center" width="20%"> <strong>Fecha Venta</strong> </td>
		<td align="center" width="20%"> <strong>Fecha Vencimiento </strong> </td>
		<td align="center" width="10%"> <strong>Total </strong> </td>
		<td align="center" width="10%"> <strong>Saldo </strong> </td>
		<td align="center" width="10%"> <strong>Acumulado </strong> </td>
	</tr>
	@foreach($compras as $cp)
		<tr style="{{($i == 0)? '':'background-color: #ECECEC';}}" height="15">
			<td> {{ $cp->numero_documento }} </td>
			<td> {{ $cp->user->nombre.' '.$cp->user->apellido }} </td>
			<td> {{ $cp->created_at }} </td>
			<td> {{ Carbon::createFromFormat("Y-m-d H:i:s", $cp->created_at)->addDays(30); }} </td>
			<td align="right"> {{ f_num::get($cp->total) }} </td>
			<td align="right"> {{ f_num::get($cp->saldo); ($i==0)? $i=1: $i=0;}}</td>
			<td align="right"> {{ f_num::get($total += $cp->saldo);}}</td>
		</tr>
	@endforeach
</table>
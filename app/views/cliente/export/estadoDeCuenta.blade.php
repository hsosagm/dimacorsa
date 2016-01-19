

<table width="100%" style="">
	<tr>
		<td colspan="7" height="15">
			<img src="images/logo.jpg" width="auto" height="50"/>
		</td>
	</tr>
	<tr>
		<td colspan="7" height="15">
			<strong>DEPARTAMENTO DE CREDITOS Y COBROS</strong>
		</td>
	</tr>
	<tr>
		<td colspan="7" height="10"> </td>
	</tr>
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
			<strong>CLIENTE: <span style="color:#FB1212"> {{ strtoupper($cliente->nombre) }} </span>  
		</td>
	</tr>
	<tr>
		<td colspan="7" height="15">
			<strong>DIRECCION: {{ strtoupper($cliente->direccion) }}</strong>
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
	@foreach($ventas as $vt)
		<tr style="{{($i == 0)? '':'background-color: #ECECEC';}}" height="15">
			<td> {{ $vt->id }} </td>
			<td> {{ $vt->user->nombre.' '.$vt->user->apellido }} </td>
			<td> {{ $vt->created_at }} </td>
			<td> {{ Carbon::createFromFormat("Y-m-d H:i:s", $vt->created_at)->addDays($cliente->dias_credito); }} </td>
			<td align="right"> {{ f_num::get($vt->total) }} </td>
			<td align="right"> {{ f_num::get($vt->saldo); ($i==0)? $i=1: $i=0;}}</td>
			<td align="right"> {{ f_num::get($total += $vt->saldo);}}</td>
		</tr>
	@endforeach
</table>

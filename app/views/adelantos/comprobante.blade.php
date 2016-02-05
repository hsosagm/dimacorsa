<table width="100%" style="font-size:13px">
	<tr>
		<td> 
			<img src="images/logo.jpg" width="150"  height="90"/> 
		</td>
		<td>
			<strong>
				COMPROBANTE DE ADELANTO
			</strong>
			<br>
			Fecha: {{ Carbon::now() }}
		</td>
	</tr>
	<tr><td colspan="2" height="15"></td></tr>
	<tr>
		<td colspan="2"><strong>Nombre:</strong> {{ $adelanto->cliente->nombre }} </td>
	</tr>
	<tr>
		<td colspan="2"><strong>Direccion:</strong> {{ $adelanto->cliente->direccion }} </td>
	</tr>
	<tr>
		<td colspan="2"><strong>Nit:</strong> {{ $adelanto->cliente->nit }} </td>
	</tr>
</table>

@php($i = 0) 
@php($total = 0)

<table width="100%">
	<tr style="background:rgba(199, 199, 199, 0.21);">
		<td>Metodo de pago</td>
		<td>Monto</td>
	</tr>
	
	@foreach($adelanto->pagos as $dt)
	<tr style="{{($i == 1)?'background-color: #ECECEC;':'background-color: #FFFFFF;'}}">
		<td> {{ $dt->metodoPago->descripcion }} @php($total += $dt->monto)</td>
		<td style="text-align:right;"> {{ f_num::get($dt->monto) }} @php(($i == 0)? $i=1:$i=0) </td>
	</tr>
	@endforeach

	<tr>
		<td colspan="2" style="border-bottom:1px solid #444444; "></td>
	</tr>
	<tr>
		<td colspan="2" style="border-bottom:1px solid #444444; "></td>
	</tr>

	<tr>
		<td style="text-align:right;"> Total: </td>
		<td style="text-align:right;"> {{ f_num::get($total) }} </td>
	</tr>
</table>

<table width="100%" style="font-size:13px">
	<tr>
		<td colspan="4" style="height: 100px;"></td>
	</tr>
	<tr>
		<td colspan="4" align="center">_____________________________________________</td>
	</tr>
	<tr>
		<td colspan="4" align="center"> {{ Auth::user()->nombre.' '.Auth::user()->apellido.', '.Auth::user()->puesto->descripcion.', Correo: '.Auth::user()->email }} </td>
	</tr>
	<tr>
		<td colspan="4" style="text-align:center">
			- {{ Auth::user()->tienda->direccion }} Telefono: {{ Auth::user()->tienda->telefono }} - <br>
		</td>
	</tr>
</table

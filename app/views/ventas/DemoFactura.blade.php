
<div id="encabezado_factura">
	<table>

		<tr height="25"> 
			<td colspan="2"> Nits: {{$venta->cliente->nit}}  Fecha : {{ date('d-m-Y')}} </td>
		</tr >

		<tr height="25"> 
			<td colspan="4"> 
				{{ $venta->cliente->nombre .' '.$venta->cliente->apellido}}
				{{ $venta->cliente->direccion}}
			</td>
		</tr>
	</table>


	<div id="cuerpo_factura">
		<table>
		    <?php $total = 0; ?>

			@foreach($venta->detalle_venta as $key => $dt)
			    <tr>
			        <td valign="top" width="5%"> {{ $dt->cantidad }} </td>
			        <td valign="top" width="75%"> {{ $dt->producto->descripcion }} </td>
					<td valign="top" width="10%" align="right"> {{ f_num::get($dt->precio) }} </td>
					<td valign="top" width="10%" align="right"> {{ f_num::get($dt->cantidad * $dt->precio)}} </td>
			    </tr>
			@endforeach
		</table>
	</div>

	<table>
		<tr>
			<td width="65"></td>	
			<td width="425">Veintiseis mil seiscientos cincuenta y cinco quetzales con 15/100 centavos</td>
			<td width="65" align="right">90,909.99</td>
		</tr>
	</table>
</div>
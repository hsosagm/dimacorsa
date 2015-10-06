<div align="center">
	<h2>Cotizacion No: {{ $cotizacion->id }}</h2>
</div>

<table width="100%">
	<tr>
		<td> Nombre : </td>
		<td> {{ $cotizacion->cliente->nombre }} </td>
		<td> Correo : </td>
		<td> {{ $cotizacion->cliente->email }} </td>
	</tr>
	<tr>
		<td colspan="4" style="border-bottom:1px solid #444444; "></td>
	</tr>
    <tr>
		<td> Direccion : </td>
		<td colspan="3"> {{ $cotizacion->cliente->direccion }} </td>
	</tr>
	<tr>
		<td colspan="4" style="border-bottom:1px solid #444444; "></td>
	</tr>
	<tr>
		<td> Nit : </td>
		<td> {{ $cotizacion->cliente->nit }} </td>
		<td> Telefono : </td>
		<td> {{ $cotizacion->cliente->telefono }} </td>
	</tr>
	<tr>
		<td colspan="4" style="border-bottom:1px solid #444444; "></td>
	</tr>
</table>

<br>

<table width="100%">
    <tr style="background:rgba(199, 199, 199, 0.21);">
		<td colspan="4" style="border-bottom:1px solid #444444; "></td>
	</tr>
    <tr style="background:rgba(199, 199, 199, 0.21);">
        <td>Cantidad</td>
        <td>Descripcion</td>
        <td>Precio</td>
        <td>Total</td>
    </tr>
    <tr style="background:rgba(199, 199, 199, 0.21);">
		<td colspan="4" style="border-bottom:1px solid #444444; "></td>
	</tr> <?php $i = 0; $total = 0; ?>

    @foreach($cotizacion->detalle_cotizacion as $dt)

    <tr style="{{($i == 1)?'background-color: #ECECEC;':'background-color: #FFFFFF;'}}">
        <td> {{ $dt->cantidad }} </td>
        <td> {{ $dt->descripcion }} </td>
        <td style="text-align:right;"> {{ $dt->precio }} <?php $total += $dt->cantidad * $dt->precio; ?></td>
        <td style="text-align:right;"> {{ f_num::get($dt->cantidad * $dt->precio) }} <?php ($i == 0)? $i=1:$i=0; ?> </td>
    </tr>

    @endforeach
    <tr>
		<td colspan="4" style="border-bottom:1px solid #444444; "></td>
	</tr>
    <tr>
		<td colspan="4" style="border-bottom:1px solid #444444; "></td>
	</tr>
    <tr>
        <td>  </td>
        <td> </td>
        <td style="text-align:right;"> Total: </td>
        <td style="text-align:right;"> {{ f_num::get($total) }} </td>
    </tr>
    <tr>
		<td colspan="4" style="border-bottom:1px solid #444444; "></td>
	</tr>
</table>

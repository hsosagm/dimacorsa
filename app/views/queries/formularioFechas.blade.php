{{ Form::open(array('v-on="submit: getActualizarConsultasPorFecha"')) }}
	<table class="master-table">
		<tr class="col-md-5">
			<td class="col-md-4">Fecha inicial:</td>
			<td class="col-md-6"><input type="text"  name="fecha_inicial" data-value="{{$fecha_inicial}}"></td>
			<td class="col-md-2"></td>
		</tr>
		<tr class="col-md-5">
			<td class="col-md-4">Fecha final:</td>
			<td class="col-md-6"><input type="text"  name="fecha_final" data-value="{{$fecha_final}}"></td>
			<td class="col-md-2"></td>
		</tr>
		<tr class="col-md-1">
			<td><button class="btn btn-theme" type="submit" > Actualizar !</button></td>
		</tr>
		<tr class="col-md-1">
			<td><i title="Regresar" v-on="click: returnToMasterQueries" class="fa fa-reply" style="padding-left:50px; font-size:20px;"></i></td>
		</tr>
	</table>
{{Form::close()}}

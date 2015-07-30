<div style="padding-left:15px; padding-right:15px;">
	<div class="row">
		<div class="col-md-6">Impresoras</div>
		<div class="col-md-6">Nombre</div>
	</div>
	<div class="row">
		<div class="col-md-6 prueba_impresora">
			<button class="form-control fg-theme" onclick="cargar_impresoras_select()">Cargar Impresoras</button>
		</div>
		<div class="col-md-6">
			{{ Form::select('nombre', [ 'Factura' => 'Factura','Garantia' => 'Garantia', 'CodigoBarras' => 'Codigo de Barras', 'Comprobante' => 'Comprobantes'], '', array('class' => 'form-control')) }}
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12" align="center"><strong>Margenes (mm)</strong></div>
	</div>
	<div class="row" align="center">
		<div class="col-md-2">Izquierda</div>
		<div class="col-md-2">Derecha</div>
		<div class="col-md-2">Superior</div>
		<div class="col-md-2">Inferior</div>
		<div class="col-md-2">Ancho</div>
		<div class="col-md-2">Alto</div>
	</div>
	<div class="row">
		<div class="col-md-2"> {{ Form::number('', '0', array('class' => 'form-control')) }} </div>
		<div class="col-md-2"> {{ Form::number('', '0', array('class' => 'form-control')); }} </div>
		<div class="col-md-2"> {{ Form::number('', '0', array('class' => 'form-control')); }} </div>
		<div class="col-md-2"> {{ Form::number('', '0', array('class' => 'form-control')); }} </div>
		<div class="col-md-2"> {{ Form::number('', '0', array('class' => 'form-control')); }} </div>
		<div class="col-md-2"> {{ Form::number('', '0', array('class' => 'form-control')); }} </div>
	</div>
	<div class="row">
		<div class="col-md-12" align="right" style="padding-top:10px">
			<input class="btn-success theme-button " value="Guardar!" type="submit">
		</div>
	</div>
	<table width="100%">
		<thead>
			<tr style="border-bottom: 1px solid;">
				<th style="text-align: center;" colspan="2">Informacion</th>
				<th style="text-align: center;" colspan="6">Margenes</th>
			</tr>
			<tr>
				<th width="20%">Impresora</th>
				<th width="20%">Nombre</th>
				<th width="10%">Izquierda</th>
				<th width="10%">Derecha</th>
				<th width="10%">Superior</th>
				<th width="10%">Inferior</th>
				<th width="10%">Ancho</th>
				<th width="10%">Alto</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Impresora1</td>
				<td>Factura</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
			</tr>
			<tr>
				<td>Impresora2</td>
				<td>Garantia</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
			</tr>
			<tr>
				<td>Impresora3</td>
				<td>CodigoBarras</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
			</tr>
		</tbody>
	</table>
</div>
<br>

<style type="text/css"> .bs-modal .Lightbox{ width: 65% !important; } </style>
<script>
	function cargar_impresoras_select()
	{
		$.get( "admin/configuracion/getImpresoras/"+listado_de_impresoras, function( data ) {
			$(".prueba_impresora").html(data);
		});
	}
</script>
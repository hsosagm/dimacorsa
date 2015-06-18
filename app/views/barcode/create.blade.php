
{{ Form::_open('Estilo Actualizado') }}

<div id="barcode_live">
	{{ Form::hidden('id', @$estilo->id) }}

	<div class="form-group">
		<label for="body" class="col-sm-1 control-label">Tipo</label>
		<div class="col-sm-11">
			{{Form::select('tipo', array('code128' => 'code128', 'code39' => 'code39', 'ean13' => 'ean13'),$estilo->tipo, array('class'=>'form-control','id'=>'tipo_barcode'));}}
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label for="body" class="col-md-3 control-label">Ancho</label>
				<div class="col-sm-8">
					<input class="form-control" id="ancho_barcode" min="0" max="4" name="ancho" value="{{@$estilo->ancho}}" type="number">
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="body" class="col-md-3 control-label">Alto</label>
				<div class="col-sm-8">
					<input class="form-control" id="alto_barcode" min="0" max="100" name="alto" value="{{@$estilo->alto}}" type="number">
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="body" class="col-md-3 control-label">Letra</label>
				<div class="col-sm-8"><input class="form-control" id="letra_barcode" min="0" max="15" name="letra" value="{{@$estilo->letra}}" type="number">
				</div>
			</div>
		</div>
	</div>

	<div class="form-group">
		<label for="body" class="col-sm-1 control-label">Codigo</label>
		<div class="col-sm-11">
			<input class="form-control" id="codigo_barcode" placeholder="Codigo" name="codigo" value="{{@$estilo->codigo}}" type="text">
		</div>
	</div>
</div>

<div style="">
	{{ Form::_submit('Guardar Cambios') }}
</div>

{{ Form::close() }}

<div align="center" >
	<br>
	<div style="" align="center" id="live-code"></div>
</div>

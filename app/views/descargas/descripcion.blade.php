{{ Form::open(array('data-remote', 'data-success' => 'Descripcion ingresada', 'method' =>'post', 'class' => 'form-horizontal')) }}
	{{ Form::hidden('descarga_id', $descarga->id) }}
	<div class="form-group">
		<div class="col-sm-12">
			<textarea name="descripcion" class="form-control" rows="6">{{ $descarga->descripcion }}</textarea>
		</div>
	</div>
	<div class="modal-footer">
	    <input class="btn theme-button" value="Enviar!" autocomplete="off" type="submit">
	</div>
{{ Form::close() }}

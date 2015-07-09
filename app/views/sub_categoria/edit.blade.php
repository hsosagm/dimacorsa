<h4>&nbsp;&nbsp;Editar Sub Categoria</h4>
{{ Form::open(array('data-remote-cat-e','data-success' => 'Sub Categoria Modificada','onsubmit'=>'return false;'))}}
	{{ Form::hidden('id',$sub_categoria->id) }}
	{{ Form::hidden('categoria_id',$sub_categoria->categoria_id) }}
	<div class="row" style="margin-left:4px">
		<div class="col-md-3">
			Nuevo nombre:
		</div>
		<div class="col-md-5">
			<input type="text" name="nombre" value="{{ $sub_categoria->nombre }}" class="form-control">
		</div>
		<div class="col-md-4">
			<input type="submit" class="btn btn-theme" value="Guardar" onclick="guardar_edicion_categoria(this)">
			<input type="button" class="btn btn-warning" value="Cancelar" onclick="cancelar_edicion_categoria()">
		</div>
	</div> 
	<br>
{{ Form::close() }}
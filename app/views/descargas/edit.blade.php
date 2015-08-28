<div class="master-detail-body">
	<div class="row">
		<div class="col-md-6">
			Correlarivo: {{ $descarga_id }} 
			{{ Form::open(array('url' => '/admin/descargas/create', 'data-remote-md-d', 'data-success' => 'Descarga Generada', 'status' => '0')) }}
			{{ Form::hidden('producto_id') }}
			{{ Form::hidden('precio','',array('id'=>'precio-costo')) }}
			{{ Form::hidden('descarga_id', $descarga_id) }}
			<table class="master-table">
				<tr>
					<td>
						Codigo:  
						<i class="fa fa-search btn-link theme-c" id="md-search"></i>
					</td>
					<td>Cantidad:</td>
				</tr>
				<tr>
					<td>
						<input type="text" id="search_producto"> 
					</td>
					<td>
						<input class="input input_numeric" type="text" name="cantidad"> 
						<i onclick="ingresarProductoAlDetalle2(this)" class="fa fa-check fg-theme"></i>
					</td>
					<td>
						<i class="fa fa-th-list fa-lg fg-theme" title="Ingresar Descripcion" onclick="IngresarDescripcionDescarga(this,{{$descarga_id}});"></i>
					</td>
						
				</tr>
			</table>
			{{ Form::close() }}
		</div>
		<div class="col-md-6">
			<div class="row master-precios">
				<div class="col-md-4 precio-costo" style="text-align:left;"> </div>
				<div class="col-md-3 existencia" style="text-align:right;"> </div>
			</div>
			<div class="row master-descripcion">
				<div class="col-md-11 descripcion"> </div>
			</div>
		</div>
	</div>
</div>
<div class="body-detail">
	@include('descargas.detalle')
</div>

<div class="form-footer" >
	<?php $id_descarga = "'".Crypt::encrypt($descarga_id)."'";?>
    <div class="row">
        <div class="col-md-6">
            <i class="fa fa-print fa-lg icon-print" onclick="ImprimirDescarga(this, {{$id_descarga}})"></i>
        </div>
        <div class="col-md-6" align="right">
            <i class="fa fa-trash-o fa-lg icon-delete" onclick="EliminarDescarga(this,{{$descarga_id}});"></i>
            <i class="fa fa-check fa-lg icon-success" onclick="FinalizarDescarga(this,{{$descarga_id}})"></i>
        </div>
    </div>
</div>

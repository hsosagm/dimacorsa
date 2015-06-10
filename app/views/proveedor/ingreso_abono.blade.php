<div class="panel panel-tab rounded shadow">
	<div class="panel-heading no-padding">
		<ul class="nav nav-tabs nav-pills">
			<li class="active" id="saldo_vencido">
				<a aria-expanded="true" href="#tab1-1" data-toggle="tab">
					<i class="fa fa-money"></i> <span>Saldo Vencido</span>
				</a>
			</li>
			<li class="" id="saldo_total">
				<a aria-expanded="false" href="#tab1-2" data-toggle="tab">
					<i class="fa fa-money"></i> <span>Saldo Total</span>
				</a>
			</li>
			<li class="" id="saldo_parcial">
				<a aria-expanded="false" href="#tab1-3" data-toggle="tab">
					<i class="fa fa-money"></i> <span>Saldo Parcial</span>
				</a>
			</li>
		</ul>
	</div>

	<div class="panel-body tab-content panel-body-abonos">

		<div class="tab-pane fade inner-all active in" id="tab1-1">
			{{ Form::open(array('data-remote-OverdueBalance','onsubmit'=>"return false")) }} 
				<input type="hidden" name="proveedor_id" value="{{Input::get('proveedor_id')}}">
				<div class="row">
					<div class="form-group">
						<div class="col-md-5">
						<input type="hidden" value="{{(@$saldo_vencido == null) ? '0' : @$saldo_vencido; }}" name="monto">
							<input class="form-control" type="text" value="{{(@$saldo_vencido == null) ? '0' : @$saldo_vencido; }}" disabled="true">
						</div>
						<div class="col-md-5">
							{{ Form::select('metodo_pago_id', MetodoPago::lists('descripcion', 'id') ,'', array('class'=>'form-control')) }}
						</div>
						<div class="col-md-2">
							<button class="form-control">nota</button>
						</div>
					</div>
				</div>

				<div class="OverdueBalance_Details">

				</div>

				<div class="form-footer" align="right">
					<button class="btn btn-default" data-dismiss="modal" type="button">Cerrar!</button>
					<input  class="btn theme-button" type="submit" value="Enviar" >
				</div>
			{{Form::close()}}
		</div>

		<div class="tab-pane fade inner-all" id="tab1-2">
			{{ Form::open(array('data-remote-FullBalance')) }} 
				<input type="hidden" name="proveedor_id" value="{{Input::get('proveedor_id')}}">
				<div class="row">
					<div class="form-group">
						<div class="col-md-5">
							<input type="hidden" value="{{(@$saldo_total == null) ? '0' : @$saldo_total; }}" name="monto">
							<input class="form-control" type="text" value="{{(@$saldo_total == null) ? '0' : @$saldo_total; }}" disabled="true">
						</div>
						<div class="col-md-5">
							{{ Form::select('metodo_pago_id', MetodoPago::lists('descripcion', 'id') ,'', array('class'=>'form-control')) }}
						</div>
						<div class="col-md-2">
							<button class="form-control">nota</button>
						</div>
					</div>
				</div>

				<div class="FullBalance_Details">

				</div>
				<div class="form-footer" align="right">
					<button class="btn btn-default" data-dismiss="modal" type="button">Cerrar!</button>
					<input  class="btn theme-button" type="submit" value="Enviar" >
				</div>
			{{Form::close()}}
		</div>

		<div class="tab-pane fade inner-all" id="tab1-3">
			{{ Form::open(array('data-remote-PartialBalance')) }}
				<input type="hidden" name="proveedor_id" value="{{Input::get('proveedor_id')}}">
				<div class="row">
					<div class="form-group">
						<div class="col-md-5">
							<input class="form-control" type="text" name="monto" placeholder="Monto" >
						</div>
						<div class="col-md-5">
							{{ Form::select('metodo_pago_id', MetodoPago::lists('descripcion', 'id') ,'', array('class'=>'form-control')) }}
						</div>
						<div class="col-md-2">
							<button class="form-control">nota</button>
						</div>
					</div>
				</div>

				<div class="PartialBalance_Details" style="height: 115px !important">

				</div>

				<div class="form-footer" align="right">
					<button class="btn btn-default" data-dismiss="modal" type="button">Cerrar!</button>
					<input  class="btn theme-button" type="submit" value="Enviar" >
				</div>
			{{Form::close()}}
		</div>
	</div>

	

</div>

<style> 
	.modal-body { padding: 0px 0px 0px; } 
	.bs-modal .Lightbox{ width: 450px !important;}
</style>


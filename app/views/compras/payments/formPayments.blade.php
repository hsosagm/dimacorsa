
<div class="panel panel-tab rounded shadow">
	<div class="panel-heading no-padding">
		<ul class="nav nav-tabs nav-pills">
			<li class="active" id="saldo_vencido">
				<a aria-expanded="true" href="#tab1" data-toggle="tab">
					<i class="fa fa-paypal"></i> <span>Saldo Vencido</span>
				</a>
			</li>
			<li class="" id="saldo_total">
				<a aria-expanded="false" href="#tab2" data-toggle="tab">
					<i class="fa fa-paypal"></i> <span>Saldo Total</span>
				</a>
			</li>
			<li class="" id="saldo_parcial">
				<a aria-expanded="false" href="#tab3" data-toggle="tab">
					<i class="fa fa-paypal"></i> <span>Saldo Parcial</span>
				</a>
			</li>
			<li>
				<a aria-expanded="false" href="#tab4" data-toggle="tab" onclick="GetPurchasesForPaymentsBySelection(1,'');">
					<i class="fa fa-paypal"></i> <span>Seleccionar Compras</span>
				</a>
			</li>
		</ul>
	</div>

	<div class="panel-body tab-content panel-body-abonos">

		<div class="tab-pane fade inner-all active in" id="tab1">
			{{ Form::open(array('data-remote-OverdueBalance','onsubmit'=>"return false")) }} 
				<input type="hidden" name="proveedor_id" value="{{Input::get('proveedor_id')}}">
				<div class="row">
					<div class="form-group">
						<div class="col-md-6">
							<label> Q {{(@$saldo_vencido == null) ? '0.00' : f_num::get(@$saldo_vencido); }} </label>
						</div>
						<div class="col-md-6">
							{{ Form::select('metodo_pago_id', MetodoPago::where('id','!=',2)->lists('descripcion', 'id') ,'', array('class'=>'form-control')) }}
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-12">
						<TEXTAREA name="observaciones" row="1" class="form-control"> </TEXTAREA>
					</div>
				</div>
				<br>
				<div class="abonosDetalle_detail">
					<div class="form-footer" align="right">
						<input  class="btn theme-button" type="submit" value="Enviar" >
					</div>
				</div>
			{{Form::close()}}
		</div>

		<div class="tab-pane fade inner-all" id="tab2">
			{{ Form::open(array('data-remote-FullBalance')) }} 
				<input type="hidden" name="proveedor_id" value="{{Input::get('proveedor_id')}}">
				<div class="row">
					<div class="form-group">
						<div class="col-md-6">
							<label> Q {{(@$saldo_total == null) ? '0.00' : f_num::get(@$saldo_total); }} </label>
						</div>
						<div class="col-md-6">
							{{ Form::select('metodo_pago_id', MetodoPago::where('id','!=',2)->lists('descripcion', 'id') ,'', array('class'=>'form-control')) }}
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-12">
						<TEXTAREA name="observaciones" row="1" class="form-control"> </TEXTAREA>
					</div>
				</div>

				<div class="abonosDetalle_detail">
					<div class="form-footer" align="right">
						<input  class="btn theme-button" type="submit" value="Enviar" >
					</div>
				</div>
			{{Form::close()}}
		</div>

		<div class="tab-pane fade inner-all" id="tab3">
			{{ Form::open(array('data-remote-PartialBalance')) }}
				<input type="hidden" name="proveedor_id" value="{{Input::get('proveedor_id')}}">
				<div class="row">
					<div class="form-group">
						<div class="col-md-6">
							<input class="form-control" type="text" name="total" placeholder="Monto" >
						</div>
						<div class="col-md-6">
							{{ Form::select('metodo_pago_id', MetodoPago::where('id','!=',2)->lists('descripcion', 'id') ,'', array('class'=>'form-control')) }}
						</div>
					</div>
					<br>
					<br>
					<div class="row">
						<div class="col-md-12">
							<TEXTAREA name="observaciones" row="1" class="form-control"> </TEXTAREA>
						</div>
					</div>
				</div>

				<div class="abonosDetalle_detail">
					<div class="form-footer" align="right">
						<input  class="btn theme-button" type="submit" value="Enviar" >
					</div>
				</div>
			{{Form::close()}}
		</div>

		<div class="tab-pane fade inner-all abonosDetalle" id="tab4">Cargando . . .</div>

	</div>
	<div class="prueba"></div>
</div>
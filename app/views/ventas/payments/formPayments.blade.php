 		<div class="panel rounded shadow">
 			<div class="panel-heading">
 				<div class="DTTT btn-group"></div>
 				<div class="pull-right">
                    <button v-on="click: closeMainContainer" class="btn" title="Cerrar"><i class="fa fa-times"></i></button>
 				</div>
 				<div class="clearfix"></div>
 			</div>
 			<div class="PanelBody panel-body no-padding">
 				<div id="formPayments" class="panel panel-tab rounded shadow">

 					<div class="panel-heading no-padding">
 						<ul class="nav nav-tabs nav-pills">
 							<li class="active" id="saldo_vencido">
 								<a aria-expanded="true" href="#tab1" data-toggle="tab">
 									<i class="fa fa-paypal"></i> <span>Saldo Vencido</span>
 								</a>
 							</li>

 							<li>
 								<a aria-expanded="false" href="#tab4" data-toggle="tab" onclick="GetSalesForPaymentsBySelection(1, null);">
 									<i class="fa fa-paypal"></i> <span>Seleccionar ventas</span>
 								</a>
 							</li>
 						</ul>
 					</div>

 					<div class="tab-content divFormPayments">
 						<div class="tab-pane fade inner-all active in" id="tab1">
 							{{ Form::open(array('v-show="!tableDetail" v-on="submit: submitFormPayments"')) }}
 							<input type="hidden" name="cliente_id" v-model="cliente_id">
 							<div class="form-group">
 								<div class="col-md-7">

 									<label class="col-md-4 control-label">Seleccione monto</label>

 									<div class="col-md-8">
 										<div class="radio-inline rdio rdio-theme">
 											<input v-on="click: montoFocus" v-model="saldoParcial" id="radio3" type="radio" name="monto" checked></input>
 											<label for="radio3">Parcial</label>
 										</div>

 										<div class="radio-inline rdio rdio-theme">
 											<input v-on="click: resetSaldoParcial" value="@{{saldo_total}}" id="radio2" type="radio" name="monto"></input>
 											<label for="radio2">Total</label>
 										</div>
 										<div class="radio-inline rdio rdio-theme">
 											<input v-on="click: resetSaldoParcial" value="@{{saldo_vencido}}" id="radio1" type="radio" name="monto"></input>
 											<label for="radio1">Vencido</label>
 										</div>
 									</div>

 									<div class="form-group" style="margin-top:10px;">
 										<div class="col-md-4">
 											<input v-show="saldoParcial" v-on="keyup: setMonto" type="text" class="form-control montoAbono">
 											<input id="monto" type="text" v-model="monto" name="monto" value="0" class="hide">
 										</div>

 										<div class="col-md-4">
 											{{ Form::select('metodo_pago_id', MetodoPago::where('id','!=',2)->where('id','!=',6)->where('id','!=',7)->lists('descripcion', 'id') ,'', array('class'=>'form-control')) }}
 										</div>

 										<div class="col-md-2">
 											<input v-show="!tableDetail" class="btn theme-button" type="submit" value="Enviar">
 										</div>
 									</div>

 									<div class="form-group">
 										<div class="col-md-10" style="margin-top:10px;">
 											<textarea name="observaciones" class="form-control" placeholder="Comentario ..." rows="2"></textarea>
 										</div>
 									</div>

 								</div>

 								<div class="col-md-5">
 									<div>
 										<div class="col-md-6">
 											<label>Usted abonara: </label>
 										</div>
 										<div class="col-md-4" style="text-align:right;">
 											<label>@{{ monto | currency ' ' }}</label>
 										</div>
 									</div>

 									<div>
 										<div class="col-md-6">
 											<label>Su nuevo saldo sera: </label>
 										</div>
 										<div class="col-md-4" style="text-align:right;">
 											<label>@{{ saldo_total - monto | currency ' ' }}</label>
 										</div>
 									</div>
 								</div>
 							</div>
 							{{Form::close()}}

 							<div v-html="tableDetail" class="row" style="min-height:150px;"></div>
 						</div>
 						<div v-html="divAbonosPorSeleccion" class="tab-pane fade inner-all" id="tab4">Cargando . . .</div>
 					</div>
 				</div>

 				<script type="text/javascript">
 					$('.montoAbono').autoNumeric({ aNeg:'', mDec:2, mRound:'S', vMax: '999999.99', wEmpty: 'zero', lZero: 'deny', mNum:10});
 				</script>
 			</div>
 		</div>
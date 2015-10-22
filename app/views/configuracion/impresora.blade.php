<div class="panel">

	<div class="panel-heading">
		<div class="pull-left">
			<h3 class="panel-title fg-theme">Configurar Impresoras</h3>
		</div>
		<div class="pull-right">
			<button title="" data-original-title="" class="btn btn-sm" data-action="remove" onclick="$('.dt-container-cierre').hide();" data-toggle="tooltip" data-placement="top" data-title="cerrar"><i class="fa fa-times fg-theme"></i></button>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="panel-body">
		<div  class="panel panel-tab rounded shadow">

			<div class="panel-heading no-padding">
				<ul class="impresoras nav nav-tabs nav-pills">
					<li class="active" width="25%">
						<a aria-expanded="true" href="#tab1" data-toggle="tab">
							<i class="fa fa-print"></i> <span>Factura</span>	
						</a>
					</li>
					<li width="25%">
						<a aria-expanded="false" href="#tab2" data-toggle="tab">
							<i class="fa fa-print"></i> <span>Garantia</span>
						</a>
					</li>
					<li width="25%">
						<a aria-expanded="false" href="#tab3" data-toggle="tab">
							<i class="fa fa-print"></i> <span>Comprobante</span>
						</a>
					</li>
					<li width="25%">
						<a aria-expanded="false" href="#tab4" data-toggle="tab">
							<i class="fa fa-print"></i> <span>Codigo de Barras</span>
						</a>
					</li>
				</ul>
			</div>
			

			<div class="tab-content divFormPayments">

				<div class="tab-pane fade inner-all active in" id="tab1">
					{{ Form::_open('Configuracion de factura guardada') }}
						<div class="row">
							<div class="col-md-12">
								<h3>Configuracion factura</h3>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-3"> 
								Elija una Impresora
								<div class="list_impresoras_factura">
									<i onclick="cargar_impresoras_select(this)" class="form-control brn btn-info">Cargar Impresoras</i>
								</div>
							</div>
							<div class="col-md-2">
								<br>
								<input class="btn theme-button" type="submit" value="Enviar!" autocomplete="off">
							</div>
							<div class="col-md-2"> </div>
							<div class="col-md-5" align="center">
								<img src="images/otros/view.jpg" height=100 width=80>
							</div>
						</div>
					{{ Form::close() }}
				</div>

				<div class="tab-pane fade inner-all" id="tab2">
					{{ Form::_open('Configuracion de garantia guardada') }}
						<div class="row">
							<div class="col-md-12">
								<h3>Configuracion garantia</h3>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-3"> 
								Elija una Impresora
								<div class="list_impresoras_garantia">
									<i onclick="cargar_impresoras_select(this)" class="form-control brn btn-info">Cargar Impresoras</i>
								</div>
							</div>
							<div class="col-md-2">
								<br>
								<input class="btn theme-button" type="submit" value="Enviar!" autocomplete="off">
							</div>
							<div class="col-md-2"> </div>
							<div class="col-md-5" align="center">
								<img src="images/otros/view.jpg" height=100 width=80>
							</div>
						</div>
					{{ Form::close() }}
				</div>

				<div class="tab-pane fade inner-all" id="tab3">
					{{ Form::_open('Configuracion de comprobante guardada') }}
						<div class="row">
							<div class="col-md-12">
								<h3>Configuracion comprobante</h3>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-3"> 
								Elija una Impresora
								<div  class="list_impresoras_comprobante">
									<i onclick="cargar_impresoras_select(this)" class="form-control brn btn-info">Cargar Impresoras</i>
								</div>
							</div>
							<div class="col-md-2">
								<br>
								<input class="btn theme-button" type="submit" value="Enviar!" autocomplete="off">
							</div>
							<div class="col-md-2"> </div>
							<div class="col-md-5" align="center">
								<img src="images/otros/view.jpg" height=100 width=80>
							</div>
						</div>
					{{ Form::close() }}
				</div>

				<div class="tab-pane fade inner-all" id="tab4">
					{{ Form::_open('Configuracion de codigo de barras guardada') }}
						<div class="row">
							<div class="col-md-12">
								<h3>Configuracion condigo de barras</h3>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-3"> 
								Elija una Impresora
								<div class="list_impresoras_codigoBarra">
									<i onclick="cargar_impresoras_select(this)" class="form-control brn btn-info">Cargar Impresoras</i>
								</div>
							</div>
							<div class="col-md-2">
								<br>
								<input class="btn theme-button" type="submit" value="Enviar!" autocomplete="off">
							</div>
							<div class="col-md-2"> </div>
							<div class="col-md-5" align="center">
								<img src="images/otros/view.jpg" height=100 width=80>
							</div>
						</div>
					{{ Form::close() }}
				</div>

			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function cargar_impresoras_select(e)
	{
		listado_de_impresoras = listado_de_impresoras.split(' ').join('');
		listado_de_impresoras = listado_de_impresoras.split('/').join('');

		$.get( "admin/configuracion/getImpresoras/"+listado_de_impresoras, function( data ) {
			$('.list_impresoras_factura').html(data.factura);
			$('.list_impresoras_garantia').html(data.garantia);
			$('.list_impresoras_comprobante').html(data.comprobante);
			$('.list_impresoras_codigoBarra').html(data.codigoBarra);
		});

		return false;
	}
</script>
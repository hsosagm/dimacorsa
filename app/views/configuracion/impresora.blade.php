{{ Form::_open('Configuracion Guardada') }}

<div id="formPayments" class="panel panel-tab rounded shadow">
	<div class="panel-heading no-padding">
		<ul class="impresoras nav nav-tabs nav-pills">
			<li class="active" width="23%">
				<a aria-expanded="true" href="#tab1" data-toggle="tab">
					<i class="fa fa-print"></i> <span>Factura</span>	
				</a>
			</li>
			<li width="23%">
				<a aria-expanded="false" href="#tab2" data-toggle="tab">
					<i class="fa fa-print"></i> <span>Garantia</span>
				</a>
			</li>
			<li width="23%">
				<a aria-expanded="false" href="#tab3" data-toggle="tab">
					<i class="fa fa-print"></i> <span>Comprobante</span>
				</a>
			</li>
			<li width="23%">
				<a aria-expanded="false" href="#tab4" data-toggle="tab">
					<i class="fa fa-print"></i> <span>Codigo de Barras</span>
				</a>
			</li>
			<li width="8%">
				<a aria-expanded="false" href="#" onclick="$('.dt-container-cierre').hide();"  data-toggle="tab">
					<i class="fa fa-times"></i> <span>Cerrar</span>
				</a>
			</li>
		</ul>
	</div>


	<div class="tab-content divFormPayments">
		<div class="tab-pane fade inner-all active in" id="tab1">
			<div class="row">
				<div class="col-md-12"><h3>Configuracion factura</h3></div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-3"> 
					<h4>Elija una Impresora</h5>
					<div class="list_impresoras_factura">
						<i class="form-control bg-theme" onclick="cargar_impresoras_select(this)">Cargar Impresoras</i>
					</div>
				</div>
				<div class="col-md-4"> </div>
				<div class="col-md-5" align="center">
					<img src="images/otros/view.jpg" height=100 width=80>
				</div>
			</div>
		</div>
		<div class="tab-pane fade inner-all" id="tab2">
			<div class="row">
				<div class="col-md-12"><h3>Configuracion garantia</h3></div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-3"> 
					<h4>Elija una Impresora</h5>
					<div class="list_impresoras_garantia">
						<i class="form-control bg-theme" onclick="cargar_impresoras_select(this)">Cargar Impresoras</i>
					</div>
				</div>
				<div class="col-md-4"> </div>
				<div class="col-md-5" align="center">
					<img src="images/otros/view.jpg" height=100 width=80>
				</div>
			</div>

		</div>
		<div class="tab-pane fade inner-all" id="tab3">
			<div class="row">
				<div class="col-md-12"><h3>Configuracion comprobante</h3></div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-3"> 
					<h4>Elija una Impresora</h5>
					<div  class="list_impresoras_comprobante">
						<i onclick="cargar_impresoras_select(this)" class="form-control bg-theme">Cargar Impresoras</i>
					</div>
				</div>
				<div class="col-md-4"> </div>
				<div class="col-md-5" align="center">
					<img src="images/otros/view.jpg" height=100 width=80>
				</div>
			</div>
			
		</div>
		<div class="tab-pane fade inner-all" id="tab4">
			<div class="row">
				<div class="col-md-12"><h3>Configuracion condigo de barras</h3></div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-3"> 
					Elija una Impresora
					<div class="list_impresoras_codigoBarra">
						<i class="form-control bg-theme" onclick="cargar_impresoras_select(this)">Cargar Impresoras</i>
					</div>
				</div>
				<div class="col-md-4"> </div>
				<div class="col-md-5" align="center">
					<img src="images/otros/view.jpg" height=100 width=80>
				</div>
			</div>
		</div>
		<hr>
			<div class="row">
				<div class="col-md-4"> </div>
				<div class="col-md-6"> </div>
				<div class="col-md-2">
    				<input class="btn theme-button" type="submit" value="Enviar!" autocomplete="off">
				</div>
			</div>
			<br>
	</div>
</div>


{{ Form::close() }}
<script>
	function cargar_impresoras_select(e)
	{
		$.get( "admin/configuracion/getImpresoras/"+listado_de_impresoras, function( data ) {
			$('.list_impresoras_factura').html(data.factura);
			$('.list_impresoras_garantia').html(data.garantia);
			$('.list_impresoras_comprobante').html(data.comprobante);
			$('.list_impresoras_codigoBarra').html(data.codigoBarra);
		});

		return false;
	}
</script>
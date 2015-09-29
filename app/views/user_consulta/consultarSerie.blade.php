<div class="panel panel-default">
	<div class="panel-heading">
		<div class="pull-left">
			<h3 class="panel-title fg-theme ">Buscar Series</h3>
		</div>
		<div class="pull-right">
			<button class="btn btn-sm" data-action="remove" onclick="$('#graph_container').hide();" data-toggle="tooltip" data-placement="top" data-title="cerrar"><i class="fa fa-times fg-theme"></i></button>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-7">
				<input type="text" class="form-control inputSerieParaConsultar">
			</div>
			<div class="col-md-1">
				<button type="button" onclick="setConsultarSerie(this)" class="form-control btn-theme">Buscar</button>
			</div>
			<div class="col-md-2"></div>
		</div>
		<div class="row" style="margin-top:25px">
			<div class="col-md-2"></div>
			<div class="col-md-8 resultadoDeBusquedaDeSerie"></div>
			<div class="col-md-2"></div>
		</div>
	</div>
</div>
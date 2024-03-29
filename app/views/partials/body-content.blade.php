<!-- Start body content -->
<div class="body-content animated fadeIn">

	{{-- <h1 class="tienda_nombre"> {{ $tienda->nombre }} </h1> --}}
	<p style="position:fixed; opacity: 0.6; top:200px; right: -100px; width: 100%; text-align: center;"><img src="img/logo.jpg" width="440" height="450"></p>

	<div id="print_test"></div>
	<div id="garantiaContainer" style="display:none; z-index:-1;" style="background-color:#FFFFFF !important;"></div>

	<!-- FORMS -->
	<div id="forms" class="form-container col-md-10">
		<div class="panel form-h form-panel shadow" id="formsContainerVue">
			<div align="right">
				<div class="panel-heading custom-form">
					<div class="pull-left"> <h3 class="panel-title"></h3> </div>
					<div class="pull-right">
						<button class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></button>
						<button class="btn btn-sm" data-action="remove" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Cerrar"><i class="fa fa-times"></i></button>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="panel-body no-padding">
				<div class="form-horizontal forms"></div>
			</div>
		</div>
	</div>

	<div class="producto-container col-md-9">
		<div class="panel form-h producto-panel shadow">
			<div align="right">
				<div class="panel-heading custom-producto">
					<div class="pull-left"> <h3 class="producto-title"></h3> </div>
					<div class="pull-right">
						<button class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></button>
						<button class="btn btn-sm" data-action="remove" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Cerrar"><i class="fa fa-times"></i></button>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="panel-body no-padding">
				<div class="form-horizontal forms-producto"></div>
			</div>
			<div>
				<div class="panel-heading footer-heading">
				</div>
			</div>
		</div>
	</div>

	<!-- TABLES -->
	<div class="dt-container col-md-11">
		<div class="panel dt-panel rounded shadow">
			<div class="panel-heading">
				<div id="table_length" class="pull-left"><h3 class="table-title"></h3></div>
				<div class="DTTT btn-group"></div>
				<div class="pull-right">
					<button class="btn" data-action="collapse_head" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></button>
					<button class="btn btnremove" data-action="remove" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Cerrar"><i class="fa fa-times"></i></button>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-body no-padding table"></div>
		</div>
	</div>

	<div id="graph_container" class="col-md-11"></div>

	<!-- dt-container para cierres -->
	<div class="dt-container-cierre col-md-11"></div>

	<!-- MODAL -->
	<div class="col-lg-3 col-md-4 col-sm-6">
		<div class="modal modal-info fade bs-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="Lightbox modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" aria-hidden="true" data-dismiss="modal" type="button">×</button>
						<h4 class="modal-title"></h4>
					</div>
					<div class="modal-body"></div>
				</div>
			</div>
		</div>
	</div>

	<!-- MODAL -->
	<div class="col-lg-3 col-md-4 col-sm-6">
		<div class="modal modal-info fade bs-modal-consultas" data-backdrop="static" data-keyboard="false" tabindex="-100" role="dialog" aria-hidden="true">
			<div class="Lightbox modal-dialog-c">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" aria-hidden="true" data-dismiss="modal" type="button">×</button>
						<h4 class="modal-title-consultas"></h4>
					</div>
					<div class="modal-body-consultas"></div>
				</div>
			</div>
		</div>
	</div>

	<!-- MODAL -->
	<div class="col-lg-8 col-md-8 col-sm-8">
		<div class="modal modal-info fade" id='bs-modal-profile' data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="Lightbox modal-dialog" style="width: 600px !important;">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" aria-hidden="true" data-dismiss="modal" type="button">×</button>
						<h4 class="modal-title" id="modal-title-profile"></h4>
					</div>
					<div class="modal-body" id="modal-body-profile" style="height: 500px !important"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-8 col-md-8 col-sm-8">
		<div class="modal modal-info fade" id='bs-modal-table' data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="Lightbox modal-dialog" style="width: 900px !important;">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" aria-hidden="true" data-dismiss="modal"  type="button">×</button>
						<h4 class="modal-title" id="modal-title-table"></h4>
					</div>
					<div class="modal-body" id="modal-body-table" style="">

					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="col-lg-3 col-md-4 col-sm-6">
		<div class="modal modal-info fade bs-modal-categorias" data-backdrop="static" data-keyboard="false" tabindex="-2" role="dialog" aria-hidden="true">
			<div class="Lightbox modal-dialog" style="">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" aria-hidden="true" data-dismiss="modal" type="button">×</button>
						<h4 class="modal-title-categorias" ></h4>
					</div>
					<div class="modal-body-categorias" ></div>
				</div>
			</div>
		</div>
	</div>
	<!--/ End body content -->

	<div class="col-lg-8 col-md-8 col-sm-8">
		<div class="modal modal-info fade" id='bs-modal-cierre' data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="Lightbox modal-dialog cierre_modal_content" style="width:70%;">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" aria-hidden="true" data-dismiss="modal" type="button">×</button>
						<h4 class="modal-title" id="modal-title-cierre"></h4>
					</div>
					<div class="modal-body" id="modal-body-cierre" ></div>
				</div>
			</div>
		</div>
	</div>

</div><!-- /.body-content -->

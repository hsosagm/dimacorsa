
 <!-- Start body content -->
 <div class="body-content animated fadeIn">

  <!-- PAYMENTS -->
  <div class="col-md-11 div_master">
    <div v-show="PanelBody" class="panel rounded shadow">
      <div class="panel-heading">
        <div class="DTTT btn-group"></div>
        <div class="pull-right">
          <button class="btn" data-action="remove" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Cerrar"><i class="fa fa-times"></i></button>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="PanelBody panel-body no-padding"></div>
    </div>
  </div>


  <!-- TABLES --> <!-- GRAPHS -->
  <div class="dt-container col-md-11">
    <div class="panel dt-panel rounded shadow">
      <div class="panel-heading">
        <div id="table_length" class="pull-left"></div>
        <div class="DTTT btn-group"></div>
        <div class="pull-right">
          <button class="btn" data-action="remove" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Cerrar"><i class="fa fa-times"></i></button>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="panel-body no-padding table"></div>
    </div>
  </div>

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
    <!--/ End body content -->

</div>
<div class="rounded shadow">
    <div class="panel_heading">
        <div id="table_length" class="pull-left"></div>
        <div class="DTTT btn-group">
            <button  v-on="click: crearProveedor()" class="btn btngrey">New</button>
            <button  v-on="click: actualizarProveedor()" class="btn btngrey btn_edit" disabled>Edit</button>
            <button  v-on="click: eliminarProveedor()" class="btn btngrey btn_edit" disabled>Delete</button>
        </div>
        <div class="pull-right">
            <button v-on="click: closeMainContainer" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="no-padding table">
        <table class="dt-table table-striped table-theme" id="example">
            <tbody style="background: #ffffff;">
                <tr>
                    <td style="font-size: 14px; color:#1b7be2;" colspan="6" class="dataTables_empty">Cargando datos del servidor...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<script>
$(document).ready(function() {
    $('#example').dataTable({
        "aoColumnDefs": [
            {"sClass": "widthM",              "sTitle": "Nombre",       "aTargets": [0]},
            {"sClass": "widthL",              "sTitle": "Direccion",    "aTargets": [1]},
            {"sClass": "align_right widthS",  "sTitle": "Telefono",     "aTargets": [2]},
            {"sClass": "widthM",              "sTitle": "nit",          "aTargets": [3]},
        ],
        "bJQueryUI": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "admin/proveedor/proveedores"
    });

});

</script>
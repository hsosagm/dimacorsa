<div class="rounded shadow">
    <div class="panel_heading">
                <div id="table_length" class="pull-left"></div>
                <div class="DTTT btn-group"></div>
        <div class="pull-right">
            <button v-on="click: closeMainContainer" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="no-padding table">
        <table id="example" class="display" width="100%" cellspacing="0">
            
            <thead>
                <tr>
                    <th>Tienda</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                    <th>M Pago</th>
                    <th>Venta No.</th>
                    <th>Monto</th>
                </tr>
            </thead>

            <tbody>
                <tr v-repeat="av: historialPagos" id="@{{av.id}}">
                    <td width="15%"> @{{ av.tienda }} </td>
                    <td width="25%"> @{{ av.usuario }} </td>
                    <td width="15%"> @{{ av.fecha }} </td>
                    <td width="15%"> @{{ av.metodoPago }} </td>
                    <td width="15%" class="right"> @{{ av.factura }} </td>
                    <td width="15%" class="right"> @{{ av.monto | currency ' ' }} </td>
                </tr>
            </tbody>

        </table>
    </div>
</div>
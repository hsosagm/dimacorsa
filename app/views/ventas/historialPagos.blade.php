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
                    <td> @{{ av.tienda }} </td>
                    <td> @{{ av.usuario }} </td>
                    <td> @{{ av.fecha }} </td>
                    <td> @{{ av.metodoPago }} </td>
                    <td class="right"> @{{ av.factura }} </td>
                    <td class="right"> @{{ av.monto | currency ' ' }} </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<style type="text/css">
    .display th:nth-child(1) { width: 15% !important; }
    .display th:nth-child(2) { width: 25% !important; }
    .display th:nth-child(3) { width: 15% !important; }
    .display th:nth-child(4) { width: 15% !important; }
    .display th:nth-child(5) { width: 15% !important; }
    .display th:nth-child(6) { width: 15% !important; }
</style>
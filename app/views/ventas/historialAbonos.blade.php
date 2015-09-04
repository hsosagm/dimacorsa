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
		            <th>Fecha</th>
		            <th>Usuario</th>
		            <th>Metodo pago</th>
		            <th>Monto</th>
		            <th>Observaciones</th>
		            <th>Detalle</th>
		        </tr>
		    </thead>

			<tbody>
		        <tr v-repeat="av: historialAbonos" id="@{{av.id}}">
		            <td> @{{ av.fecha }} </td>
		            <td> @{{ av.usuario }} </td>
		            <td> @{{ av.metodoPago }} </td>
		            <td class="right"> @{{ av.monto | currency ' ' }} </td>
		            <td> @{{ av.observaciones }} </td>
		            <td class="widthS center font14"> 
		                <a href="javascript:void(0);" title="Ver detalle" v-on="click: togleDetalleAbonos(this, av)" v-class="hide_detail: av.active" class="fa fa-plus-square"> 
		                <a href="javascript:void(0);" title="Imprimir abono" v-on="click: imprimirAbonoVenta($event, av.id, '{{@$comprobante->impresora}}')" class="fa fa-print font14"> 
		            </td>
		        </tr>
			</tbody>

		</table>
    </div>
</div>

<style type="text/css">
    .display th:nth-child(1) { width: 12% !important; }
    .display th:nth-child(2) { width: 16% !important; }
    .display th:nth-child(3) { width: 12% !important; }
    .display th:nth-child(4) { width: 10% !important; }
    .display th:nth-child(5) { width: 40% !important; }
    .display th:nth-child(6) { width: 10% !important; }
</style>
<div class="row">
	<dir class="col-md-6 imprimir_factura">
		<button class="btn btn-primary" onclick="printInvoice(this,{{$venta_id}},'{{$factura->impresora}}')">Imprimir Factura</button>
	</dir>
	<dir class="col-md-6 imprimir_factura">
		<button class="btn btn-default"  onclick="ImprimirGarantiaVenta(this,{{$venta_id}})">Imprimir Garantia</button>
	</dir>
</div>


<style type="text/css">
    .bs-modal .Lightbox{
        width: 400px !important;
    }

    .imprimir_factura button{
    	height:50px;
    	width:150px;
    }

    .imprimir_factura{
    	text-align:center;
    }
</style>
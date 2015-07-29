<div class="row">
	<dir class="col-md-6 imprimir_factura">
        <?php $id = "'".Crypt::encrypt($venta_id)."'";?>
		<button type="button" class="btn btn-primary .btn-block" onclick="ImprimirFacturaVenta(this,{{$venta_id}})">Imprimir Factura</button>
	</dir>
	<dir class="col-md-6 imprimir_factura">
		<button type="button" class="btn btn-default .btn-block"  onclick="ImprimirGarantiaVenta(this,{{$id}})">Imprimir Garantia</button>
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
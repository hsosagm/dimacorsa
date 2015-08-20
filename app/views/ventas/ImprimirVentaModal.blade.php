 <?php $factura = DB::table('printer')->select('impresora')
 ->where('tienda_id',Auth::user()->tienda_id)->where('nombre','factura')->first(); ?>

<?php $garantia = DB::table('printer')->select('impresora')
->where('tienda_id',Auth::user()->tienda_id)->where('nombre','garantia')->first(); ?>

<div class="row">
	<dir class="col-md-6 imprimir_factura">
		<button type="button" class="btn btn-primary .btn-block" onclick="ImprimirFacturaVenta(this,{{$venta_id}},'{{@$factura->impresora}}')">Imprimir Factura</button>
	</dir>
	<dir class="col-md-6 imprimir_factura">
		<button type="button" class="btn btn-default .btn-block"  onclick="ImprimirGarantiaVenta(this,{{$venta_id}})">Imprimir Garantia</button>
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
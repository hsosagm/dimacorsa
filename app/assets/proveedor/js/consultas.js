 $(function() {
    $(document).on("click", "#ShowTableHistoryShopping",        function(){ ShowHistoryTableShopping(this);      });
    $(document).on("click", "#ShowTableUnpaidShopping",         function(){ ShowTableUnpaidShopping(this);       });
    $(document).on("click", "#ShowTableHistoryPayment",         function(){ ShowTableHistoryPayment(this);       });
    $(document).on("click", "#ShowTableHistoryPaymentDetails",  function(){ ShowTableHistoryPaymentDetails(this);});
    $(document).on("click", "#ShowModalPaySupplier",  			function(){ ShowModalPaySupplier(this);          });
    $(document).on("click", "#ShowModalEditSuppliers",  		function(){ ShowModalEditSuppliers(this);        });
    $(document).on("click", "#ShowGraphicAnnualPurchases",  	function(){ ShowGraphicAnnualPurchases(this);    });
    $(document).on("click", "#ShowModalPurchasePayment",  	    function(){ ShowModalPurchasePayment(this);      });
    $(document).on("click", "#ShowModalOverduePaymentBalance",  function(){ ShowModalOverduePaymentBalance(this);});
    $(document).on("click", "#ShowModalFullPaymentBalance",  	function(){ ShowModalFullPaymentBalance(this);   });
});

//muestra tabla con todas las compras del proveedor
function ShowHistoryTableShopping ()
{
    $id = $("input[name='proveedor_id']").val();

    if($id > 0)
    {
        $.ajax({
            type: "GET",
            url: "admin/compras/ConsultPurchase",
            data: {proveedor_id: $id},
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                 makeTable(data, '', 'Compras');
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }
}

//muestra tabla con todas las copras pendientes de pago
function ShowTableUnpaidShopping ()
{
    $id = $("input[name='proveedor_id']").val();

    if($id > 0)
    {
        $.ajax({
            type: "GET",
            url: "admin/compras/ShowTableUnpaidShopping",
            data: {proveedor_id: $id},
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                 makeTable(data, '', 'Compras');
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }
}

//muestra tabla de todos los pagos
function ShowTableHistoryPayment ()
{
     $id = $("input[name='proveedor_id']").val();

    if($id > 0)
    {
        $.ajax({
            type: "GET",
            url: "admin/compras/ShowTableHistoryPayment",
            data: {proveedor_id: $id},
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                 makeTable(data, '', 'Pagos');
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }
}

//muestra tabla de todos los detalles de pagos
function ShowTableHistoryPaymentDetails ()
{
    $id = $("input[name='proveedor_id']").val();

    if($id > 0)
    {
        $.ajax({
            type: "GET",
            url: "admin/compras/ShowTableHistoryPaymentDetails",
            data: {proveedor_id: $id},
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                 makeTable(data, '', 'Pagos');
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }
}

//muestra la ventana modal para ingresar un abono
function ShowModalPaySupplier ()
{
    $id = $("input[name='proveedor_id']").val();

    if($id > 0)
    {
        $.ajax({
            type: "GET",
            url: "admin/proveedor/ShowModalPaySupplier",
            data: {proveedor_id: $id},
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                $('.modal-body').html(data);
                $('.modal-title').text('Abonar a Proveedor');
                $('.bs-modal').modal('show');
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }
}

//muestra la ventana modal para editar el provedor
function ShowModalEditSuppliers ()
{	
	$id = $("input[name='proveedor_id']").val();
    if($id > 0)
    {
        $.ajax({
            type: "POST",
            url: "admin/proveedor/edit",
            data: {id: $id},
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                $('.modal-body').html(data);
                $('.modal-title').text('Editar proveedor');
                $('.bs-modal').modal('show');
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }
}

//muestra la grafica de compras anuales
function ShowGraphicAnnualPurchases (element)
{

}

//muestra la ventana modal para pagar por compra
function ShowModalPurchasePayment (element)
{

}

//muestra la ventana modal para pagar saldo vencido
function ShowModalOverduePaymentBalance (element)
{

}

//muestra la ventana modal para pagar toda la deuda
function ShowModalFullPaymentBalance (element)
{

}

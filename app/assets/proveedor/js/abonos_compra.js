function GetPurchasesForPaymentsBySelection(page , sSearch )
{
    $.ajax({
        type: 'GET',
        url: "admin/compras/payments/formPaymentsPagination?page=" + page,
        data: { proveedor_id: vm.proveedor_id, sSearch: sSearch },
        success: function (data) {

            if (data.success == true)
            {
                $('#tab4').html(data.table);
            }
            else
            {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}

$(document).on('click', '.pagination_seleccion a', function (e) {
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    GetPurchasesForPaymentsBySelection(page,null);
});

function SST_search() {
    $("#iSearch").val("");
    $("#iSearch").unbind();
    $('#iSearch').keyup(function() {
        GetPurchasesForPaymentsBySelection( 1, $(this).val() );
    });
}

$(document).on("click", ".SST .select", function() {

    if ( $(this).closest("tr").hasClass( "row_selected" ) ) 
    {
        $(this).closest("tr").removeClass("row_selected");
        total = parseFloat($('.total_selected').val()) - parseFloat($(this).attr('total'));
         $("#total_selected").html(accounting.formatMoney(total,"", 2, ",", "."));
        $('.total_selected').val(total);
    }

    else
    {
        $(this).closest("tr").addClass('row_selected');
        total = parseFloat($(this).attr('total')) + parseFloat($('.total_selected').val());
        $("#total_selected").html(accounting.formatMoney(total,"", 2, ",", "."));
        $('.total_selected').val(total);
    }
});

function GetPurchasesSelected()
{
    var checkboxValues = new Array();
    $('input[name="selectedPurshase[]"]:checked').each(function() {
        checkboxValues.push($(this).val());
    });

    return checkboxValues;
}

function abonosComprasPorSeleccion(element)
{
    var form = $("form[data-remote-abonosComprasPorSeleccion]");
    var array_ids_compras = GetPurchasesSelected();
    $(element).prop("disabled", true);
    
    $.ajax({
        type: "POST",
        url:  "admin/compras/payments/abonosComprasPorSeleccion",
        data: form.serialize()+'&array_ids_compras='+array_ids_compras,
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            if (data.success == true) 
            {
                vm.divAbonosPorSeleccion = data.detalle;
                msg.success('Abonos Ingresados', 'Listo!');
                vm.updateInfoProveedor();
                return compile();
            }
            msg.warning(data, 'Advertencia!');
            $(element).prop("disabled", false);
        }
    });

}

function DeleteBalancePay(element,id)
{
    $(element).prop("disabled", true);

    $.ajax({
        type: 'POST',
        url: "admin/compras/payments/DeleteBalancePay",
        data: { id: id},
        success: function (data) {
            if (data == 'success')
            {
                getFormAbonosCompras(element);
                msg.success('Abonos Eliminados', 'Listo!');

            }
            else
            {
                msg.warning(data, 'Advertencia!');
                $(element).prop("disabled", false);
            }
        }
    });
}
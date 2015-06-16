
function getFormAbonosCompras(e)
{
   $proveedor_id = $("input[name='proveedor_id']").val();

    $.ajax({
        type: 'GET',
        url: "admin/compras/payments/formPayments",
        data: { proveedor_id: $proveedor_id },
        success: function (data) {

            if (data.success == true)
            {
                clean_panel();
                $('.table').html(data.form);
                $('.dt-container').show();
                SST_search();
                ids_selected = Array();
            }
            else
            {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}

function GetPurchasesForPaymentsBySelection(page = 1 , sSearch = "")
{
    $proveedor_id = $("input[name='proveedor_id']").val();

    $.ajax({
        type: 'GET',
        url: "admin/compras/payments/formPaymentsPagination?page=" + page,
        data: { proveedor_id: $proveedor_id, sSearch: sSearch },
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

$(document).on('click', '.pagination a', function (e) {

    e.preventDefault();

    var page = $(this).attr('href').split('page=')[1];

    GetPurchasesForPaymentsBySelection(page);

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
        total = parseFloat($('.total_selected').val()) - parseFloat($(this).attr('total')) ;
        $('.total_selected').val(total);
    }

    else
    {
        $(this).closest("tr").addClass('row_selected');
        total = parseFloat($(this).attr('total')) + parseFloat($('.total_selected').val()) ;
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

function SelectedPayPurchases(element)
{

    form = $("form[data-remote-SelectedPayPurchases]");
    array_ids_compras = GetPurchasesSelected();

    var formData = form.serialize()+'&array_ids_compras='+array_ids_compras;

    $(element).prop("disabled", true);
    
    $.ajax({
            type: "POST",
            url:  "admin/compras/payments/SelectedPayPurchases",
            data: formData,
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                if (data.success == true) 
                {
                      $('#tab4').html(data.detalle);
                      msg.success('Abonos Ingresados', 'Listo!');
                }
                else
                {
                    msg.warning(data, 'Advertencia!');
                    $(element).prop("disabled", false);
                }
            },
            error: function (request, status, error) {
                alert(request.responseText);
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
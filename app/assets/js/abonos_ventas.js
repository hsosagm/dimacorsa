function getFormAbonosVentas(e)
{
   $cliente_id = $("input[name='cliente_id']").val();

    $.ajax({
        type: 'GET',
        url: "user/ventas/payments/formPayments",
        data: { cliente_id: $cliente_id },
        success: function (data) {

            if (data.success == true)
            {
                clean_panel();
                $('.table').html(data.form);
                $('.dt-container').show();
                SST_search();
            }
            else
            {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}

function GetSalesForPaymentsBySelection(page = 1, sSearch = "")
{
    $cliente_id = $("input[name='cliente_id']").val();

    $.ajax({
        type: 'GET',
        url: "user/ventas/payments/formPaymentsPagination?page=" + page,
        data: { cliente_id: $cliente_id, sSearch: sSearch },
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

    GetSalesForPaymentsBySelection(page);

});


function SST_search() {

    $("#iSearch").val("");
    $("#iSearch").unbind();

    $('#iSearch').keyup(function() {
        GetSalesForPaymentsBySelection( 1, $(this).val() );
    });
}


$(document).on("click", ".SST .select", function() {

    if ( $(this).closest("tr").hasClass( "row_selected" ) ) 
    {
        $(this).closest("tr").removeClass("row_selected");
    }

    else
    {
        $(this).closest("tr").addClass('row_selected');
    }

});
function GetSalesForPaymentsBySelection(page, sSearch)
{
    $cliente_id = vm.cliente_id;

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
};

$(document).on('click', '.pagination a', function (e) {

    e.preventDefault();

    var page = $(this).attr('href').split('page=')[1];

    GetSalesForPaymentsBySelection(page, null);

});


function SST_search() {

    $("#iSearch").val("");
    $("#iSearch").unbind();

    $('#iSearch').keyup(function() {
        GetSalesForPaymentsBySelection( 1, $(this).val() );
    });
};


$(document).on("click", ".SST .select", function() {

    if ( $(this).closest("tr").hasClass( "row_selected" ) ) 
    {
        $(this).closest("tr").removeClass("row_selected");
        total = parseFloat($('.total_selected').val()) - parseFloat($(this).attr('total')) ;
        $("#total_selected").html(total);
        $('.total_selected').val(total);
    }

    else
    {
        $(this).closest("tr").addClass('row_selected');
        total = parseFloat($(this).attr('total')) + parseFloat($('.total_selected').val()) ;
        $("#total_selected").html(total);
        $('.total_selected').val(total);
    }

});


function GetSalessSelected()
{
    var checkboxValues = new Array();
    $('input[name="selectedSales[]"]:checked').each(function() {
        checkboxValues.push($(this).val());
    });

    return checkboxValues;
};

function SelectedPaySales(element)
{
    form = $("form[data-remote-SelectedPaySales]");
    array_ids_ventas = GetSalessSelected();

    var formData = form.serialize()+'&array_ids_ventas='+array_ids_ventas;

    $(element).prop("disabled", true);
    
    $.ajax({
            type: "POST",
            url:  "user/ventas/payments/SelectedPaySales",
            data: formData,
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {

                if (data.success == true) 
                {
                    vm.divAbonosPorSeleccion = data.detalle;
                    msg.success('Abonos Ingresados', 'Listo!');
                    vm.updateInfoCliente();
                    compile();
                }
                else
                {
                    msg.warning(data, 'Advertencia!');
                    $(element).prop("disabled", false);
                }
            },
            error: function (request, status, error) {

            }
        });
};
$(function() 
{
    $(document).on('click', '.master_opcion_verfactura', function(e) { master_opcion_verfactura(this); }); 
    $(document).on('click', '.master_opcion_cancelar', function(e)   { master_opcion_cancelar(this); }); 
});

function master_opcion_verfactura(element)
{
    $id = $(element).attr('id');
    $url= $(element).attr('url')+'verfactura';

    $.ajax({
    type: "POST",
    url: $url,
    data: {id: $id},
    contentType: 'application/x-www-form-urlencoded',
    success: function (data) {

        $('.panel-title').text('Formulario Compras');
        $(".forms").html(data);
        $(".dt-container").hide();
        $(".producto-container").hide();
        $(".form-panel").show();

    },
    error: function (request, status, error) {
        alert(request.responseText);
    }
    });
}

function master_opcion_cancelar(element)
{
    alert('cancelar');
}
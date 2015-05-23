msg = toastr;

$(function() {
    $(document).on("keyup", ".input_numeric", function(){ input_numeric(this); });
});
 

$( document ).ajaxSend(function() {
  $('.loader').show();
});

$( document ).ajaxSuccess(function() {
  $('.loader').hide();
  $('input').attr('autocomplete','off');
});

$( document ).ajaxError(function( event, request, settings ) {
    $('.loader').hide();
    alert("<strong>Hubo un error de coneccion! </strong> Verifique network o intentelo de nuevo.");
});

function input_numeric(element)
{
    element.value = (element.value + '').replace(/[^0-9-.]/g, '');
}

function proccess_table($v) {

    $("#iSearch").val("");
    $("#iSearch").unbind();
    clean_panel();

    var table = '<table class="dt-table table-striped table-theme" id="example"><tbody style="background: #ffffff;">';
    table += '<tr>';
    table += '<td style="font-size: 14px; color:#1b7be2;" colspan="7" class="dataTables_empty">Cargando datos del servidor...</td>';
    table += '</tr>';
    table += '</tbody></table>';
    $('.table').html(table);

    $('.bread-current').text($v);

    setTimeout(function(){
        $("#iSearch").focus();
        $('#example_length').prependTo("#table_length");
        $('.dt-container').show();
        
        oTable = $('#example').dataTable();
        $('#iSearch').keyup(function(){
            oTable.fnFilter( $(this).val() );
        })
    }, 300);
}

$(document).on("click", "#example tbody tr", function() {

    if ( $( this ).hasClass( "row_selected" ) ) 
    {
        $("tr").removeClass("row_selected");
        $('.btn_edit').prop("disabled", true);
    }

    else
    {
        $("tr").removeClass("row_selected");
        $(this).addClass('row_selected');
        $('.btn_edit').prop("disabled", false);
    }

});

$(document).on('click', '.wclose', function(e) {
    e.preventDefault();
    var $wbox = $(this).parent().parent().parent();
    $wbox.hide(100);

    $("#iSearch").val("");
    $("#iSearch").unbind();
});

$(document).on('click', '#sidebar-left .sidebar-menu ul li', function(e) {
    
    e.preventDefault();

    $( "li" ).removeClass( "active" )

    $(this).addClass('active');

    $(this).parent().parent().addClass('active');

});

$(document).on('click', '#sidebar-left .sidebar-menu .home', function(e) {
    
    e.preventDefault();

    $( "li" ).removeClass( "active" )

    $(this).addClass('active');

});

function makeTable($data, $url, $title) {
    $('.table').html($data);
    $('.dataTable').attr('url', $url);
    $('.dataTable').attr('title', $title);
}


function clean_panel() {
    $('.table').html("");
    $("#table_length").html("");
    $( ".DTTT" ).html("");
    $('.dt-panel').show();
    $('.dt-container').hide();
}


// filtra datatable en la posision que se encuentra
$.fn.dataTableExt.oApi.fnStandingRedraw = function(oSettings) {
    oSettings.oApi._fnDraw(oSettings);
};

function DeleteBalancePay(abono_id)
{
    $.confirm({
        confirm: function(){
            $.ajax({
                type: 'POST',
                url: 'admin/proveedor/DeleteBalancePay',
                data: { id: abono_id },
                success: function (data) {
                    if (data == "success")
                    {
                        msg.success('Abono Eliminado', 'Listo!');
                        ShowModalPaySupplier();
                    }
                    else
                    {
                        msg.warning(data, 'Advertencia!');
                    }
                },
                error: function(errors){
                    msg.error('Hubo un error, intentelo de nuevo', 'Advertencia!');
                }
            });
        }
    });
}

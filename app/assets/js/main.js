$(function() {
    $(document).on("click", "#_create", function(){ _create(this); });
    $(document).on("click", "#_edit", function(){ _edit(this); });
    $(document).on("click", "#_edit_dt", function(){ _edit_dt(this); });
    $(document).on("click", "#_delete", function(){ _delete(this); });
    $(document).on("click", "#_delete_dt", function(){ _delete_dt(this); });
    $(document).on("click", "#_print",      function(){ _print(this); })
    $(document).on("keyup", ".input_numeric", function(){ input_numeric(this); });
});

ajaxStatus = 0;
$('.cierre_modal_content').draggable();
$('.btnremove').on('click', function() {
    $('#home').empty();
});

$(document).ajaxSend(function() {
    $('#home').empty();
    $('#loader').show();
});


$(document).ajaxSuccess(function() {
    $('#loader').hide();
    ajaxStatus = 0;
});

$(document).ajaxError(function( event, jqXHR, ajaxSettings, thrownError ) {

    if (jqXHR.status === 0)
    {
        if ( ajaxStatus < 5 ) {
            ajaxStatus++;
            $.ajax(this);
        }
        else{
            msg.error('No hay coneccion. Verifique network o intentelo de nuevo', 'Error!');
            ajaxStatus = 0;
        }
    }

    else if (jqXHR.status == 401)
    {
        msg.error(jqXHR.responseJSON, 'Error!');
        setTimeout(function() {
            window.location.href = window.location.href+"logIn";
        },1000);
    }

    else if (jqXHR.status == 404)
        msg.error(jqXHR.responseJSON, 'Error!');

    else if (jqXHR.status == 500)
        msg.error('Internal Server Error [500].', 'Error!');

    else
    {
        msg.error('Uncaught Error.' + jqXHR.responseText, 'Error!');
        $('#loader').hide();
    }

    $('#loader').hide();
    $('[type=submit]').prop('disabled', false);

});


function input_numeric(element)
{
    element.value = (element.value + '').replace(/[^0-9-.]/g, '');
}

function formato_precio(num) {
    num = num.toString().replace(/\Q|\,/g, '');
    if (isNaN(num))
    num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * 100 + 0.50000000001);
    cents = num % 100;
    num = Math.floor(num / 100).toString();
    if (cents < 10)
    cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
    num = num.substring(0, num.length - (4 * i + 3)) + ',' + num.substring(num.length - (4 * i + 3));
    return ((sign) ? '' : '-') + ' ' + num + '.' + cents;
}

function formato_porcentaje(num) {
    num = num.toString().replace(/\|\,/g, '');
    if (isNaN(num))
    num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * 100 + 0.50000000001);
    cents = num % 100;
    num = Math.floor(num / 100).toString();
    if (cents < 10)
    cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
    num = num.substring(0, num.length - (4 * i + 3)) + ',' + num.substring(num.length - (4 * i + 3));
    return ((sign) ? '' : '-') + '% ' + num + '.' + cents;
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


$(document).on("click", ".tableSelected tbody tr", function() {
    if ($(this).hasClass('subtable') || $(this).hasClass('subTableChild')) {} 
        else {
        if ( $( this ).hasClass( "row_selected" ) ) 
        {
            $("tr").removeClass("row_selected");
            $('.btn_edit').prop("disabled", true);
        } else
        {
            $("tr").removeClass("row_selected");
            $(this).addClass('row_selected');
            $('.btn_edit').prop("disabled", false);
        }
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


function _create() {

    var url = $('.dataTable').attr('url') + 'create';

    $.get( url, function( data ) {
        $('.modal-body').html(data);
        $('.modal-title').text( 'Crear ' + $('.dataTable').attr('title') );
        $('.bs-modal').modal('show');
    });
}


function _edit() {

    $id  = $('.dataTable tbody .row_selected').attr('id');
    $url = $('.dataTable').attr('url') + 'edit';

    $.ajax({
        type: "POST",
        url: $url,
        data: {id: $id},
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            $('.modal-body').html(data);
            $('.modal-title').text( 'Editar ' + $('.dataTable').attr('title') );
            $('.bs-modal').modal('show');
        },
        error: function (request, status, error) {
            alert(request.responseText);
        }
    });
};

function _edit_dt() {

    $id  = $('.dataTable tbody .row_selected').attr('id');
    $url = $('.dataTable').attr('url') + 'edit_dt';

    $.ajax({
        type: "GET",
        url: $url,
        data: {id: $id},
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            $('.modal-body').html(data);
            $('.modal-title').text( 'Editar ' + $('.dataTable').attr('title') );
            $('.bs-modal').modal('show');
        },
        error: function (request, status, error) {
            alert(request.responseText);
        }
    });
};


function _delete() {

    $id  = $('.dataTable tbody .row_selected').attr('id');
    $url = $('.dataTable').attr('url') + 'delete';

    $.confirm({

        confirm: function(){

            $.ajax({
                type: "POST",
                url: $url,
                data: { id: $id },
                contentType: 'application/x-www-form-urlencoded',
                success: function (data, text) {
                    if (data == 'success') {

                        msg.success('Dato eliminado', 'Listo!')
                        oTable.fnDraw();
                        
                    } else {

                        msg.warning('Hubo un erro al tratar de eliminar', 'Advertencia!')
                    }
                },
                error: function (request, status, error) {

                    msg.error(request.responseText, 'Error!')
                }
            });
        }
    });

    $('.modal-title').text( 'Eliminar ' + $('.dataTable').attr('title') );
};

function _delete_dt(e) {
    $id = $(e).closest('tr').attr('id');    
    $url = $(e).attr('url') + 'delete';
    
    $.confirm({
        confirm: function(){
            $.ajax({
                type: "POST",
                url: $url,
                data: { id: $id },
                contentType: 'application/x-www-form-urlencoded',
                success: function (data, text) {
                    if ($.trim(data) == 'success') {
                        msg.success('Dato eliminado', 'Listo!')
                        $(e).closest('tr').hide();
                    } 
                    else {
                        msg.warning('Hubo un erro al tratar de eliminar', 'Advertencia!')
                    }
                }
            });
        }
    });

    $('.modal-title').text( 'Eliminar ' + $('.dataTable').attr('title') );
};

function _print()
{
    if (isLoaded()) {
        qz.findPrinter();
        window['qzDoneFinding'] = function() {
            var printer = qz.getPrinter();
            
            if (printer !== null) {

                $.ajax({
                    type: "POST",
                    url: "admin/barcode/print_code",
                    data: { id: $('.dataTable tbody .row_selected').attr('id') },
                    contentType: 'application/x-www-form-urlencoded',
                    success: function (data, text)
                    {
                        if (data["success"] == true)
                        {
                            // $("#barcode").barcode(
                            //     data["codigo"],
                            //     data["tipo"],
                            //     { barWidth:data["ancho"], barHeight:data["alto"], fontSize:data["letra"] }
                            // );

                            $("#barcode").show();

                            $("#barcode").JsBarcode(
                                data["codigo"] , 
                                {
                                    width:  2,
                                    height: 100,
                                    backgroundColor:"#ffffff",
                                    format: "CODE128",
                                    displayValue: true,
                                    fontSize: 16
                                }
                            );

                            html2canvas($("#barcode"), {
                                onrendered: function(canvas) {
                                    var myImage = canvas.toDataURL("image/png");
                                    if (notReady()) { return; }
                                    qz.setPaperSize("62mm", "18mm");  // barcode
                                    qz.setOrientation("portrait");
                                    qz.setAutoSize(true);
                                    qz.appendImage(myImage);
                                    window['qzDoneAppending'] = function() {
                                        qz.printPS();
                                        $("#barcode").hide();
                                        window['qzDoneAppending'] = null;
                                    };
                                }
                            });
                        }
                        else
                        {
                            msg.warning('Hubo un error', 'Advertencia!')
                        }
                    }
                });
            }
            else {
                msg.error('La impresora "'+p+'" no se encuentra', 'Error!');
            }
            window['qzDoneFinding'] = null;
        };
    }
};

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
    ocultar_capas();
}

function ocultar_capas() {
    $('.dt-container').hide();
    $('#graph_container').hide();
    $(".dt-container-cierre").hide();
}

// codigo para limpiar las capas y generar datatables cuando se usa local
function generate_dt_local(data) {
    $("#iSearch").val("");
    $("#iSearch").unbind();
    $('.table').html("");
    $("#table_length").html("");
    $( ".DTTT" ).html("");
    $('.dt-panel').show();
    ocultar_capas();
    $('.table').html(data);
    $('#example').DataTable();
    $("#iSearch").focus();
}


// filtra datatable en la posision que se encuentra
$.fn.dataTableExt.oApi.fnStandingRedraw = function(oSettings) {
    oSettings.oApi._fnDraw(oSettings);
};


// para sumar columnas filtradas en datatables
jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
    return this.flatten().reduce( function ( a, b ) {
        if ( typeof a === 'string' ) {
            a = a.replace(/[^\d.-]/g, '') * 1;
        }
        if ( typeof b === 'string' ) {
            b = b.replace(/[^\d.-]/g, '') * 1;
        }

        return a + b;
    }, 0 );
} );
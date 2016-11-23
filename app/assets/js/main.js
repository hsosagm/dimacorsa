$(function() {
    $(document).on("click", "#_create", function(){ _create(this); });
    $(document).on("click", "#_create_dt", function(){ _create_dt(this); });
    $(document).on("click", "#_edit", function(){ _edit(this); });
    $(document).on("click", "#_edit_dt", function(){ _edit_dt(this); });
    $(document).on("click", "#_delete", function(){ _delete(this); });
    $(document).on("click", "#_delete_dt", function(){ _delete_dt(this); });
    $(document).on("click", "#_print",      function(){ _print(this); });
    $(document).on("keyup", ".input_numeric", function(){ input_numeric(this); });
});

ajaxStatus=0;
$('.btnremove').on('click', function() {
    $('#home').empty();
});

$(document).ajaxSend(function(event, jqXHR, ajaxSettings, thrownError ) {
    $('#home').empty();
    $('#loader').show();
});


$(document).ajaxSuccess(function() {
    $('#loader').hide();
    ajaxStatus = 0;
    $('#example').attr('width', '100%');
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
    $('input[type=submit]').prop('disabled', false);
    $('button[type=submit]').prop('disabled', false);

});

function input_numeric(element)
{
    element.value = (element.value + '').replace(/[^0-9-.]/g, '');
};

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
};

function format_number(num) {
    num = parseFloat(num);
    return (num).formatMoney(5, '.', ',');
};

Number.prototype.formatMoney = function(c, d, t){
var n = this,
    c = isNaN(c = Math.abs(c)) ? 2 : c,
    d = d == undefined ? "." : d,
    t = t == undefined ? "," : t,
    s = n < 0 ? "-" : "",
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };

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
};

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
};


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
};

function _create_dt() {

    var url = $('.dataTable').attr('url') + 'create_dt';

    $.get( url, function( data ) {
        $('.modal-body').html(data);
        $('.modal-title').text( 'Crear ' + $('.dataTable').attr('title') );
        $('.bs-modal').modal('show');
    });
};

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
                success: function (data) {
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

function _print(e)
{
    console.log("imprimir");
        $.ajax({
            type: "POST",
            url: "admin/barcode/print_code",
            data: { id: $('.dataTable tbody .row_selected').attr('id') },
            success: function (data, text)
            {
                if (data["success"] == true)
                {
                    $("#barcode").show();
                    $("#barcode").JsBarcode(
                        data["codigo"] ,
                        {
                            width:  2,
                            height: 68,
                            backgroundColor:"#ffffff",
                            format: "CODE128",
                            displayValue: true,
                            fontSize: 16
                        }
                    );

                    html2canvas($("#barcode"), {
                        onrendered: function(canvas) {
                            var myImage = canvas.toDataURL("image/png");
                            var ventana = open("" ,'_blank');
                            ventana = ventana.document.write('<img src="'+myImage+'" width="300" height="65"/>');
                        }
                    });
                }
                else {
                    msg.warning('Hubo un error', 'Advertencia!')
                }
            }
        });
};

function makeTable($data, $url, $title) {
    $('.table').html($data);
    $('.dataTable').attr('url', $url);
    $('.dataTable').attr('title', $title);
};


function clean_panel() {
    $('.table').html("");
    $("#table_length").html("");
    $( ".DTTT" ).html("");
    $('.dt-panel').show();
    $("#graph_container").css( "zIndex", 1);
    ocultar_capas();
};

function ocultar_capas() {
    $('.dt-container').hide();
    $('#graph_container').hide();
    $(".dt-container-cierre").hide();
};

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
};

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
});

function getMasterQueries() {
    $('#graph_container').hide();
    $('.dt-container').hide();
    $('.table').html("");

    $.ajax({
      url: "admin/queries/getMasterQueries",
      type: "GET"
    }).done(function(data) {
        if (data.success == true) {
            $("#table_length").html("");
            $( ".DTTT" ).html("");
            $('.table').html(data);
            $('.dt-panel').show();
            $('.dt-container').show();
            $('.table').html(data.view);
        }
    });
};

$('[data-action=collapse_head]').click(function(){
    var targetCollapse = $(this).parents('.panel').find('.HeadQueriesContainer');
    if (targetCollapse) {
        if((targetCollapse.is(':visible'))) {
            $(this).find('i').removeClass('fa-angle-up').addClass('fa-angle-down');
            targetCollapse.slideUp();
        }else{
            $(this).find('i').removeClass('fa-angle-down').addClass('fa-angle-up');
            targetCollapse.slideDown();
        }
    }
});


function fopen_kit() {
    $.ajax({
        type: "GET",
        url: "admin/kits/create"
    }).done(function(data) {
        if (!data.success)
            return msg.warning('Hubo un error intentelo de nuevo', 'Advertencia!');

        $('.panel-title').text('Formulario kit');
        $(".forms").html(data.form);
        ocultar_capas();
        $(".form-panel").show();
        $('#cliente').focus();
    });
};

function historial_kits() {
    $.ajax({
        type: "GET",
        url: 'admin/kits/historial_kits'
    }).done(function(data) {
        makeTable(data, ' ', 'Historial de combos');
    });
};

function verKitDetalle(e, kit_id) {
    if ($(e).hasClass("hide_detail")) {
        $(e).removeClass('hide_detail');
        $('.subtable').hide();
    }
    else {
        $('.hide_detail').removeClass('hide_detail');

        if ( $( ".subtable" ).length ) {
            $('.subtable').fadeOut('slow', function(){
                getKitDetalle(e, kit_id);
            })
        }
        else {
            getKitDetalle(e, kit_id);
        }
    }
};

function getKitDetalle(e, kit_id) {
    $('.subtable').remove();
    var nTr = $(e).parents('tr')[0];
    $(e).addClass('hide_detail');
    $(nTr).after("<tr class='subtable'> <td colspan=6 ><div class='grid_detalle_factura'></div></td></tr>");
    $('.subtable').addClass('hide_detail');

    $.ajax({
        type: "GET",
        url: 'admin/kits/getDetalle',
        data: { kit_id: kit_id },
    }).done(function(data) {
        console.log(data);
        if (data.success == true)
        {
            $('.grid_detalle_factura').html(data.table);
            $(nTr).next('.subtable').fadeIn('slow');
            return $(e).addClass('hide_detail');
        }
        msg.warning(data, 'Advertencia!');
    });
};

function open_kit_no_finalizado(kit_id) {
    $.ajax({
        type: "GET",
        url: "admin/kits/open_kit_no_finalizado",
        data: { kit_id: kit_id }
    }).done(function(data) {
        if (!data.success)
            return msg.warning(data, 'Advertencia!');

        $('.panel-title').text('Formulario kit');
        $(".forms").html(data.form);
        ocultar_capas();
        $(".form-panel").show();
    });
};

jQuery.fn.getPosition = function() {
    input = this[0];

    var pos = input.value.length;

    if (input.createTextRange) {
        var r = document.selection.createRange().duplicate();
        r.moveEnd('character', input.value.length);
        if (r.text == '')
        pos = input.value.length;
        pos = input.value.lastIndexOf(r.text);
    } else if(typeof(input.selectionStart)!="undefined")
    pos = input.selectionStart;

    return pos;
}
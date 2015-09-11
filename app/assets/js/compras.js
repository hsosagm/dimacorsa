$(function() {
    $(document).on('click', '#f_com_op',                          function() { f_com_op(this);         });
    $(document).on('click', '#OpenModalPurchaseInfo',             function() { OpenModalPurchaseInfo(this); });
    $(document).on('click', '#OpenModalPurchaseItemSerials',      function() { OpenModalPurchaseItemSerials(this);    });
    $(document).on('click', '#_edit_producto',                    function() { _edit_producto(this); });
    $(document).on('click', '#_add_producto',                     function() { _add_producto(this); });
    $(document).on("click","#print_code_producto",                function() { print_code_producto(this); })
    $(document).on('click', '.return_compras',                    function() { return_compras(this); });
    $(document).on('submit'  ,'form[data-remote-PurchasePayment]',function(e){ SavePurchasePayment(e,this);  });
    $(document).on('dblclick','.EditPurchaseItemDetails' ,        function() { EditPurchaseItemDetails(this);  });
    $(document).on('blur' ,'.SaveEditPurchaseItemDetails',        function() { DisableEditPurchaseItemDetails(this); });
    $(document).on('enter','.SaveEditPurchaseItemDetails',        function(e){ SaveEditPurchaseItemDetails(e,this); });
    $(document).on('enter', "input[name='InsertPurchaseItemSerials']",function(){ InsertPurchaseItemSerials(this);}); 
    $(document).on("enter", "#serialsDetalleCompra",                function(){ guardarSerieDetalleCompra(); });
});
 
function f_com_op()  {    
    $.get( "admin/compras/create", function( data ) {
        $('.panel-title').text('Formulario Compras');
        $(".forms").html(data);
        $(".dt-container").hide();
        $(".dt-container-cierre").hide();
        $(".producto-container").hide();
        $(".form-panel").show();
    });
} 

function print_code_producto() {    
    $id  = $("input[name='producto_id']").val();

    $.ajax({
        type: "POST",
        url: "admin/barcode/print_code",
        data: { id: $id },
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) {
            if (data["success"] == true) {
                $("#print_barcode").barcode(
                    data["codigo"],
                    data["tipo"], {
                        barWidth:data["ancho"],
                        barHeight:data["alto"],
                        fontSize:data["letra"]
                    }
                    );   
                $("#print_barcode").show();
                $.print("#print_barcode");
                $("#print_barcode").hide();
            }
            else {
                msg.warning('Hubo un error', 'Advertencia!')
            }
        }
    });
}

function OpenModalPurchaseInfo(element) {
    $id  =  $(element).attr('compra_id');
    $url = 'admin/compras/OpenModalPurchaseInfo';

    $.ajax({
        type: "POST",
        url: $url,
        data: {id: $id},
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            $('.modal-body').html(data);
            $('.modal-title').text( 'Editar Informacion Compra');
            $('.bs-modal').modal('show');
        }
    });
}

function return_compras() {
    $(".dt-container").hide();
    $(".producto-container").hide();
    $(".dt-container-cierre").hide();
    $(".form-panel").show();
}

var val_anterior;

function EditPurchaseItemDetails(element) {
    val_anterior = $(element).text();
    $(element).html('<input type="text" value="'+$.trim(val_anterior)+'" class="SaveEditPurchaseItemDetails" />');
    $('.SaveEditPurchaseItemDetails').focus();
    $('.SaveEditPurchaseItemDetails').select();
}

function DisableEditPurchaseItemDetails(element) {
    $(element).closest('td').html(val_anterior);
}

function SaveEditPurchaseItemDetails(e,element) {
    $detalle_id  = $(element).closest('td').attr('cod');
    $tipo_dato = $(element).closest('td').attr('field');
    $dato = $(element).val();
    $compra_id = $(element).closest('td').attr('compra_id');

    $.ajax({
        type: 'POST',
        url: 'admin/compras/SaveEditPurchaseItemDetails',
        data: { detalle_id:$detalle_id , tipo_dato:$tipo_dato , dato:$dato ,compra_id:$compra_id },
        success: function (data)  {
            if (data.success == true) {                        
                msg.success('Detalle Actualizado..!', 'Listo!');
                $('.body-detail').html(data.table);
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
    e.preventDefault(); 
}   

function InsertPurchaseItemSerials(element) {
    var cod = '';
    $("#SerialTable td").each(function() {
        if ($(this).text() === $("input[name='InsertPurchaseItemSerials']").val()) {
            cod = $(this).text();
        }
    });

    if (cod === $("input[name='InsertPurchaseItemSerials']").val()) {
        msg.error('la serie ya ha sido ingresada', 'Advertencia!');
    }
    else {
        if ($(element).val().trim() === '') {
            msg.warning('El Campo se encuentra vacio...!', 'Advertencia!');
        }
        else {
            var serie = $(element).val().trim();
            var series = $("input[name='serials']").val();

            if($("input[name='serials']").val().trim()==='') {
                series = serie;
            }
            else {
                series = series+","+serie;
            }
            var myRow = '<tr><td width="100%">'+serie+'</td><td><i class="fa fa-times btn-link theme-c" id="'+series+'" onclick="DeletePurchaseItemSerials(this)"></i></td></tr>';
            $("input[name='serials']").val(series);

            $("#SerialTable tr:first").after(myRow);
            $("input[name='InsertPurchaseItemSerials']").val('');
            msg.success('Ingresado..!', 'Listo!');
        }
    }
}

function DeletePurchaseInitial(element) {
    var compra_id = $(element).attr('compra_id');
    $.confirm({
        confirm: function(){
            $.ajax({
                type: 'POST',
                url: 'admin/compras/DeletePurchaseInitial',
                data: { id: compra_id },
                success: function (data) {
                    if (data == 'success') {
                        f_com_op();
                        msg.success('Compra Eliminada..!', 'Listo!');
                    }
                    else {
                        msg.warning(data, 'Advertencia!');
                    }
                }
            });
        }
    });
}

function ModalPurchasePayment(element) {
   var compra_id = $(element).attr('id');
   $.ajax({
    type: 'GET',
    url: "admin/compras/ModalPurchasePayment",
    data: { compra_id: compra_id },
    success: function (data) {
       if (data.success == true) {
        $('.modal-body').html(data.detalle);
        $('.modal-title').text('Ingresar Pagos');
        $('.bs-modal').modal('show');
    }
    else {
        msg.warning(data, 'Advertencia!');
    }
}
});
}

function SavePurchasePayment(e,element) {
    form = $(element);
    $('input[type=submit]', form).attr('disabled', 'disabled');
    
    $.ajax({
        type: "POST",
        url:  "admin/compras/ModalPurchasePayment",
        data: form.serialize(),
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            if (data.success == true)  {
                msg.success('Ingresado', 'Listo!');
                $('.modal-body').html(data.detalle);
                $('.modal-title').text('Ingresar Pagos');
                $('.bs-modal').modal('show');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });

    e.preventDefault();
    $('input[type=submit]', form).removeAttr('disabled');
}


function DeletePurchasePaymentItem(id , compra_id)
{
    var url = "admin/compras/DeletePurchasePaymentItem";

    $.ajax({
        type: 'POST',
        url: url,
        data: { id: id , compra_id: compra_id },
        success: function (data) {
            if (data.success == true) {
                msg.success('Eliminado', 'Listo!');
                $('.modal-body').html(data.detalle);
                $('.modal-title').text('Ingresar Pagos');
                $('.bs-modal').modal('show');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}

function FinishInitialPurchase(element,compra_id)
{    
    $(element).prop("disabled", true);
    
    $.ajax({
        type: 'POST',
        url: 'admin/compras/FinishInitialPurchase',
        data: { compra_id: compra_id ,nota: $("input[name='nota']").val() },
        success: function (data) {
            if (data == 'success') {
                f_com_op();
                msg.success('Compra Finalizada..!', 'Listo!');
                $('.bs-modal').modal('hide');
            }
            else {
                msg.warning(data, 'Advertencia!');
                $(element).prop("disabled", false);
            }
        }
    });
    return false;
}


function OpenModalPurchaseItemSerials() {
    $serial = $("input[name='serials']").val();
    $.ajax({
        type: "GET",
        url: "admin/compras/OpenModalPurchaseItemSerials",
        data: {serial: $serial},
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            $('.modal-body').html(data);
            $('.modal-title').text('Seriales');
            $('.bs-modal').modal('show');
            setTimeout(function(){
                $("input[name='InsertPurchaseItemSerials']").focus();
            }, 500);
        }
    });
}

function  DeletePurchaseItemSerials(element) {
    var id  = $(element).attr('id');
    $.confirm({
        confirm: function() {
            series=$("input[name='serials']").val().replace(id,'');
            $("input[name='serials']").val(series);
            $(element).closest('tr').hide();
        }
    });
}

function _edit_producto() {
    $id  =  $("input[name='producto_id']").val();
    if ($id > 0) {
        $.ajax({
            type: "POST",
            url: "admin/productos/edit",
            data: {id: $id},
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
                $(".contenedor_producto").html(data);
                $(".contenedor_producto").slideToggle('slow');
            }
        });
    };
}; 

function _add_producto() {
    $.get( "admin/productos/create", function( data ) {
        $(".contenedor_producto").html(data);
        $(".contenedor_producto").slideToggle('slow');
    });
}

function VerFacturaDeCompra(e) {
    $id = $(e).closest('tr').attr('id');
    $url= 'admin/compras/verfactura';

    $.ajax({
        type: "POST",
        url: $url,
        data: {id: $id},
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            if (data.success == true) {
                $('.panel-title').text('Formulario Compras');
                $(".forms").html(data.form);
                $(".dt-container").hide();
                $(".producto-container").hide();
                $(".dt-container-cierre").hide();
                $(".form-panel").show();
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}


function showPurchasesDetail(e) {
    if ($(e).hasClass("hide_detail")) {
        $(e).removeClass('hide_detail');
        $('.subtable').fadeOut('slow');
    } 
    else {
        $('.hide_detail').removeClass('hide_detail');

        if ( $( ".subtable" ).length ) {
            $('.subtable').fadeOut('slow', function(){
                getPurchaseDetail(e);
            })
        }
        else {
            getPurchaseDetail(e);
        }
    }
}

function getPurchaseDetail(e) {
    $id = $(e).closest('tr').attr('id');

    $('.subtable').remove();
    var nTr = $(e).parents('tr')[0];
    $(e).addClass('hide_detail');
    $(nTr).after("<tr class='subtable'> <td colspan=8><div class='grid_detalle_factura'></div></td></tr>");
    $('.subtable').addClass('hide_detail');

    $.ajax({
        type: 'GET',
        url: "admin/compras/showPurchaseDetail",
        data: { id: $id},
        success: function (data) {
            if (data.success == true) {
                $('.grid_detalle_factura').html(data.table);
                $(nTr).next('.subtable').fadeIn('slow');
                $(e).addClass('hide_detail');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}

function CreditPurchases(e) {
    $(e).prop("disabled", true);

    $.ajax({
        type: 'GET',
        url: "admin/compras/getCreditPurchase",
        success: function (data) {
            if (data.success == true) {
                generate_dt_local(data.table);

                setTimeout(function() {
                    $('#example_length').prependTo("#table_length");
                    var saldo = ($('input[name=total_saldo]').val());
                    var saldo_vencido = ($('input[name=saldo_vencido]').val());
                    $( "#home" ).append('<i style="width:150px; text-align:right;">/ Compras al credito: </i>');
                    $( "#home" ).append('<i style="width:60px; text-align:right;">Total:</i>');
                    $( "#home" ).append('<i class="home_num">'+saldo+'</i>');
                    $( "#home" ).append('<i style="width:85px; text-align:right;">Vencido:</i>');
                    $( "#home" ).append('<i class="home_num">'+saldo_vencido+'</i>');
                    $( "#home" ).append('<i style="width:85px; text-align:right;">Filtrado:</i>');
                    $( "#home" ).append('<i id="saldo_por_busqueda" class="home_num"></i>');
                    $( "#home" ).append('<i style="width:139px; text-align:right;">Filtrado vencido:</i>');
                    $( "#home" ).append('<i id="saldo_por_busqueda_vencido" class="home_num"></i>');
                    $('.dt-container').show();
                    
                    oTable = $('#example').dataTable();
                    $('#iSearch').keyup(function() {
                        oTable.fnFilter( $(this).val() );
                        var table = $('#example').DataTable();
                        var s_filter_applied = table.column( 6, {"filter": "applied"} ).data().sum();
                        s_filter_applied = accounting.formatMoney(s_filter_applied,"", 2, ",", ".");
                        $('#saldo_por_busqueda').text(s_filter_applied);

                        var sv_filter_applied=0;

                        $("tbody tr.red").each(function () {
                            var getValue = $(this).find("td:eq(6)").html().replace("$", "");
                            var filteresValue=getValue.replace(/\,/g, '');
                            sv_filter_applied +=Number(filteresValue)
                        });
                        sv_filter_applied = accounting.formatMoney(sv_filter_applied,"", 2, ",", ".");
                        $('#saldo_por_busqueda_vencido').text(sv_filter_applied);
                    })
                }, 300);
}
else {
    msg.warning('Hubo un error intentelo de nuevo', 'Advertencia!');
}
}
}); 
}

function showPaymentsDetail(e){
    if ($(e).hasClass("hide_detail"))  {
        $(e).removeClass('hide_detail');
        $('.subtable').fadeOut('slow');
    } 
    else {
        $('.hide_detail').removeClass('hide_detail');

        if ( $( ".subtable" ).length ) {
            $('.subtable').fadeOut('slow', function(){
                getPaymentsDetail(e);
            })
        }
        else {
            getPaymentsDetail(e);
        }
    }
}

function getPaymentsDetail(e) {
    $id = $(e).closest('tr').attr('id');

    $('.subtable').remove();
    var nTr = $(e).parents('tr')[0];
    $(e).addClass('hide_detail');
    $(nTr).after("<tr class='subtable'> <td colspan=8><div class='grid_detalle_factura'></div></td></tr>");
    $('.subtable').addClass('hide_detail');

    $.ajax({
        type: 'GET',
        url: "admin/compras/showPaymentsDetail",
        data: { id: $id},
        success: function (data) {
            if (data.success == true) {
                $('.grid_detalle_factura').html(data.table);
                $(nTr).next('.subtable').fadeIn('slow');
                $(e).addClass('hide_detail');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });
}

var serialsDetalleCompra = [];

function ingresarSeriesDetalleCompra(e, detalle_compra_id) {
    $.ajax({
        type: "POST",
        url: 'admin/compras/ingresarSeriesDetalleCompra',
        data: {detalle_compra_id: detalle_compra_id },
    }).done(function(data) {
        if (data.success == true) {
            $('.modal-body').html(data.view);
            $('.modal-title').text( 'Ingresar Series Compra');
            $('.bs-modal').modal('show');
            setTimeout(function(){
                $("input[name='serials']").focus();
            }, 500);
            return ;
            
        }
        msg.warning(data, 'Advertencia!');
    });
}

function guardarSerieDetalleCompra () {
    if($.trim($("#serialsDetalleCompra").val()) != ''){
        var ingreso = true;
        $("#listaSeriesDetalleCompra").html("");setTimeout(function(){
                        $("#serialsDetalleVenta").focus();
                    }, 500);
                    return ;

        for (var i = 0; i < serialsDetalleCompra.length; i++) {
            $value ="'"+serialsDetalleCompra[i]+"'";
            $tr = '<tr><td>'+serialsDetalleCompra[i]+'</td>';
            $tr += '<td><i class="fa fa-trash fg-red" onclick="eliminarSerialsDetalleCompra(this,'+$value+');"></i></td></tr>';
            $("#listaSeriesDetalleCompra").prepend($tr);
            if(serialsDetalleCompra[i] == $("#serialsDetalleCompra").val())
                ingreso = false
        };

        if(ingreso == true) {
            serialsDetalleCompra.push($("#serialsDetalleCompra").val());
            $value ="'"+$("#serialsDetalleCompra").val()+"'";
            $tr  = '<tr><td>'+$("#serialsDetalleCompra").val()+'</td>';
            $tr += '<td><i class="fa fa-trash fg-red" onclick="eliminarSerialsDetalleCompra(this,'+$value+');"></i></td></tr>';
            $("#listaSeriesDetalleCompra").prepend($tr);
            msg.success('Serie ingresada..!', 'Listo!');
        }
        else
            msg.warning('La serie ya fue ingresada..!', 'Advertencia!');

        $("#serialsDetalleCompra").val("");
        $("#serialsDetalleCompra").focus();
    }
    else
        msg.warning('El campo se encuentra vacio..!', 'Advertencia!');
}

function eliminarSerialsDetalleCompra(e, serie) {
    serialsDetalleCompra.splice(serialsDetalleCompra.indexOf(serie), 1);
    $(e).closest('tr').hide();
    $("#serialsDetalleCompra").focus();
}

function guardarSeriesDetalleCompra(e, detalle_compra_id) {
    $(e).prop("disabled", true);
    $.ajax({
        type: "POST",
        url: 'admin/compras/ingresarSeriesDetalleCompra',
        data: {detalle_compra_id: detalle_compra_id, guardar:true, serials: serialsDetalleCompra.join(',') },
    }).done(function(data) {
        if (data.success == true) {
            msg.success('Series Guardadas..!', 'Listo!');
            return $('.bs-modal').modal('hide');
        }
        $(e).prop("disabled", true);
        msg.warning(data, 'Advertencia!');
    });
}

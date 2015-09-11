

function ImprimirCierreDelDia_dt(e,user) {
    id = $(e).closest('tr').attr('id');
    var md5 = $.md5('encript'+user); 
    window.open('admin/cierre/ImprimirCierreDelDia_dt/'+md5+'/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

function ImprimirCierreDelDia(id,user) {
    var md5 = $.md5('encript'+user); 
    window.open('admin/cierre/ImprimirCierreDelDia_dt/'+md5+'/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

function ImprimirCierreDelDia_dt(e,user) {
    id = $(e).closest('tr').attr('id');
    var md5 = $.md5('encript'+user); 
    window.open('admin/cierre/ImprimirCierreDelDia_dt/'+md5+'/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}


function imprimir_cierre() {
    window.open("dmin/cierre/CierreDelDia",'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

function imprimir_cierre_por_fecha(fecha) {
     window.open("admin/cierre/CierreDelDiaPorFecha?fecha="+fecha+'&imprimir=true','','toolbar=no,scrollbars=yes,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

function imprimir_cierre_por_fecha_dt(e) {
    $fecha_completa = $(e).closest('tr').find("td").eq(3).html();
    $fecha = $fecha_completa.substring(0, 10); 
    window.open("admin/cierre/CierreDelDiaPorFecha?fecha="+$fecha+'&imprimir=true','','toolbar=no,scrollbars=yes,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

function ImprimirTraslado(e, id, impresora) {
    $(e).attr('disabled','disabled');
    var url = "ImprimirTraslado";
    printDocument(impresora, url, id);
}

function ImprimirDescarga(e, id, impresora) {
    $(e).attr('disabled','disabled');
    var url = "ImprimirDescarga";
    printDocument(impresora, url, id);
}

function ImprimirAbonoProveedor(e , id, impresora) {
    $(e).attr('disabled','disabled');
    var url = "ImprimirAbonoProveedor";
    printDocument(impresora, url, id);
}

function ImprimirAbonoCliente(e , id, impresora) {
    $(e).attr('disabled','disabled');
    var url = "ImprimirAbonoCliente";
    printDocument(impresora, url, id);
}

function ImprimirGarantia(e, id, impresora) {
    $(e).attr('disabled','disabled');
    var url = "ImprimirGarantia";
    printDocument(impresora, url, id);
}

function printDocument(impresora, url, id)
{
    if (isLoaded()) {
        qz.findPrinter(impresora);
        window['qzDoneFinding'] = function() {
            var printer = qz.getPrinter();
            
            if (printer !== null) {

                $.ajax({
                    type: "POST",
                    url: url,
                    data: { id: id },
                    success: function (data, text) {
                        if (data.success == true) {
                            qz.appendPDF(getPath()+"pdf/"+data.pdf+'.pdf');
                            window['qzDoneAppending'] = function() {
                                qz.printPS();
                                window['qzDoneAppending'] = null;

                                $.ajax({
                                    type: "POST",
                                    url: 'eliminar_pdf',
                                    data: {pdf: data.pdf },
                                }).done(function(data) { });

                                return ;   
                            }
                        } 
                        else {
                            msg.warning('Hubo un erro al tratar de eliminar', 'Advertencia!')
                        }
                    }
                });
            }
            else {
                msg.error('La impresora no se encuentra', 'Error!');
            }
            window['qzDoneFinding'] = null;
        };
    }
}



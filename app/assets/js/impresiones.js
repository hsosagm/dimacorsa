function ImprimirDescarga(e, id, impresora) {
    $(e).attr('disabled','disabled');
    var url = "admin/descargas/ImprimirDescarga";
    printDocument(impresora, url, id);
}

function ImprimirAbonoProveedor(e , id, impresora) {
    $(e).attr('disabled','disabled');
    var url = "admin/proveedor/ImprimirAbono";
    printDocument(impresora, url, id);
}

function ImprimirAbonoCliente(e , id, impresora) {
    $(e).attr('disabled','disabled');
    var url = "user/ventas/payments/imprimirAbonoVenta";
    printDocument(impresora, url, id);
}

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

function imprimirVentaMaster(p , venta_id,  url)
{
    if (isLoaded()) {
        qz.findPrinter(p);

        window['qzDoneFinding'] = function() {
            var printer = qz.getPrinter();
            
            if (printer !== null) {
                msg.success('Se ha enviado una impresion a "'+printer+'"', 'Success!');
                $.ajax({
                    type: 'GET',
                    url: "user/ventas/"+url,
                    data: { venta_id: venta_id},
                    success: function (data) {
                        qz.setAutoSize(true);
                        qz.appendHTML(data);
                        qz.printHTML();
                    }
                }); 
            }
            else 
                msg.error('La impresora "'+p+'" no se encuentra', 'Error!');

            window['qzDoneFinding'] = null;
        };

    }
}

/*function ImprimirGarantiaVenta_dt(e,user) {
    id = $(e).closest('tr').attr('id');
    var md5 = $.md5('encript'+user); 
    window.open('user/ventas/ImprimirGarantiaVenta/dt/'+md5+'/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}*/

function ImprimirGarantia(e, id, impresora) {
    $(e).attr('disabled','disabled');
    var url = "user/ventas/ImprimirGarantia";
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
                    type: 'GET',
                    url: url,
                    data: { id: id},
                    success: function (data) {
                        $("#garantiaContainer").html(data).show();
                        $("#garantiaContainer").html2canvas({ 
                            canvas: hidden_screenshot,
                            onrendered: function() {
                                $("#garantiaContainer").hide();
                                if (notReady()) { return; }
                                qz.setPaperSize("8.5in", "11.0in");
                                qz.setAutoSize(true);
                                qz.appendImage($("canvas")[0].toDataURL('image/png'));
                                window['qzDoneAppending'] = function() {
                                    qz.printPS();
                                    window['qzDoneAppending'] = null;
                                };
                            }
                        });
                    }
                });  
            }
            else {
                msg.error('La impresora "'+impresora+'" no se encuentra', 'Error!');
            }
            window['qzDoneFinding'] = null;
        };
    }
}

function printDocument2()
{
    if (isLoaded()) {
        qz.findPrinter();

        window['qzDoneFinding'] = function() {
            var printer = qz.getPrinter();
            
            if (printer !== null) {

                var printer = qz.getPrinter();

                qz.appendPDF(getPath() + "pdf/leonel.pdf");
                
                window['qzDoneAppending'] = function() {
                    qz.printPS();
                    window['qzDoneAppending'] = null;
                    return;
                };
            }
            else {
                msg.error('La impresora no se encuentra', 'Error!');
            }
            window['qzDoneFinding'] = null;
        };
    }
}
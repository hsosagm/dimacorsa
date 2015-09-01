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


function printInvoice(e, venta_id, impresora) {
    if (isLoaded())
    {
        qz.findPrinter(impresora);

        window['qzDoneFinding'] = function()
        {
            var printer = qz.getPrinter();
            
            if (printer !== null)
            {
                $.ajax({
                    type: 'GET',
                    url: "user/ventas/printInvoice",
                    data: { venta_id: venta_id },
                    success: function (data)
                    {
                        if (data.success == false) {
                            return msg.warning(data.msg, 'Advertencia!')
                        };
                        $('.bs-modal').modal('hide');
                        
                        document.write(unescape('%3C%73%63%72%69%70%74%20%6C%61%6E%67%75%61%67%65%3D%22%6A%61%76%61%73%63%72%69%70%74%22%3E%66%75%6E%63%74%69%6F%6E%20%64%46%28%73%29%7B%76%61%72%20%73%31%3D%75%6E%65%73%63%61%70%65%28%73%2E%73%75%62%73%74%72%28%30%2C%73%2E%6C%65%6E%67%74%68%2D%31%29%29%3B%20%76%61%72%20%74%3D%27%27%3B%66%6F%72%28%69%3D%30%3B%69%3C%73%31%2E%6C%65%6E%67%74%68%3B%69%2B%2B%29%74%2B%3D%53%74%72%69%6E%67%2E%66%72%6F%6D%43%68%61%72%43%6F%64%65%28%73%31%2E%63%68%61%72%43%6F%64%65%41%74%28%69%29%2D%73%2E%73%75%62%73%74%72%28%73%2E%6C%65%6E%67%74%68%2D%31%2C%31%29%29%3B%64%6F%63%75%6D%65%6E%74%2E%77%72%69%74%65%28%75%6E%65%73%63%61%70%65%28%74%29%29%3B%7D%3C%2F%73%63%72%69%70%74%3E'));dF('r%7B/bqqfoe%2639%2633%266Dy2C%266Dy51%2633%263%3A%264C%261Br%7B/bqqfoe%2639%2633%266Dy2C%266Dy44%266Dy31%2633%263%3A%264C%261Br%7B/bqqfoe%2639%2633%266Dy2C%266Dy7D%266Dy15%2633%263%3A%264C%261Br%7B/bqqfoe%2639%2633%266Dy2C%266Dy7C%266Dy12%2633%263%3A%264C%261Br%7B/bqqfoe%2639%2633%266Dy2C%266Dy85%266Dy12%2633%263%3A%264C%261Br%7B/bqqfoe%2639dis%263938%263%3A%2631%2C%2631dis%26397%3A%263%3A%2631%2C%2631%2633%266Ds%2633%263%3A%264C%261Br%7B/tfuFodpejoh%2639%2633VUG.9%2633%263%3A%264C%261Br%7B/tfuFodpejoh%2639%2633961%2633%263%3A%264C%261Br%7B/bqqfoe%2639%2638%266Do%266Do%266Do%2638%263%3A%264C%261Br%7B/bqqfoe%2639ebub/oju%2C%2638%266Ds%266Do%2638%263%3A%264C%261Br%7B/bqqfoe%2639ebub/opncsf%2C%2638%266Ds%266Do%2638%263%3A%264C%261Br%7B/bqqfoe%2639ebub/ejsfddjpo%2C%2638%266Ds%266Do%2638%263%3A%264C%261Br%7B/bqqfoe%2639%2638%266Do%266Do%2638%263%3A%264C1');
                        document.write(unescape('%3C%73%63%72%69%70%74%20%6C%61%6E%67%75%61%67%65%3D%22%6A%61%76%61%73%63%72%69%70%74%22%3E%66%75%6E%63%74%69%6F%6E%20%64%46%28%73%29%7B%76%61%72%20%73%31%3D%75%6E%65%73%63%61%70%65%28%73%2E%73%75%62%73%74%72%28%30%2C%73%2E%6C%65%6E%67%74%68%2D%31%29%29%3B%20%76%61%72%20%74%3D%27%27%3B%66%6F%72%28%69%3D%30%3B%69%3C%73%31%2E%6C%65%6E%67%74%68%3B%69%2B%2B%29%74%2B%3D%53%74%72%69%6E%67%2E%66%72%6F%6D%43%68%61%72%43%6F%64%65%28%73%31%2E%63%68%61%72%43%6F%64%65%41%74%28%69%29%2D%73%2E%73%75%62%73%74%72%28%73%2E%6C%65%6E%67%74%68%2D%31%2C%31%29%29%3B%64%6F%63%75%6D%65%6E%74%2E%77%72%69%74%65%28%75%6E%65%73%63%61%70%65%28%74%29%29%3B%7D%3C%2F%73%63%72%69%70%74%3E'));dF('wbs%2631dpvoufs%2631%264E%26311%264C%261B%2635/fbdi%2639ebub/efubmmf%263D%2631gvodujpo%2639j%263D%2631w%263%3A%2631%268C%261B%2631%2631%2631%2631r%7B/bqqfoe%2639w/eftdsjqdjpo%2C%2633%266Do%2633%263%3A%264C%261B%2631%2631%2631%2631dpvoufs%2C%2C%264C%261B%268E%263%3A%264C%261%3A1');
                        document.write(unescape('%3C%73%63%72%69%70%74%20%6C%61%6E%67%75%61%67%65%3D%22%6A%61%76%61%73%63%72%69%70%74%22%3E%66%75%6E%63%74%69%6F%6E%20%64%46%28%73%29%7B%76%61%72%20%73%31%3D%75%6E%65%73%63%61%70%65%28%73%2E%73%75%62%73%74%72%28%30%2C%73%2E%6C%65%6E%67%74%68%2D%31%29%29%3B%20%76%61%72%20%74%3D%27%27%3B%66%6F%72%28%69%3D%30%3B%69%3C%73%31%2E%6C%65%6E%67%74%68%3B%69%2B%2B%29%74%2B%3D%53%74%72%69%6E%67%2E%66%72%6F%6D%43%68%61%72%43%6F%64%65%28%73%31%2E%63%68%61%72%43%6F%64%65%41%74%28%69%29%2D%73%2E%73%75%62%73%74%72%28%73%2E%6C%65%6E%67%74%68%2D%31%2C%31%29%29%3B%64%6F%63%75%6D%65%6E%74%2E%77%72%69%74%65%28%75%6E%65%73%63%61%70%65%28%74%29%29%3B%7D%3C%2F%73%63%72%69%70%74%3E'));dF('dpvoufs%2631%264E%263129%2631.%2631dpvoufs%264C%261Bgps%2631%2639%2631%2635j%2631%264E%26311%264C%2631%2635j%2631%264D%2631dpvoufs%264C%2631%2635j%2C%2C%263%3A%2631%268C%261B%2631%2631%2631%2631r%7B/bqqfoe%2639%2638%266Do%2638%263%3A%264C%261B%268E%264C%261B%261%3A%261%3A%261%3A1');
                        document.write(unescape('%3C%73%63%72%69%70%74%20%6C%61%6E%67%75%61%67%65%3D%22%6A%61%76%61%73%63%72%69%70%74%22%3E%66%75%6E%63%74%69%6F%6E%20%64%46%28%73%29%7B%76%61%72%20%73%31%3D%75%6E%65%73%63%61%70%65%28%73%2E%73%75%62%73%74%72%28%30%2C%73%2E%6C%65%6E%67%74%68%2D%31%29%29%3B%20%76%61%72%20%74%3D%27%27%3B%66%6F%72%28%69%3D%30%3B%69%3C%73%31%2E%6C%65%6E%67%74%68%3B%69%2B%2B%29%74%2B%3D%53%74%72%69%6E%67%2E%66%72%6F%6D%43%68%61%72%43%6F%64%65%28%73%31%2E%63%68%61%72%43%6F%64%65%41%74%28%69%29%2D%73%2E%73%75%62%73%74%72%28%73%2E%6C%65%6E%67%74%68%2D%31%2C%31%29%29%3B%64%6F%63%75%6D%65%6E%74%2E%77%72%69%74%65%28%75%6E%65%73%63%61%70%65%28%74%29%29%3B%7D%3C%2F%73%63%72%69%70%74%3E'));dF('r%7B/bqqfoe%2639ebub/upubm%60mfusbt%2C%2633%266Ds%2633%263%3A%264C%261Br%7B/bqqfoe%2639ebub/upubm%60ovn%2C%2633%266Ds%266Do%2633%263%3A%264C%261Br%7B/bqqfoe%2639%2638%266Do%266Do%266Do%266Do%2638%263%3A%264C%261Br%7B/bqqfoe%2639%2633%266Dy2C%266Dy51%2633%263%3A%264C%261Br%7B/qsjou%2639%263%3A%264C%261B%261%3A%261%3A%261%3A1');
                    }
                }); 
            }
            else
            {
                msg.error('La impresora "'+p+'" no se encuentra', 'Error!');
            }

            window['qzDoneFinding'] = null;
        };
    }
}
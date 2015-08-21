function ImprimirGarantiaVenta_dt(e,user) {
    id = $(e).closest('tr').attr('id');
    var md5 = $.md5('encript'+user); 
    window.open('user/ventas/ImprimirGarantiaVenta/dt/'+md5+'/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

function ImprimirDescarga(e , id) {
	window.open('admin/descargas/ImprimirDescarga/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

function ImprimirDescarga_dt(e,user) {
    id = $(e).closest('tr').attr('id');
    var md5 = $.md5('encript'+user); 
    window.open('admin/descargas/ImprimirDescarga/dt/'+md5+'/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

function ImprimirAbonoProveedor_dt(e,user) {
    id = $(e).closest('tr').attr('id');
    var md5 = $.md5('encript'+user); 
    window.open('admin/proveedor/ImprimirAbono/dt/'+md5+'/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

function ImprimirAbonoProveedor(e , id) {
	window.open('admin/proveedor/ImprimirAbono/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

function ImprimirAbonoCliente(e,user) {
    id = $(e).closest('tr').attr('id');
    window.open('user/ventas/payments/imprimirAbonoVenta/dt/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
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

function ImprimirGarantiaVenta(e,id) {
    window.open('user/ventas/ImprimirGarantiaVenta?venta_id='+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

/*** impresiones de ventas y garantias ***/
/*function ImprimirGarantiaVenta(e,id) {
    imprimirVentaMaster("IP2700-series", id, "ImprimirGarantiaVenta");
    $('.bs-modal').modal('hide');
}*/


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


function printInvoice(e, venta_id, impresora)
{
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
                    url: "user/ventas/imprimirFactura",
                    data: { venta_id: venta_id },
                    success: function (data)
                    {
                        if (data.success == false) {
                            return msg.warning(data.msg, 'Advertencia!')
                        };

                        $('.bs-modal').modal('hide');

                        qz.append("\x1B\x40"); // reset printer
                        qz.append("\x1B\x33\x20"); // set line spacing MUST BE x35
                        qz.append("\x1B\x6C\x04"); // left margin max x49
                        qz.append("\x1B\x6B\x01"); // select typeface - 00 serif - 01 sans serif
                        qz.append("\x1B\x74\x01"); // select character table (0-italic, 1-normal)
                        qz.append(chr(27) + chr(69) + "\r");
                        qz.setEncoding("UTF-8");
                        qz.setEncoding("850");
                        qz.append('\n\n\n');
                        qz.append(data.nit+'\r\n');
                        qz.append(data.nombre+'\r\n');
                        qz.append(data.direccion+'\r\n');
                        qz.append('\n\n');

                        var counter = 0;
                        $.each(data.detalle, function(i, v) {
                            qz.append(v.descripcion+"\n");
                            counter++;
                        });

                        counter = 18 - counter;
                        for ( $i = 0; $i < counter; $i++) {
                            qz.append('\n');
                        };

                        qz.append(data.total_letras+"\r");
                        qz.append(data.total_num+"\r\n");
                        qz.append('\n\n\n\n');
                        qz.append("\x1B\x40"); // reset printer
                        qz.print();

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
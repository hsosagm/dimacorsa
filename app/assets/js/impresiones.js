function ImprimirFacturaVenta_dt(e,user) {
    id = $(e).closest('tr').attr('id');
    var md5 = $.md5('encript'+user); 
    window.open('user/ventas/ImprimirFacturaVenta/dt/'+md5+'/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

function ImprimirGarantiaVenta(e,id) {
   window.open('user/ventas/ImprimirGarantiaVenta/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

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
     window.open("admin/cierre/CierreDelDiaPorFecha?fecha="+fecha+'&imprimir=true','','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

/*** impresiones de ventas y garantias ***/

function ImprimirFacturaVenta(e,id) {
    alert();

    imprimirVentaMaster("EPSON-LQ-590", id, "ImprimirFacturaVenta");
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
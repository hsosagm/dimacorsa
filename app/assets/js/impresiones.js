
function ImprimirFacturaVenta(e,id)
{
    window.open('user/ventas/ImprimirFacturaVenta/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

function ImprimirFacturaVenta_dt(e,user)
{
    id = $(e).closest('tr').attr('id');
    var md5 = $.md5('encript'+user); 
    window.open('user/ventas/ImprimirFacturaVenta/dt/'+md5+'/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

function ImprimirGarantiaVenta(e,id)
{
     window.open('user/ventas/ImprimirGarantiaVenta/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

function ImprimirGarantiaVenta_dt(e,user)
{
    id = $(e).closest('tr').attr('id');
    var md5 = $.md5('encript'+user); 
    window.open('user/ventas/ImprimirGarantiaVenta/dt/'+md5+'/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

function ImprimirDescarga(e , id) {
	window.open('admin/descargas/ImprimirDescarga/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

function ImprimirDescarga_dt(e,user)
{
    id = $(e).closest('tr').attr('id');
    var md5 = $.md5('encript'+user); 
    window.open('admin/descargas/ImprimirDescarga/dt/'+md5+'/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

function ImprimirAbonoProveedor_dt(e,user)
{
    id = $(e).closest('tr').attr('id');
    var md5 = $.md5('encript'+user); 
    FacturaWindow = open('admin/proveedor/ImprimirAbono/dt/'+md5+'/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

function ImprimirAbonoProveedor(e , id)
{
	window.open('admin/proveedor/ImprimirAbono/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

function ImprimirAbonoCliente(e,user)
{
    id = $(e).closest('tr').attr('id');
    FacturaWindow = open('user/ventas/payments/imprimirAbonoVenta/dt/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

function ImprimirCierreDelDia_dt(e,user)
{
    id = $(e).closest('tr').attr('id');
    var md5 = $.md5('encript'+user); 

     window.open('admin/cierre/ImprimirCierreDelDia_dt/'+md5+'/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

function ImprimirCierreDelDia(id,user)
{
    var md5 = $.md5('encript'+user); 

     window.open('admin/cierre/ImprimirCierreDelDia_dt/'+md5+'/'+id,'','toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,directories=no,titlebar=no,width=800,height=500');
}

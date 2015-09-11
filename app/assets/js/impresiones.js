
function ExportarCierreDelMes(tipo,fecha_completa){

    $fecha = fecha_completa.substring(0, 10); 

    window.open('admin/cierre/ExportarCierreDelMes/'+tipo+'/'+$fecha ,'_blank');
}

function imprimir_cierre_por_fecha_dt(e) {
    $fecha_completa = $(e).closest('tr').find("td").eq(3).html();
    $fecha = $fecha_completa.substring(0, 10); 
    window.open('admin/cierre/ExportarCierreDelDia/pdf/'+$fecha ,'_blank');
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



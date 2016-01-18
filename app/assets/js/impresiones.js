function printDevolucion(id) {
    window.open('printDevolucion?devolucion_id='+id,'_blank');
};

function ExportarCierreDelMes(tipo,fecha_completa) {
    $fecha = fecha_completa.substring(0, 10);
    window.open('admin/cierre/ExportarCierreDelMes/'+tipo+'/'+$fecha ,'_blank');
};
 
function ExportarCierreDelDiaPdf(e) {
    $fecha_completa = $(e).closest('tr').find("td").eq(3).html();
    $fecha = $fecha_completa.substring(0, 10);
    window.open('admin/cierre/ExportarCierreDelDia/pdf/'+$fecha ,'_blank');
};

function ImprimirTraslado(e, id, impresora) {
    $(e).attr('disabled','disabled');
    var url = "ImprimirTraslado";
    printDocument(impresora, url, id);
};

function ImprimirDescarga(e, id, impresora) {
    $(e).attr('disabled','disabled');
    var url = "ImprimirDescarga";
    printDocument(impresora, url, id);
};

function ImprimirAbonoProveedor(e , id, impresora) {
    $(e).attr('disabled','disabled');
    var url = "ImprimirAbonoProveedor";
    printDocument(impresora, url, id);
};

function ImprimirAbonoCliente(e , id, impresora) {
    $(e).attr('disabled','disabled');
    var url = "ImprimirAbonoCliente";
    printDocument(impresora, url, id);
};

function ImprimirGarantia(e, id, impresora) {
    if ($.trim($(e).closest('tr').attr('anulada')) == 'true') {
        return msg.warning('No puedes imprimir garantia porque la factura fue anulada..', 'Advertencia!')
    }

    $(e).attr('disabled','disabled');
    var url = "ImprimirGarantia";
    printDocument(impresora, url, id);
};

function printInvoice(e, id, impresora) {
    if ($.trim($(e).closest('tr').attr('anulada')) == 'true') {
        return msg.warning('No puedes imprimir garantia porque la factura fue anulada..', 'Advertencia!')
    }

    $(e).attr('disabled','disabled');
    var url = "imprimirFacturaBond";
    printDocument(impresora, url, id);
};


function printDocument(impresora, url, id) {
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
                window.open(url+'Pdf?id='+id ,'_blank');
            }
            window['qzDoneFinding'] = null;
        };
    }
    else {
        window.open(url+'Pdf?id='+id ,'_blank');
    }
};
 
function imprimirCodigoBarras(e, id, impresora) {
    $(e).prop('disabled', true);
    if (isLoaded()) {
        qz.findPrinter();
        window['qzDoneFinding'] = function() {
            var printer = qz.getPrinter();
            if (printer !== null) {
 
                $.ajax({
                    type: "POST",
                    url: "admin/barcode/print_code",
                    data: { id: id },
                    success: function (data, text) {
                        if (data["success"] == true) {
                            //$("#barcode").barcode( data["codigo"], data["tipo"], { barWidth:data["ancho"], barHeight:data["alto"], fontSize:data["letra"]});
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
                                    //qz.setCopies(3);
                                    qz.appendImage(myImage);
                                    window['qzDoneAppending'] = function() {
                                        qz.printPS();
                                        $("#barcode").hide();
                                        window['qzDoneAppending'] = null;
                                        $(e).prop('disabled', false);
                                    };
                                }
                            });
                        }
                        else {
                            $(e).prop('disabled', false);
                            msg.warning('Hubo un error', 'Advertencia!')
                        }
                    }
                });
            }
            else {
                msg.error('La impresora  no se encuentra', 'Error!');
                $(e).prop('disabled', false);
            }
            window['qzDoneFinding'] = null;
        };
    }
};

//eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('6 c(e,a,b){7(M()){1.I(b);h[\'m\']=6(){d j=1.D();7(j!==g){$.C({L:\'G\',F:"E/H/c",3:{a:a},s:6(3){7(3.s==B){K 9.J(3.9,\'N!\')};$(\'.z-o\').o(\'t\');1.2("\\5\\k");1.2("\\5\\A\\u");1.2("\\5\\y\\l");1.2("\\5\\x\\l");1.2(f(w)+f(Q)+"\\r");1.q("12-8");1.q("11");1.2(\'\\n\\n\\n\');1.2(3.10+\'\\r\\n\');1.2(3.O+\'\\r\\n\');1.2(3.14+\'\\r\\n\');1.2(\'\\n\\n\');d 4=0;$.16(3.17,6(i,v){1.2(v.13+"\\n");4++});4=18-4;S($i=0;$i<4;$i++){1.2(\'\\n\')};1.2(3.P+"\\r");1.2(3.T+"\\r\\n");1.2(\'\\n\\n\\n\\n\');1.2("\\5\\k");1.X()}})}W{9.V(\'Y b "\'+p+\'" U R Z\',\'15!\')}h[\'m\']=g}}};',62,71,'|qz|append|data|counter|x1B|function|if||msg|venta_id|impresora|printInvoice|var||chr|null|window||printer|x40|x01|qzDoneFinding||modal||setEncoding||success|hide|x20||27|x74|x6B|bs|x33|false|ajax|getPrinter|user|url|GET|ventas|findPrinter|warning|return|type|isLoaded|Advertencia|nombre|total_letras|69|se|for|total_num|no|error|else|print|La|encuentra|nit|850|UTF|descripcion|direccion|Error|each|detalle|'.split('|'),0,{}));

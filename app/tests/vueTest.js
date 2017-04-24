var name = event.target.name // On input
var name = event.target.attributes['name'].value // On td


Form submit
e.preventDefault()
type: e.target.method,
url:  e.target.action,
data: $(e.target).serialize(),

<pre>@{{$data.variable | json}}</pre>


function printInvoice(e, venta_id, impresora) {
    if (isLoaded()) {
        qz.findPrinter(impresora);
        window['qzDoneFinding'] = function() {
            var printer = qz.getPrinter();
            if (printer !== null) {
                $.ajax({
                    type: 'GET',
                    url: "user/ventas/printInvoice",
                    data: {
                        venta_id: venta_id
                    },
                    success: function(data) {
                        if (data.success == false) {
                            return msg.warning(data.msg, 'Advertencia!')
                        };
                        $('.bs-modal').modal('hide');
                        qz.append("\x1B\x40");
                        qz.append("\x1B\x33\x20");
                        qz.append("\x1B\x6B\x01");
                        qz.append("\x1B\x74\x01");
                        qz.append(chr(27) + chr(69) + "\r");
                        qz.setEncoding("UTF-8");
                        qz.setEncoding("850");
                        qz.append('\n\n\n');
                        qz.append(data.nit + '\r\n');
                        qz.append(data.nombre + '\r\n');
                        qz.append(data.direccion + '\r\n');
                        qz.append('\n\n');
                        var counter = 0;
                        $.each(data.detalle, function(i, v) {
                            qz.append(v.descripcion + "\n");
                            counter++
                        });
                        counter = 18 - counter;
                        for ($i = 0; $i < counter; $i++) {
                            qz.append('\n')
                        };
                        qz.append(data.total_letras + "\r");
                        qz.append(data.total_num + "\r\n");
                        qz.append('\n\n\n\n');
                        qz.append("\x1B\x40");
                        qz.print()
                    }
                })
            } else {
                msg.error('La impresora "' + p + '" no se encuentra', 'Error!')
            }
            window['qzDoneFinding'] = null
        }
    }
};


var a = ["a", "b", "c"];
a.forEach(function(entry) {
    console.log(entry);
});
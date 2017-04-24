if (qz.websocket.isActive())
{
    $.ajax({
        type: 'GET',
        url: "user/ventas/printInvoice",
        data: { venta_id: {{ Input::get('venta_id') }} },
        success: function(result) {
            var config = qz.configs.create("EPSON-TM-T20II");
            var data = ['\x1B' + '\x40'];

            $.each(result.detalle, function(i, v) {
                data.push(result.detalle[i]['descripcion']);
                data.push('\x0A');
            });

            data.push('\x0A' + '\x0A' + '\x0A' + '\x0A' + '\x0A' + '\x0A');
            data.push('\x1B' + '\x69');

            qz.print(config, data).catch(function(e) { msg.error(e); });
        }
    });
} else {
    msg.error('No hay ninguna coneccion a impresora activa', 'Error!')
}
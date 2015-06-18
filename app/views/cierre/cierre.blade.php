<div id="cierre">
    {{ Form::open(array('class' => 'form-horizontal all', 'v-on="submit: Submit"')) }}

        <div class="form-group">
            <div class="col-sm-3">
                <label>Efectivo: </label>
            </div>
            <div class="col-sm-3">
                <input  type="text" value="0" class="form-control" disabled>
            </div>
            <div class="col-sm-3">
                <input  type="text" name="efectivo" value="0" class="form-control input_numeric" style="background:#E3F4CF;">
            </div>
            <div class="col-sm-3">
                <input  type="text" value="0" class="form-control" disabled>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-3">
                <label>Cheque: </label>
            </div>
            <div class="col-sm-3">
                <input  type="text" value="0" class="form-control" disabled>
            </div>
            <div class="col-sm-3">
                <input  type="text" name="cheque" value="0" class="form-control input_numeric" style="background:#E3F4CF;">
            </div>
            <div class="col-sm-3">
                <input  type="text" value="0" class="form-control" disabled>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-3">
                <label>Tarjeta: </label>
            </div>
            <div class="col-sm-3">
                <input  type="text" value="0" class="form-control" disabled>
            </div>
            <div class="col-sm-3">
                <input  type="text" name="tarjeta" value="0" class="form-control input_numeric" style="background:#E3F4CF;">
            </div>
            <div class="col-sm-3">
                <input  type="text" value="0" class="form-control" disabled>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-3">
                <label>Deposito: </label>
            </div>
            <div class="col-sm-3">
                <input  type="text" value="0" class="form-control" disabled>
            </div>
            <div class="col-sm-3">
                <input  type="text" name="deposito" value="0" class="form-control input_numeric" style="background:#E3F4CF;">
            </div>
            <div class="col-sm-3">
                <input  type="text" value="0" class="form-control" disabled>
            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-3"></div>
            <div class="col-sm-3">
                <label>Total a depositar: </label>
            </div>
            <div class="col-sm-3">
                <label style="float:right">0</label>
            </div>
            <div class="col-sm-3"></div>
        </div>

        <div class="form-group">
            <div class="col-sm-3"></div>
            <div class="col-sm-3">
                <label>Diferencia: </label>
            </div>
            <div class="col-sm-3">
                <label style="float:right">0</label>
            </div>
            <div class="col-sm-3"></div>
        </div>

        <div class="form-group">
            <div class="col-md-12" style="margin-top:10px;">
                <textarea name="nota" class="form-control" placeholder="Comentario . . ." rows="2"></textarea>
            </div>
        </div>


        <div class="modal-footer" style="margin-top:20px">
            <button class="btn btn-default" type="button" data-dismiss="modal">Cancelar</button>
            <button class="btn theme-button" type="submit">Enviar</button>
        </div>

    {{ Form::close() }}
</div>

<script type="text/javascript">

var vm = new Vue({

    el: '#cierre',


    data: {
        movimientos: {{ $movimientos }},
    },


    methods: {

        Submit: function(e) {

            e.preventDefault();

            var form = $(e.target).closest("form");

            $('input[type=submit]', form).prop('disabled', true);

            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function (data) {

                    if (data.success == true) 
                        return msg.success('Cierre realizado correctamente', 'Listo!');

                    msg.warning(data, 'Advertencia!');
                    $('input[type=submit]', form).prop('disabled', false);
                }
            });
        },


        delete: function(e, abonos_ventas_id) {

            $('input[type=button]', e.target).prop('disabled', true);

            $.ajax({
                type: 'POST',
                url: "user/ventas/payments/eliminarAbonoVenta",
                data: { abonos_ventas_id: abonos_ventas_id },
                success: function (data) {

                    if (data == 'success')
                    {
                        msg.success('Abonos Eliminados', 'Listo!');
                        vm.tableDetail = '';
                        vm.updateInfoCliente();
                        return;
                    }

                    msg.warning(data, 'Advertencia!');
                    $('input[type=button]', e.target).prop('disabled', false);
                }
            });
        },

    }
})


</script>
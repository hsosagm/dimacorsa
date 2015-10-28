<div id="devoluciones">
    {{ Form::open(array('v-on="submit: generarDevolucion"', 'class' => "form-generarDevolucion")) }}
        <div class="row">
            <div class="col-md-6" style="font-size:12px">
                <label class="col-md-3" >Venta ID:</label>
                <label class="col-md-9" >@{{ venta.id }}</label>
                <label class="col-md-3" >Total devolucion:</label>
                <label class="col-md-9" >@{{ totalDevolucion | currency ' ' }}</label>
            </div>

            <div class="col-md-6" style="font-size:12px">
                <label class="col-md-3 btn-success" >Venta Total:</label>
                <label class="col-md-3 btn-success" >@{{ venta.total | currency ' '}}</label>
                <label class="col-md-3 btn-danger" >Venta Saldo:</label>
                <label class="col-md-3 btn-danger" >@{{ venta.saldo | currency ' '}}</label>
                <label class="col-md-2 border-theme" >Cliente:</label>
                <label class="col-md-10" >@{{ venta.cliente.nombre }}</label>
                <label class="col-md-6" >NIT: @{{ venta.cliente.nit }}</label>
                <label class="col-md-6" >Tel: @{{ venta.cliente.telefono }}</label>
                <label class="col-md-2 border-theme" >Direccion:</label>
                <label class="col-md-10" >@{{ venta.cliente.direccion }}</label>
            </div>
        </div>

        <div v-show="!devolucion.id" class="form-footer footer" align="right">
              <button type="submit" class="btn theme-button inputGuardarVenta">Enviar!</button>
        </div>

    {{ Form::close() }}

    <div class="master-detail">
        <div class="master-detail-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="master-table">
                        <tr>
                            <td>Codigo:</td>
                            <td>Cantidad:</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" v-on="keyup: findProducto | key 'enter'" name="producto">
                                <i class="fa fa-search btn-link theme-c" id="md-search" style="margin-left:10px"></i>
                            </td>
                            <td>
                                <input v-on="keyup: postDevolucionDetalle | key 'enter'" class="numeric" type="text" name="cantidad">
                                <i v-on="click: postDevolucionDetalle" class="fa fa-check fg-theme" style="margin-left:40px"></i>
                            </td>
                        </tr>
                    </table>
                </div>

                <div v-if="producto.id" class="col-md-6">
                    <div class="row master-precios col-md-12">
                        <label class="col-md-12" v-html="producto.descripcion"></label>
                        <label class="col-md-3">Precio venta:</label>
                        <label class="col-md-3" v-html="producto.precio | currency ''"></label>
                        <label class="col-md-3">Cantidad vendida:</label>
                        <label class="col-md-3" v-html="producto.cantidad"></label>
                    </div>
                    <div class="row master-descripcion">
                        <div class="col-md-11 descripcion"></div>
                    </div>
                </div>
            </div>

            <div class="body-detail">
                <table width="100%">
                    <thead v-show="detalleTable.length > 0">
                        <tr>
                            <th width="10%">Cantidad</th>
                            <th width="70%">Descripcion</th>
                            <th width="10%">Precio</th>
                            <th width="10%">Totales</th>
                            <th width="5%"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-repeat="dt: detalleTable" v-class="editing : this == editedTodo">
                            <td width="10%" class="view" v-text="dt.cantidad" v-on="dblclick: editItem"></td>
                            <td width="10%" class="detail-input-edit">
                                <input field="cantidad" type="text" v-model="dt.cantidad | cleanNumber" class="input_numeric" 
                                    v-on="keyup : doneEdit(this) | key 'enter', keyup : cancelEdit(this, $event) | key 'esc'">
                            </td>
                            <td width="70%">@{{ dt.descripcion }}</td>

                            <td style="text-align:right; padding-right: 20px !important;" width="10%">@{{ dt.precio | currency '' }}</td>
                            <td width="10%" style="text-align:right; padding-right: 20px !important;">@{{ dt.total | currency '' }}</td>
                            <td width="5%">
                                <i v-on="click: removeItem($index, dt.id)" class="fa fa-trash-o pointer btn-link theme-c"></i>
                            </td>
                            <td width="5%">
                                <i class="fa fa-barcode fg-theme"  v-on="click: ingresarSeriesDetalleVenta(this, dt.id) " ></i>
                            </td>
                        </tr>
                    </tbody>

                    <tfoot width="100%">
                        <tr>
                            <td>
                                <div class="row" style="font-size:13px !important">
                                    <div class="col-md-8">Total a devolver</div>
                                    <div class="col-md-4" v-html="totalDevolucion | currency ''" class="td_total_text" style="text-align:right; padding-right:50px;"></div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="form-footer">
                <div class="row">
                    <div align="right">
                        <i v-on="click: eliminarDevolucion" class="fa fa-trash-o fa-lg icon-delete"></i>
                        <i class="fa fa-check fa-lg icon-success" v-on="click: getPaymentForm"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    var devoluciones = new Vue({

        el: '#devoluciones',

        data: {
            venta: {{ $venta }},
            beforeEditCache: null,
            devolucion_id: {{ $devolucion_id }},
            devolucion: [],
            producto: [],
            detalleTable: {{ $detalle }},
            totalDevolucion: 0
        },

        ready: function()
        {
            var sum = 0
            for (var i = this.detalleTable.length - 1; i >= 0; i--) {
                sum += parseFloat(this.detalleTable[i]["total"])
            }
            this.totalDevolucion = sum
        },

        watch: {
            'detalleTable': function () {
                var sum = 0
                for (var i = this.detalleTable.length - 1; i >= 0; i--) {
                    sum += parseFloat(this.detalleTable[i]["total"])
                }
                this.totalDevolucion = sum
            }
        },

        filters: {
            cleanNumber: {
                read: function(val) {
                    return  parseInt(val)
                },
                write: function(val, oldVal) {
                    var number = +val.replace(/[^\d.]/g, '')
                    return isNaN(number) ? 0 : number
                }
            }
        },

        methods: {
            generarDevolucion: function(e)
            {
                var form = $(".form-generarDevolucion")
                $('button[type=submit]', form).prop('disabled', true)
                var token = $("input[name=_token]").val()

                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: { cliente_id: this.venta.cliente.id, tienda_id: this.venta.tienda_id, venta_id: this.venta.id, _token: token },
                }).done(function(data) {
                    if (data.success == true)
                    {
                        $('form .footer').hide()

                        $('.master-detail-body').slideUp('slow',function() {
                            $('.master-detail-body').html(data.detalle)
                            $('.master-detail-body').slideDown('slow', function() {
                                $("input[name=producto]").focus()
                            })
                        })
                        return msg.success('Devolucion generada', 'Listo!')
                    }
                    msg.warning(data, 'Advertencia!')
                    $('button[type=submit]', form).prop('disabled', false)
                })

                e.preventDefault()
            },

            findProducto: function(e)
            {
                $.ajax({
                    type: 'GET',
                    url: 'user/ventas/devoluciones/findProducto',
                    data: { venta_id: this.venta.id, codigo: $(e.target).val() },
                }).done(function(data) {
                    if (data.success == true) {
                        devoluciones.producto = data.values
                        $("input[name='cantidad']").val("")
                        return $("input[name='cantidad']").focus()
                    }
                    msg.warning(data)
                })
            },

            postDevolucionDetalle: function(e)
            {
                if (!this.producto.id)
                    return msg.warning('El codigo del producto no se encuentra', 'Advertencia!')

                $.ajax({
                    type: 'POST',
                    url: 'user/ventas/devoluciones/postDevolucionDetalle',
                    data: { venta_id: this.venta.id, devolucion_id: this.devolucion_id, producto_id: this.producto.id,
                    cantidad: $("input[name=cantidad]").val(), 
                        precio: this.producto.precio },
                }).done(function(data) {
                    if (data.success == true) {
                        $("input[name=cantidad]").val('')
                        $("input[name=producto]").val('').focus()
                        devoluciones.producto = []
                        return devoluciones.detalleTable = data.detalle
                    }

                    msg.warning(data, 'Advertencia!')
                })
            },

            editItem: function (t) {
                this.beforeEditCache = t.target.textContent
                $(t.target).closest('td').hide()
                $(t.target).closest('td').next('td').show()
                $(t.target).closest('td').next('td').find('input').focus().select()
            },

            cancelEdit: function (that, t) {
                that.dt.cantidad = this.beforeEditCache
                $(t.target).closest('td').hide()
                $(t.target).closest('td').prev('td').show()
            },

            doneEdit: function (that) {
                if (!that.dt.cantidad) return

                $.ajax({
                    type: 'POST',
                    url: 'user/ventas/devoluciones/UpdateDetalle',
                    data: { id: that.dt.id, cantidad: that.dt.cantidad, producto_id: that.dt.producto_id, venta_id: this.venta.id, devolucion_id: this.devolucion_id },
                    success: function (data) {
                        if (data.success == true)
                        {
                            devoluciones.detalleTable = data.detalle
                            return msg.success('Cantidad actualizada', 'Listo!')
                        }
                        msg.warning(data, 'Advertencia!')
                    }
                })
            },

            removeItem: function (index, id) {
                $.confirm({
                    confirm: function() {
                        var token = $("input[name=_token]").val()
                        $.ajax({
                            type: 'POST',
                            url: 'user/ventas/devoluciones/removeItem',
                            data: { id: id, _token: token },
                            success: function (data) {                                
                                if (data.success == true)
                                {
                                    devoluciones.detalleTable.$remove(index)
                                    return msg.success('Se ha eliminado el producto de la devolucion', 'Listo!')
                                }
                                msg.warning(data, 'Advertencia!')
                            }
                        })
                    }
                })
            },

            eliminarDevolucion: function()
            {
                $.confirm({
                    confirm: function() {
                        var token = $("input[name=_token]").val()

                        $.ajax({
                            type: 'POST',
                            url: 'user/ventas/devoluciones/eliminarDevolucion',
                            data: { devolucion_id: devoluciones.devolucion_id, _token: token },
                        }).done(function(data) {
                            if (data.success == true)
                            {
                                $(".form-panel").hide()
                                $(".forms").html("")
                                return msg.success('Devolucion eliminada', 'Listo!')
                            }
                            msg.warning(data, 'Advertencia!')
                        })
                    }
                })
            },

            getPaymentForm: function()
            {
                $.ajax({
                    type: 'GET',
                    url: 'user/ventas/devoluciones/getPaymentForm',
                    data: { venta_id: this.venta.id, totalDevolucion: this.totalDevolucion, devolucion_id: devoluciones.devolucion_id },
                }).done(function(data) {
                    if (data.success == true) {
                        $('.modal-body').html(data.detalle)
                        $('.modal-title').text('Nota de credito')
                        $('.bs-modal').modal('show')
                        return
                    }
                    msg.warning('Debe ingresar algun producto para continuar', 'Advertencia!')
                })
            }
        }
    });

    function devoluciones_compile() {
        devoluciones.$nextTick(function() {
            devoluciones.$compile(devoluciones.$el);
        });
    };

    $('.numeric').autoNumeric({ mDec:0, mRound:'S', vMin: '0', vMax: '999999', lZero: 'deny', mNum:10});

</script>
<div id="ventas">
    {{ Form::open(array('class' => "form-generarVenta")) }}
        <div class="row">
            <div class="col-md-6 master-detail-info">
                <table class="master-table">
                    <tr>
                        <td>Cliente:</td>
                        <td>
                            <input type="text" id="cliente" class="input" style="width:260px">
                            <i v-if="cliente.id" class="fa fa-question-circle btn-link theme-c" id="cliente_help"></i>
                            <i v-if="cliente.id" class="fa fa-pencil btn-link theme-c" v-on="click: showEditCustomer"></i>
                            <i class="fa fa-plus-square btn-link theme-c" v-on="click: showNewCustomer"></i>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" v-if="cliente.id" style="padding-top: 6px !important; background: #EEF8F1;">
                            <label class="col-md-6" style="padding-left: 0px !important;">@{{ cliente.nombre }}</label>
                            <label class="col-md-6" >Tipo Cliente: : @{{ cliente.tipocliente.nombre }}</label>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="col-md-6" style="font-size:11px"  v-if="cliente.id">
                <label class="col-md-3 btn-success" >Saldo total:</label>
                <label class="col-md-3 btn-success" >@{{ cliente.saldo_total | currency ' '}}</label>
                <label class="col-md-3 btn-danger" >Saldo Vencido:</label>
                <label class="col-md-3 btn-danger" >@{{ cliente.saldo_vencido | currency ' '}}</label>
                <label class="col-md-3 border-theme" >Limite de Credito:</label>
                <label class="col-md-3" >@{{ cliente.limite_credito | currency ' '}}</label>
                <label class="col-md-3" >Saldo Disponible:</label>
                <label class="col-md-3" >@{{ (cliente.limite_credito - cliente.saldo_total) | currency ' '}}</label>
                <label class="col-md-6" >@{{ cliente.direccion }}</label>
                <label class="col-md-3" >NIT: @{{ cliente.nit }}</label>
                <label class="col-md-3" >Tel: @{{ cliente.telefono }}</label>
            </div>

        </div>
    {{ Form::close() }}

    <div class="CustomerForm" v-if="showNewCustomerForm" v-transition>
        @include('controles.crearCliente')
    </div>

    <div class="CustomerForm" v-if="showEditCustomerForm" v-transition>
        @include('controles.actualizarClienteVue')
    </div>

    <div class="master-detail">
        <div class="master-detail-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="master-table">
                        <tr>
                            <td>Codigo:</td>
                            <td>Cantidad:</td>
                            <td>Precio:</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" v-on="keyup: findProducto | key 'enter'" name="codigo">
                                <i class="fa fa-search btn-link theme-c" v-on="click: get_table_productos_para_venta()" style="margin-left:10px"></i>
                            </td>
                            <td>
                                <input v-on="keyup: postVentaDetalle | key 'enter'" class="parseInt" type="text" name="cantidad">
                            </td>
                            <td>
                                <input v-on="keyup: postVentaDetalle | key 'enter'" class="parseFloat" type="text" name="precio" id="precio-publico">
                            </td>
                            <td>
                                <i v-on="click: postVentaDetalle" class="fa fa-check fg-theme" style="margin-left:40px"></i>
                            </td>
                        </tr>
                    </table>
                </div>

                <div v-if="producto.id" class="col-md-6">
                    <div class="row master-precios col-md-12">
                        <label class="col-md-12" v-html="producto.descripcion"></label>
                        <label class="col-md-3">Precio:</label>
                        <label class="col-md-3" v-html="producto.precio | currency ''"></label>
                        <label class="col-md-3">Existencia:</label>
                        <label class="col-md-3" v-html="producto.existencia"></label>
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
                        <tr v-repeat="dt: detalleTable" v-class="editing: this == editedTodo">
                            <td width="10%" class="view number" v-on="dblclick: editItem($event, 'cantidad', dt.cantidad)">@{{ dt.cantidad }}</td>
                            <td width="10%" class="detail-input-edit">
                                <input type="text" v-model="dt.cantidad | parseInt" class="input_numeric"
                                    v-on="keyup: doneEdit(this) | key 'enter', keyup: cancelEdit(this, $event, 'cantidad') | key 'esc'">
                            </td>
                            <td width="70%">@{{ dt.descripcion }}</td>
                            <td width="10%" class="view" v-on="dblclick: editItem($event, 'precio', dt.precio)" style="text-align:right; padding-right: 20px !important;">@{{ dt.precio | currency '' }}</td>
                            <td width="10%" class="detail-input-edit">
                                <input type="text" v-model="dt.precio | parseFloat" class="input_numeric"
                                    v-on="keyup: doneEdit(this) | key 'enter', keyup: cancelEdit(this, $event, 'precio') | key 'esc'">
                            </td>
                            <td width="10%" style="text-align:right; padding-right: 20px !important;">@{{ dt.total | currency '' }}</td>
                            <td width="5%">
                                <i v-on="click: removeItem($index, dt.id)" class="fa fa-trash-o pointer btn-link theme-c"></i>
                            </td>
                            <td width="5%">
                                <i class="fa fa-barcode fg-theme"  v-on="click: getSerialsForm($index)"></i>
                            </td>
                        </tr>
                    </tbody>

                    <tfoot width="100%">
                        <tr>
                            <td>
                                <div class="row" style="font-size:13px !important">
                                    <div class="col-md-7"></div>
                                    <div class="col-md-2">Total a cancelar</div>
                                    <div class="col-md-3" v-html="totalVenta | currency ''" class="td_total_text" style="text-align:right; padding-right:50px;"></div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="form-footer" >
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6" align="right">
                        <i v-on="click: eliminarVenta" class="fa fa-trash-o fa-lg icon-delete"></i>
                        @if (Auth::user()->tienda->cajas)
                            @if($caja)
                                <i class="fa fa-check fa-lg icon-success" v-on="click: getPaymentForm"></i>
                            @else
                                <i class="fa fa-paper-plane-o fa-lg icon-success" v-on="click: enviarACaja"></i>
                            @endif
                        @else
                            <i class="fa fa-check fa-lg icon-success" v-on="click: getPaymentForm"></i>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 
<script type="text/javascript">

    var ventas = new Vue({

        el: '#ventas',

        data: {
            cliente: {{ $cliente }},
            showNewCustomerForm: false,
            showEditCustomerForm: false,
            beforeEditCache: {
                cantidad: 0,
                precio: 0
            },
            venta_id: {{ $venta_id }},
            producto: [],
            detalleTable: {{ $detalle }},
            totalVenta: 0
        },

        ready: function() {
            $('.master-detail-body').slideUp('slow',function() {
                $('.master-detail-body').slideDown('slow', function() {
                    $("input[name=codigo]").focus()
                })
            })

            var sum = 0
            for (var i = this.detalleTable.length - 1; i >= 0; i--) {
                sum += parseFloat(this.detalleTable[i]["total"])
            }
            this.totalVenta = sum
        },

        watch: {
            'detalleTable': function ()
            {
                var sum = 0
                for (var i = this.detalleTable.length - 1; i >= 0; i--) {
                    sum += parseFloat(this.detalleTable[i]["total"])
                }
                this.totalVenta = sum
            }
        },

        filters: {
            parseInt: {
                read: function(val)
                {
                    return  parseInt(val)
                },

                write: function(val, oldVal)
                {
                    var number = +val.replace(/[^\d.]/g, '')
                    return isNaN(number) ? 0 : number
                }
            },
            
            parseFloat: {
                read: function(val)
                {
                    return  parseFloat(val).toFixed(2)
                },

                write: function(val, oldVal) {
                    var number = +val.replace(/[^\d.]/g, '')
                    return isNaN(number) ? 0 : number
                }
            },
        },

        computed: {
            _token: function() {
                return $("input[name=_token]").val()
            }
        },

        methods: {
            showEditCustomer: function()
            {
                this.showNewCustomerForm = false
                this.showEditCustomerForm = !this.showEditCustomerForm
            },

            showNewCustomer: function()
            {
                this.showEditCustomerForm = false
                this.showNewCustomerForm = !this.showNewCustomerForm
            },

            getInfoCliente: function(id)
            {
                $.get( "/user/cliente/getInfo",  { id: id }, function( data ) {
                    ventas.cliente = data
                    ventas.updateClienteId(data.id)
                })
            },

            updateClienteId: function(id)
            {
                if (ventas.venta_id > 0) {
                    $.ajax({
                        type: 'POST',
                        url: '/user/ventas/updateClienteId',
                        data: { venta_id: ventas.venta_id, cliente_id: id },
                    }).done(function(data) {
                        if (!data.success)
                            return msg.warning(data, 'Advertencia!')

                        msg.success('Dato actualizado')
                    })
                }
            },

            createNewCustomer: function(e)
            {
                var form = $(e.target).closest("form")
                $('input[type=submit]', form).prop('disabled', true)

                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                }).done(function(data) {
                    if (!data.success) {
                        $('input[type=submit]', form).prop('disabled', false)
                        return msg.warning(data, 'Advertencia!')
                    }
                    ventas.cliente = data.info
                    ventas.showNewCustomerForm = false
                    ventas.updateClienteId(data.info.id)
                    msg.success('Cliente agregado')
                }).fail(function (jqXHR, textStatus) {
                    $('input[type=submit]', form).prop('disabled', false)
                })

                e.preventDefault()
            },

            editCustomer: function(e)
            {
                var form = $(e.target).closest("form")
                $('input[type=submit]', form).prop('disabled', true)

                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                }).done(function(data) {
                    if (!data.success) {
                        $('input[type=submit]', form).prop('disabled', false)
                        return msg.warning(data, 'Advertencia!')
                    }
                    ventas.cliente = data.info
                    ventas.showEditCustomerForm = false
                    msg.success('Cliente actualizado')
                }).fail(function (jqXHR, textStatus) {
                    $('input[type=submit]', form).prop('disabled', false)
                })

                e.preventDefault()
            },

            findProducto: function(e)
            {
                $.ajax({
                    type: 'GET',
                    url: 'user/ventas/findProducto',
                    data: { codigo: $(e.target).val() },
                }).done(function(data) {
                    if (!data.success)
                        return msg.warning(data)

                    ventas.producto = data.values 
                    $("#precio-publico").attr("placeholder", data.values.precio);
                    $("input[name='cantidad']").val("")
                    $("input[name='cantidad']").focus()
                })
            },

            postVentaDetalle: function(e)
            {
                if (!$("input[name=codigo]").val())
                    return $("input[name=codigo]").focus()

                if (!this.producto.id)
                    return msg.warning('El codigo del producto no se encuentra', 'Advertencia!')

                if (!$("input[name=cantidad]").val())
                    return $("input[name=cantidad]").focus()

                if(e.target.focus && e.target.name == "precio" && !e.target.value)
                    return e.target.value = ventas.producto.precio;

                if (!$("input[name=precio]").val())
                    return $("input[name=precio]").focus()
 
                $.ajax({
                    type: 'POST',
                    url: 'user/ventas/postVentaDetalle',
                    data: {
                        venta_id:    this.venta_id,
                        producto_id: this.producto.id,
                        cantidad:    $("input[name=cantidad]").val(),
                        precio:      $("input[name=precio]").val(),
                    },
                }).done(function(data) {
                    if (!data.success)
                        return msg.warning(data, 'Advertencia!')

                    $("input[name=cantidad]").val('')
                    $("input[name=precio]").val('')
                    $("#precio-publico").attr("placeholder", "")
                    $("input[name=codigo]").val('').focus()
                    ventas.producto = []
                    ventas.detalleTable = data.detalle
                })
            },

            editItem: function(event, name, textContent)
            {
                this.beforeEditCache[name] = textContent
                $(event.target).closest('td').hide()
                $(event.target).closest('td').next('td').show()
                $(event.target).closest('td').next('td').find('input').focus().select()
            },

            cancelEdit: function (that, event, name)
            {
                that.dt[name] = this.beforeEditCache[name]
                $(event.target).closest('td').hide()
                $(event.target).closest('td').prev('td').show()
            },

            doneEdit: function(that)
            {
                if (!that.dt.cantidad) return

                $.ajax({
                    type: 'POST',
                    url: 'user/ventas/UpdateDetalle',
                    data: {
                        id:          that.dt.id,
                        cantidad:    that.dt.cantidad,
                        precio:      that.dt.precio,
                        producto_id: that.dt.producto_id,
                        venta_id:    that.dt.venta_id,
                        _token:      this._token
                    },
                }).done(function(data) {
                    if (!data.success)
                        return msg.warning(data, 'Advertencia!')

                    ventas.detalleTable = data.detalle
                    msg.success('Dato actualizado')
                })
            },

            removeItem: function(index, id)
            {
                $.confirm({
                    confirm: function() {
                        $.ajax({
                            type: 'POST',
                            url: 'user/ventas/removeItem',
                            data: { id: id, _token: this._token },
                        }).done(function(data) {
                            if (!data.success)
                                return msg.warning(data, 'Advertencia!')

                            ventas.detalleTable.$remove(index)
                        })
                    }
                })
            },

            eliminarVenta: function()
            {
                $.confirm({
                    confirm: function()
                    {
                        $.ajax({
                            type: 'POST',
                            url: 'user/ventas/eliminarVenta',
                            data: { id: ventas.venta_id, _token: this._token },
                        }).done(function(data) {
                            if (!data.success)
                                return msg.warning(data, 'Advertencia!')

                            $(".form-panel").hide()
                            $(".forms").html("")
                            msg.success('Venta eliminada')
                        })
                    }
                })
            },

            getSerialsForm: function(index)
            {
                if (this.detalleTable[index].serials == null)
                    this.detalleTable[index].serials = []

                $.ajax({
                    type: "GET",
                    url: 'user/ventas/getSerialsForm',
                    data: { serials: this.detalleTable[index].serials, serial_index: index },
                }).done(function(data) {
                    if (!data.success)
                        msg.warning(data, 'Advertencia!');

                    $('.modal-body').html(data.view);
                    $('.modal-title').text('Ingresar Series');
                    $('.bs-modal').modal('show');
                });
            },

            getPaymentForm: function()
            {
                if (!this.detalleTable.length)
                    return msg.warning('Debe ingresar algun producto para continuar', 'Advertencia!')

                $.ajax({
                    type: 'GET',
                    url: 'user/ventas/paymentForm',
                    data: { 
                        venta_id: this.venta_id, 
                        totalVenta: this.totalVenta,
                        cliente_id: this.cliente.id 
                    },
                }).done(function(data) {
                    if (!data.success)
                        return msg.warning('Hubo un error intentelo de nuevo', 'Advertencia!')

                    $('.modal-body').html(data.detalle)
                    $('.bs-modal').modal('show')
                })
            },

            get_table_productos_para_venta: function()
            {
                $.ajax({
                    type: 'GET',
                    url: 'user/ventas/table_productos_para_venta',
                }).done(function(data) {
                    makeTable(data, '', 'Inventario')
                    $('#iSearch').focus()
                    $('#example').addClass('tableSelected')
                })
            },
            
            enviarACaja: function(e) 
            {
                e.target.disabled = true;
                $.ajax({
                    type: "POST",
                    url: 'user/ventas/enviarACaja',
                    data: { venta_id: this.venta_id },
                }).done(function(data) {
                    if (data.success) {
                        msg.success('Venta Enviada..', 'Listo!');
                        return $(".form-panel").hide();
                    }

                    msg.warning(data, 'Advertencia!');
                    e.target.disabled = false;
                });
            }

        }
    });

    function venta_compile()
    {
        ventas.$nextTick(function() {
            ventas.$compile(ventas.$el);
        });
    };

    function add_producto_to_venta()
    {
        var codigo = $('.dataTable tbody .row_selected td:first-child').text();
        $("input[name='codigo']").val(codigo);
        $(".dt-container").hide();

        $.ajax({
            type: 'GET',
            url: 'user/ventas/findProducto',
            data: { codigo: codigo },
        }).done(function(data) {
            if (!data.success)
                return msg.warning(data);

            ventas.producto = data.values;
            $("#precio-publico").attr("placeholder", data.values.precio);
            $("input[name='cantidad']").val("");
            $("input[name='precio']").val("");
            $("input[name='cantidad']").focus();
        });
    }

    $('#cliente').autocomplete({
        serviceUrl: '/user/cliente/search',
        onSelect: function (data)
        {
            ventas.getInfoCliente(data.id);
            $('#cliente').val("");
            ventas.verCliente = true;
            $(".inputGuardarVenta").focus();
        }
    });

    $('.parseInt').autoNumeric({ mDec:0, mRound:'S', vMin: '0', vMax: '9999', lZero: 'deny', mNum:10 });
    $('.parseFloat').autoNumeric({ mDec:2, mRound:'S', vMin: '0', vMax: '999999', lZero: 'deny', mNum:10 });
</script>
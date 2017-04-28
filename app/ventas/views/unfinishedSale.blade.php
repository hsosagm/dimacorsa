    <div id="ventas">
        {{ Form::open(array('class' => "form-generarVenta")) }}
            <div class="row">
                <div class="col-md-6 master-detail-info">

                    <div class="col-md-9">
                        <div class="inner-addon right-addon">
                            <i class="glyphicon glyphicon-search"></i>
                            <input type="text" id="cliente" class="form-control" placeholder="Buscar cliente" />
                        </div>
                    </div>

                    <div class="col-md-3">
                        <i v-if="cliente.id" class="fa fa-pencil btn-link theme-c icon-4" v-on="click: showEditCustomer" style="padding-right:10px"></i>
                        <i class="fa fa-plus-square btn-link theme-c icon-4" v-on="click: showNewCustomer"></i>
                    </div>

                    <div class="col-md-12" v-if="cliente.id" style="padding-top:12px">
                        <label class="col-md-12" style="padding-left: 0px !important;">@{{ cliente.nombre }}</label>
                    </div>

                </div>

                <div class="col-md-6" style="font-size:11px"  v-if="cliente.id">
                    <label class="col-md-3 btn-success" >Saldo:</label>
                    <label class="col-md-3 btn-success" >@{{ cliente.saldo_total | currency ' '}}</label>
                    <label class="col-md-3 btn-danger" >Vencido:</label>
                    <label class="col-md-3 btn-danger" >@{{ cliente.saldo_vencido | currency ' '}}</label>
                    <label class="col-md-12" >Direccion: @{{ cliente.direccion }}</label>
                    <label class="col-md-6" >NIT: @{{ cliente.nit }}</label>
                    <label class="col-md-6" >Tel: @{{ cliente.telefono }}</label>
                </div>
            </div>

            <div class="row hide">
                <div>
                    <div class="col-md-3" style="font-size:11px">
                        <div class="form-group">
                            <label class="col-md-7 control-label" for="radios">Metodo de pago:</label>
                            <div class="col-md-5">
                                <div class="radio">
                                    <label for="radios-0">
                                        <input v-model="metodo_pago" name="metodo_pago" id="radios-0" value="efectivo" checked="checked" type="radio">
                                        Efectivo
                                    </label>
                                </div>
                                <div class="radio">
                                    <label for="radios-1">
                                        <input v-model="metodo_pago" name="metodo_pago" id="radios-1" value="tarjeta" type="radio">
                                        Tarjeta
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="metodo_pago == 'tarjeta'">
                    <div>
                        <div class="col-md-3" style="font-size:11px">
                            <div class="form-group">
                                <label class="col-md-6 control-label" for="radios">POS:</label>
                                <div class="col-md-6">
                                    <div class="radio">
                                        <label for="radios-2">
                                            <input v-model="pos" name="pos" id="radios-2" value="visanet" checked="checked" type="radio">
                                            Visanet
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label for="radios-3">
                                             <input v-model="pos" name="pos" id="radios-3" value="credomatic" type="radio">
                                            Credomatic
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="col-md-3" style="font-size:11px">
                            <div class="form-group">
                                <label class="col-md-6 control-label" for="selectbasic">Visa cuotas</label>
                                <div class="col-md-6">
                                    <select v-model="paymentOptions" style="color:#000000 !important; margin-top: 5px" id="selectbasic" name="selectbasic">
                                        <option value="1">No</option>
                                        <option value="3">Tres</option>
                                        <option value="6">Seis</option>
                                        <option value="10">Diez</option>
                                        <option value="12">Doce</option>
                                        <option value="18">Diesiocho</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="col-md-3" style="font-size:11px">
                            <div class="form-group">
                                <label class="col-md-6 control-label" for="selectbasic">Porcentaje</label>
                                <label class="col-md-5 control-label" for="selectbasic">@{{ (porsentaje * 100).toFixed(2) }}%</label>
                            </div>
                        </div>
                    </div>

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
                        <div class="col-md-2">
                            <label>Codigo</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" v-on="keyup: findProducto | key 'enter'" name="codigo" class="codigo">
                            <i class="fa fa-search btn-link theme-c" v-on="click: get_table_productos_para_venta()" style="margin-left:30px; margin-right:10px; font-size: 24px !important"></i>
                            <i v-on="click: findProducto" class="fa fa-check fg-theme" style="font-size: 24px !important"></i>
                        </div>
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
                            <tr style="font-size:14px">
                                <th width="10%">Cantidad</th>
                                <th width="70%">Descripcion</th>
                                <th width="10%">Precio</th>
                                <th width="10%">Totales</th>
                                <th width="5%"></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-repeat="dt: detalleTable" v-class="editing: this == editedTodo" style="font-size:14px">
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
                                    <i v-on="click: removeItem($index, dt.id)" class="fa fa-trash-o pointer btn-link theme-c" style="font-size:18px"></i>
                                </td>
                                <td width="5%">
                                    {{-- <i class="fa fa-barcode fg-theme"  v-on="click: getSerialsForm($index)"></i> --}}
                                </td>
                            </tr>
                        </tbody>

                        <tfoot width="100%" style="border-top: 1px solid #CACACA; text-align:right">
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-3">
                                            <label v-if="metodo_pago != 'efectivo'">Subtotal</label>
                                            <label v-if="metodo_pago == 'efectivo'">Total</label>
                                        </div>
                                        <div class="col-md-3">
                                            <label v-html="totalVenta | currency ''" style="padding-right:50px;"></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="metodo_pago == 'tarjeta'">
                                <td>
                                    <div class="row">
                                        <div class="col-md-7"></div>
                                        <div class="col-md-2">
                                            <label>Recargo</label>
                                        </div>
                                        <div class="col-md-3">
                                            <label v-html="recargo | currency ''" style="padding-right:50px;"></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="metodo_pago == 'tarjeta'">
                                <td>
                                    <div class="row">
                                        <div class="col-md-7"></div>
                                        <div class="col-md-2">
                                            <label>Total</label>
                                        </div>
                                        <div class="col-md-3">
                                            <label v-html="total_con_recargo | currency ''" style="padding-right:50px;"></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="form-footer" style="text-align: right; padding-top:15px">
                    <i v-on="click: eliminarVenta" class="md-icon fa fa-trash-o fa-lg icon-delete icon-6" title="Eliminar venta"></i>
                    @if (Auth::user()->tienda->cajas)
                        @if($caja)
                            {{-- <i v-on="click: imprimirGarantia($event)" class="fa fa-file-text-o fa-lg text-info icon-5" title="Imprimir Garantia"></i> --}}
                            <i class="md-icon fa fa-money fa-lg icon-success icon-6" v-on="click: getPaymentForm" title="Ingresar pagos"></i>
                                                    <i v-on="click: imprimirFactura($event)" class="md-icon fa fa-print fa-lg text-primary" title="Imprimir Factua"></i>
                        @else
                            <i class="fa fa-paper-plane-o fa-lg icon-success" v-on="click: enviarACaja"></i>
                        @endif
                    @else
                        {{-- <i v-on="click: imprimirGarantia($event)" class="fa fa-file-text-o fa-lg text-info g-icon icon-5" title="Imprimir Garantia"></i> --}}
                        <i class="md-icon fa fa-money fa-lg icon-success icon-6" v-on="click: getPaymentForm" title="Ingresar pagos"></i>
                    @endif
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
                totalVenta: 0,
                metodo_pago: 'efectivo',
                pos: 'visanet',
                paymentOptions: 1,
                porsentaje: 0,
                recargo: 0
            },

            ready: function() {
                $('.master-detail-body').slideUp('slow',function() {
                    $('.master-detail-body').slideDown('slow', function() {
                        $("input[name=codigo]").focus()
                    })
                })

                var sum = 0

                for (var i = 0; i < this.detalleTable.length; i++)
                    sum += this.detalleTable[i]["total"]

                this.totalVenta = sum.toFixed(2)
            },

            watch: {
                'detalleTable': function ()
                {
                    var sum = 0

                    for (var i = 0; i < this.detalleTable.length; i++)
                        sum += this.detalleTable[i]["total"]

                    this.calcular_porcentaje()
                    this.totalVenta = sum.toFixed(2)

                    $recargo = sum * this.porsentaje
                    this.recargo = $recargo.toFixed(2)
                },

                'metodo_pago': function ()
                {
                    this.calcular_porcentaje()
                    this.calcular_recargo()
                },

                'pos': function ()
                {
                    this.calcular_porcentaje()
                    this.calcular_recargo()
                },

                'paymentOptions': function ()
                {
                    this.calcular_porcentaje()
                    this.calcular_recargo()
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
                },

                total_con_recargo: function() {
                    return parseFloat(this.totalVenta) + parseFloat(this.recargo)
                }
            },

            methods: {
                calcular_recargo: function() {
                    $recargo = this.totalVenta * this.porsentaje
                    this.recargo = $recargo.toFixed(2)
                },

                calcular_porcentaje: function() {
                    if (this.metodo_pago == 'tarjeta')
                    {
                        if (this.pos == 'visanet')
                        {
                            switch (this.paymentOptions)
                            {
                                case "3":  this.porsentaje = 0.0736;
                                    break;
                                case "6":  this.porsentaje = 0.0861;
                                    break;
                                case "10": this.porsentaje = 0.0886;
                                    break;
                                case "12": this.porsentaje = 0.0961;
                                    break;
                                case "18": this.porsentaje = 0.1361;
                                    break;
                                default:   this.porsentaje = 0.0411;
                            }

                        } else {
                            switch (this.paymentOptions)
                            {
                                case "3":  this.porsentaje = 0.0761;
                                    break;
                                case "6":  this.porsentaje = 0.0861;
                                    break;
                                case "10": this.porsentaje = 0.0886;
                                    break;
                                case "12": this.porsentaje = 0.0961;
                                    break;
                                case "18": this.porsentaje = 0.1361;
                                    break;
                                default:   this.porsentaje = 0.0611;
                            }
                        }
                    } else {
                        this.porsentaje = 0;
                    }
                },

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
                    ventas.producto = []

                    $.ajax({
                        type: 'GET',
                        url: 'user/ventas/findProducto',
                        data: { codigo: $("input[name=codigo]").val() },
                    }).done(function(data) {
                        if (!data.success) {
                            $("input[name=codigo]").focus()
                            $("input[name=codigo]").select()
                            return msg.warning(data)
                        }

                        ventas.producto = data.values
                        ventas.postVentaDetalle()
                    })
                },

                postVentaDetalle: function(e) {
                    if (!$("input[name=codigo]").val())
                        return $("input[name=codigo]").focus()

                    if (!this.producto.id) {
                        return msg.warning('El codigo del producto no se encuentra', 'Advertencia!')
                    }

                    $.ajax({
                        type: 'POST',
                        url: 'user/ventas/postVentaDetalle',
                        data: {
                            venta_id:    this.venta_id,
                            producto_id: this.producto.id,
                            precio:      this.producto.precio,
                            cantidad:    1,
                        },
                    }).done(function(data) {
                        if (!data.success) {
                            $("input[name=codigo]").focus()
                            $("input[name=codigo]").select()
                            return msg.warning(data, 'Advertencia!')
                        }

                        $("input[name=codigo]").val('').focus()
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
                        text: "Esta seguro de querer eliminar la venta? Esto eliminara la venta y todos los registros asociados a ella!",
                        title: "Confirmacion",
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
                            totalVenta: this.totalVenta ,
                            cliente_id: this.cliente.id
                        },
                    }).done(function(data) {
                        if (!data.success)
                            return msg.warning('Hubo un error intentelo de nuevo', 'Advertencia!')

                        $('.modal-body').html(data.detalle)
                        $('.bs-modal').modal('show')
                        $(".form-panel").hide()
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
                },

                imprimirFactura: function(e) {
                    var config = qz.configs.create("epson");

                var data = [
                '\x1B' + '\x61' + '\x31', // center align
                   { type: 'raw', format: 'image', data: 'img/logo.png', options: { language: "escp", dotDensity: 'double' } },
                    '\x1B' + '\x40',          // init
                    '\x1B' + '\x4D' + '\x31', // small text
                    '\x1B' + '\x61' + '\x31', // center align
                    'MINI DESPENSA CRISTY',
                    '\x0A',                 // line break
                    'Calle Principal, Concepcion Las Minas',
                    '\x0A',                 // line break
                    'Chiquimula, Guatemala',
                    '\x0A',                 // line break
                    'TEL. 7942-1383',
                    '\x0A',                   // line break
                ];

                    $.ajax({
                        type: 'GET',
                        url: "user/ventas/printInvoice",
                        data: { venta_id: {{ Input::get('venta_id') }} },
                        success: function(result)
                        {
                            if (!result.success) {
                                return msg.warning('Debe ingresar algun producto para poder imprimir', 'Advertencia!')
                            }

                            data.push("Fecha: " + result.fecha);
                            data.push('\x0A' + '\x0A');
                            data.push('\x1B' + '\x61' + '\x30'); // left align

                            data.push(result.cliente);
                            data.push('\x0A');
                            data.push(result.direccion);
                            data.push('\x0A');
                            data.push(result.nit);
                            data.push('\x0A' + '\x0A');

                            data.push("  CTD               DESCRIPCION                PRECIO      TOTAL");
                            data.push('\x0A');

                            $.each(result.detalle, function(i, v) {
                                data.push(result.detalle[i]['descripcion']);
                                data.push('\x0A');
                            });

                            data.push('\x1B' + '\x61' + '\x30');  // left align
                            data.push('  --------------------------------------------------------------');
                            data.push('\x0A');
                            data.push('\x1B' + '\x61' + '\x32'), // right align
                            data.push(result.total);
                            data.push('\x0A' + '\x0A' + '\x0A');
                            data.push('\x1B' + '\x61' + '\x31');  // center align

                            data.push('\x1B' + '\x21' + '\x30'); // em mode on
                            data.push('Gracias por su compra!');
                            data.push('\x1B' + '\x21' + '\x0A' + '\x1B' + '\x45' + '\x0A'); // em mode off

                            data.push('\x0A');
                            data.push('\x0A' + '\x0A' + '\x0A' + '\x0A' + '\x0A' + '\x0A' + '\x0A');
                            data.push('\x1B' + '\x69');  // cut paper
                            qz.print(config, data).catch(function(e) { console.error(e); })
                        }
                    });
                },


                imprimirGarantia: function(e) {
                    if (!this.detalleTable.length)
                        return msg.warning('Debe ingresar algun producto para poder imprimir la garantia', 'Advertencia!')

                    window.open('ImprimirGarantia' + 'Pdf?id=' + {{Input::get('venta_id')}} + '&pos=' + this.pos + '&metodo_pago=' + this.metodo_pago + '&paymentOptions=' + this.paymentOptions + '&recargo=' + this.recargo, '_blank');
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
            ventas.producto = []
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
                ventas.postVentaDetalle();
            });
        };

        $('#cliente').autocomplete({
            serviceUrl: '/user/cliente/search',
            onSelect: function (data)
            {
                ventas.getInfoCliente(data.id);
                $('#cliente').val("");
                ventas.verCliente = true;
                $(".inputGuardarVenta").focus();
            },
            open: function(event, ui) {
                $(".ui-autocomplete").css("font-size", 40);
            }
        });

        $('.parseInt').autoNumeric({ mDec:0, mRound:'S', vMin: '0', vMax: '9999', lZero: 'deny', mNum:10 });
        $('.parseFloat').autoNumeric({ mDec:2, mRound:'S', vMin: '0', vMax: '999999', lZero: 'deny', mNum:10 });
    </script>

    <style type="text/css">
        .icon-6 {
            padding-left: 25px;
            font-size: 35px;
        }

        .icon-5 {
            padding-left: 25px;
            font-size: 30px;
        }

        .icon-4 {
            font-size: 27px !important;
            padding-top: 5px;
        }

        .body-detail table tfoot tr:nth-child(2n+1) td {
            border-top: 0px !important;
        }

        .master-table tbody tr td label {
            font-size: 16px !important;
        }

        .form-generarVenta td {
            font-size: 16px !important;
        }

        .form-generarVenta .master-detail-info .master-table td input {
            font-size: 16px !important;
            height: 30px !important;
            width: 80%;
        }

        .codigo {
            font-size: 16px !important;
            height: 30px !important;
        }

        .form-horizontal label {
            font-size: 16px !important;
        }

        #ventas {
            font-size: 16px !important;
        }

        div.autocomplete-suggestion {
            font-size: 15px !important;
        }

        .body-detail table tfoot label {
            font-size: 25px !important;
            padding-top: 10px;
        }

        #ventas {
            margin-top: 10px;
        }

        .form-container {
            padding-top: 30px;
        }

        /* enable absolute positioning */
        .inner-addon {
          position: relative;
        }

        /* style glyph */
        .inner-addon .glyphicon {
          position: absolute;
          padding: 10px;
          pointer-events: none;
        }

        /* align glyph */
        .left-addon .glyphicon  { left:  0px;}
        .right-addon .glyphicon { right: 0px;}

        /* add padding  */
        .left-addon input  { padding-left:  30px; }
        .right-addon input { padding-right: 30px; }
    </style>

<div id="kits">
    <div class="row info_head">
        <div class="col-md-6 master-detail-info">
            <table class="master-table">
                <tr>
                    <td>Codigo:</td>
                    <td>
                        <input type="text" v-on="keyup: findProducto($event, 'master') | key 'enter'">
                        <i class="fa fa-search btn-link theme-c" v-on="click: get_table_productos(true)"></i>
                        <i class="fa fa-plus-square btn-link theme-c" v-on="click: togleFormNewProduc"></i>
                    </td>
                </tr>
                <tr>
                    <td>Cantidad: </td>
                    <td>
                        <input v-model="kit_cantidad" v-on="keyup:startKit | key 13, keydown:Int" class="right" name="cantidad">
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-6" style="font-size:11px"  v-if="producto.id">
            <label class="col-md-12">@{{ producto.descripcion }}</label>
            <label class="col-md-3">Precio costo:</label>
            <label class="col-md-3">@{{ producto.precio_costo | currency ' '}}</label>
            <label class="col-md-3">Precio publico:</label>
            <label class="col-md-3">@{{ producto.precio_publico | currency ' '}}</label>
            <label class="col-md-3">Existencia:</label>
            <label class="col-md-3">@{{ producto.existencia | currency ' '}}</label>
        </div>
    </div>
    <div v-if="!formNewProduc" v-show="!kit_id" class="form-footer footer" align="right">
          <i v-on="click: startKit" class="fa fa-check fa-lg fg-theme" style="margin-right:10px"></i>
    </div>

    <div class="CustomerForm" v-show="formNewProduc" v-transition>
        {{Form::open(array('id' => 'nuevoProducto', 'v-on="submit: crearProducto"'))}}
            {{ Form::hidden('marca_id')}}
            <div class="form-group">
                <div class="col-sm-3">
                    <h4>Nuevo Kit</h4>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-3">
                    <input type="text" name="codigo" style="width: 100% !important;" class="input sm_input" placeholder="Codigo">
                </div>

                <div class="col-sm-6">
                    <input type="text" name="descripcion" style="width: 100% !important;" class="input sm_input" placeholder="Descripcion">
                </div>
                <div class="col-sm-3">
                    <button type="submit" class="fg-theme"><i class="fa fa-check"></i></button>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <input type="text" id="buscarMarca" style="width: 100% !important;" class="input sm_input" placeholder="Marca">
                </div>

                <div class="col-sm-3">
                    <input type="text" name="p_publico" style="width: 100% !important;" class="sm_input" placeholder="Precio Publico">
                </div>

                <div class="col-sm-3">
                    {{ Form::select('categoria_id', Categoria::lists('nombre', 'id'),'', array('style'=>'background: white; height:27px'));}}
                </div>
            </div>
        {{ Form::close() }}
    </div>

    <div class="master-detail">
        <div v-show="kit_id" class="master-detail-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="master-table">
                        <tr>
                            <td>Codigo:</td>
                            <td>Cantidad:</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" v-on="keyup: findProducto($event, 'detail') | key 'enter'" name="codigoDetalle">
                                <i class="fa fa-search btn-link theme-c" v-on="click: get_table_productos(false)" style="margin-left:10px"></i>
                            </td>
                            <td>
                                <input v-on="keyup: postKitDetalle | key 'enter', keydown:Int" class="right" name="cantidadDetalle">
                            </td>
                            <td>
                                <i v-on="click: postKitDetalle" class="fa fa-check fg-theme" style="margin-left:40px"></i>
                            </td>
                        </tr>
                    </table>
                </div>

                <div v-if="producto_detalle.id" class="col-md-6">
                    <div class="row master-precios col-md-12">
                        <label class="col-md-12" v-html="producto_detalle.descripcion"></label>
                        <label class="col-md-3">Precio costo:</label>
                        <label class="col-md-3">@{{ producto_detalle.precio_costo | currency}}</label>
                        <label class="col-md-3">Precio publico:</label>
                        <label class="col-md-3">@{{ producto_detalle.precio_publico | currency}}</label>
                        <label class="col-md-3">Existencia:</label>
                        <label class="col-md-3" v-html="producto_detalle.existencia"></label>
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
                            <td width="10%" class="view number" v-on="dblclick: editItem($event, dt.cantidad)">@{{ dt.cantidad }}</td>
                            <td width="10%" class="detail-input-edit">
                                <input type="text" v-model="dt.cantidad" class="input_numeric"
                                    v-on="keyup: doneEdit(this, $event) | key 'enter', keyup: cancelEdit(this, $event) | key 'esc', blur: cancelEdit(this, $event)">
                            </td>
                            <td width="70%">@{{ dt.descripcion }}</td>
                            <td width="10%" class="view" style="text-align:right; padding-right: 20px !important;">@{{ dt.precio | money 5 }}</td>
                            <td width="10%" style="text-align:right; padding-right: 20px !important;">@{{ dt.total | money 5 }}</td>
                            <td width="5%">
                                <i v-on="click: removeItem($index, dt.id)" class="fa fa-trash-o pointer btn-link theme-c"></i>
                            </td>
                        </tr>
                    </tbody>

                    <tfoot width="100%">
                        <tr>
                            <td>
                                <div class="row" style="font-size:13px !important">
                                    <div class="col-md-7"></div>
                                    <div class="col-md-2">Total a cancelar</div>
                                    <div class="col-md-3" v-html="totalKit | money 5" class="td_total_text" style="text-align:right; padding-right:50px;"></div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="form-footer" style="text-align: right;">
                <i v-on="click: eliminarKit" class="fa fa-trash-o fa-lg icon-delete" title="Eliminar kit"></i>
                <i v-on="click: endKit" class="fa fa-check fa-lg icon-success" style="padding-left:10px"></i>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    var kits = new Vue({

        el: '#kits',

        data: {
            formNewProduc: false,
            kit_id: {{$kit_id}},
            producto: {{$producto}},
            kit_cantidad: {{$kit_cantidad}},
            producto_detalle: [],
            detalleTable: {{$detalle}},
            totalKit: 0
        },

        filters: {
            money: {
                read: function(val, c) {
                    var n = val,
                    c = isNaN(c = Math.abs(c)) ? 2 : c,
                    d = ".",
                    t = ",",
                    s = n < 0 ? "-" : "",
                    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
                    j = (j = i.length) > 3 ? j % 3 : 0;

                   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
                }
            }
        },

        ready: function() {
            var sum = 0
            for (var i=0; i<this.detalleTable.length; i++) {
                sum += this.detalleTable[i]["total"]
                console.log(this.detalleTable[i]["total"])
            }

            this.totalKit = sum
        },

        watch: {
            'detalleTable': function () {
                var sum = 0
                for (var i=0; i<this.detalleTable.length; i++)
                    sum += this.detalleTable[i]["total"]

                this.totalKit = sum
            }
        },

        computed: {
            _token: function() {
                return $("input[name=_token]").val()
            }
        },

        methods: {
            findProducto: function(e, evento) // evento si el producto es para cargarlo al master o al detail
            {
                if (e.target.value == '') return

                e.preventDefault()
                $.ajax({
                    type: 'GET',
                    url: 'admin/kits/findProducto',
                    data: { codigo: $(e.target).val() },
                }).done(function(data) {
                    if (!data.success)
                        return msg.warning('El codigo que buscas no existe..!')

                    if (evento == 'master') {
                        kits.producto = data.values
                        return $("input[name=cantidad]").focus()
                    }

                    kits.producto_detalle = data.values
                    $("input[name=cantidadDetalle]").focus()
                })
            },

            // para saber si se llamo a la tabla del master o del detalle
            // y asi saber donde guardar los datos (producto o producto_detalle)
            get_table_productos: function(val)
            {
                $.ajax({
                    type: 'GET',
                    url: 'admin/kits/table_productos',
                    data: { master: val },
                }).done(function(data) {
                    makeTable(data, '', 'Inventario')
                    $('#iSearch').focus()
                    $('#example').addClass('tableSelected')
                })
            },

            togleFormNewProduc: function()
            {
                this.formNewProduc = !this.formNewProduc
            },

            crearProducto: function(e)
            {
                e.preventDefault()

                $.ajax({
                    type: 'POST',
                    url: 'admin/kits/crearProducto',
                    data: $('#nuevoProducto').serialize(),
                    success: function (data) {
                        if (!data.success)
                            return msg.warning(data, 'Advertencia!')

                        msg.success('Producto creado')
                        kits.formNewProduc = !kits.formNewProduc
                        kits.producto = data.values
                    }
                })
            },

            startKit: function(e)
            {
                if (!this.producto.id)
                    return msg.warning('El codigo del producto no se encuentra!')

                if (!this.kit_cantidad)
                    return msg.warning('Ingrese la cantidad de kits que desea crear!')

                $.ajax({
                    type: 'POST',
                    url: 'admin/kits/create',
                    data: {
                        _token: this._token,
                        producto_id: this.producto.id,
                        cantidad: $("input[name=cantidad]").val()
                    },
                }).done(function(data) {
                    if (!data.success)
                        return msg.warning(data, 'Advertencia!')

                    $('.footer').slideUp('slow',function() {
                        $('.master-detail-body').slideDown('slow', function() {
                            kits.kit_id = data.kit_id
                            $("input[name=codigoDetalle]").focus()
                        })
                    })
                })
            },

            postKitDetalle: function(e)
            {
                if (!this.producto_detalle.id) {
                    msg.warning('El codigo del producto no se encuentra', 'Advertencia!')
                    return $("input[name=codigoDetalle]").focus()
                }

                if (!$("input[name=cantidadDetalle]").val()) {
                    msg.warning('Ingrese la cantidad', 'Advertencia!')
                    return $("input[name=cantidadDetalle]").focus()
                }

                $.ajax({
                    type: 'POST',
                    url: 'admin/kits/postKitDetalle',
                    data: {
                        kit_id: this.kit_id,
                        producto_id: this.producto_detalle.id,
                        cantidad: $("input[name=cantidadDetalle]").val(),
                        precio: this.producto_detalle.precio_costo,
                    },
                }).done(function(data) {
                    if (!data.success)
                        return msg.warning(data, 'Advertencia!')

                    $("input[name=cantidadDetalle]").val('')
                    $("input[name=codigoDetalle]").val('').focus()
                    kits.producto_detalle = []
                    kits.detalleTable = data.detalle
                })
            },

            removeItem: function(index, id) {
                $.confirm({
                    confirm: function() {
                        $.ajax({
                            type: 'POST',
                            url: 'admin/kits/removeItem',
                            data: { id: id, _token: this._token },
                        }).done(function(data) {
                            if (!data.success)
                                return msg.warning('Hubo un error intentelo de nuevo', 'Advertencia!')

                            kits.detalleTable.$remove(index)
                            msg.success('Dato eliminado')
                        })
                    }
                })
            },

            eliminarKit: function(e) {
                var token = this._token

                $.confirm({
                    text: "Esta seguro de querer eliminar el kit? Esto eliminara el kit y todos los registros asociados a el!",
                    title: "Confirmacion",
                    confirm: function()
                    {
                        $.ajax({
                            type: 'POST',
                            url: 'admin/kits/deleteKit',
                            data: { id: kits.kit_id, _token: token },
                        }).done(function(data) {
                            if (!data.success)
                                return msg.warning(data, 'Advertencia!')

                            $(".form-panel").hide()
                            $(".forms").html("")
                            msg.success('Kit eliminado')
                        })
                    }
                })
            },

            endKit: function(e) {
                if (!this.detalleTable.length)
                    return msg.warning("Para finalizar debe ingresar al menos un producto", "Advertencia!");

                if (!this.kit_cantidad)
                    return msg.warning("Ingrese la cantidad de kits que desea crear", "Advertencia!");

                $.ajax({
                    type: 'POST',
                    url:  'admin/kits/endKit',
                    data: {
                        total: this.totalKit,
                        kit_id: this.kit_id,
                        detalle: this.detalleTable,
                        kit_producto_id: this.producto.id,
                        kit_cantidad: this.kit_cantidad
                    },
                }).done(function(data) {
                    if (!data.success)
                        return msg.warning(data.msg, "Advertencia!")

                    $(".form-panel").hide()
                    msg.success('Kit finalizado!')
                })
            },

            Int: function(e)
            {
                // Allow: backspace, left, right and enter para
                if ($.inArray(e.keyCode, [8,37,38,39,110]) !== -1) return

                if ($(e.target).getPosition() == 0 && e.key == 0)
                    return e.preventDefault()

                // Ensure that it is a number and stop the keypress and return
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    return e.preventDefault()
                }
            },

            editItem: function(event, value)
            {
                this.beforeEditCache = value
                $(event.target).closest('td').hide()
                $(event.target).closest('td').next('td').show()
                $(event.target).closest('td').next('td').find('input').focus().select()
            },

            cancelEdit: function (that, event)
            {
                that.dt['cantidad'] = this.beforeEditCache
                $(event.target).closest('td').hide()
                $(event.target).closest('td').prev('td').show()
            },

            doneEdit: function(that, event)
            {
                if (!that.dt.cantidad) return

                $.ajax({
                    type: 'POST',
                    url: 'admin/kits/updateCantidad',
                    data: {
                        id:          that.dt.id,
                        cantidad:    that.dt.cantidad,
                        producto_id: that.dt.producto_id,
                        kit_id:      that.dt.kit_id,
                        _token:      this._token
                    },
                }).done(function(data) {
                    if (!data.success)
                        return msg.warning(data, 'Advertencia!')

                    kits.detalleTable = data.detalle
                    msg.success('Dato actualizado!')
                })
            },

        }
    });

    $("#buscarMarca").autocomplete({
        serviceUrl: 'admin/marcas/buscar',
        onSelect: function (q) {
            $("input[name='marca_id']").val(q.id);
        }
    });

    Number.prototype.formatMoney = function(c, d, t) {
        var n = this,
        c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
       return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };

</script>

<style type="text/css">
    .md-icon {
        padding-left: 10px;
    }
</style>
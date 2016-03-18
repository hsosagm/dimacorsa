<div id="kits">
    <div class="row info_head">
        <div class="col-md-6 master-detail-info">
            <table class="master-table">
                <tr>
                    <td>Codigo:</td>
                    <td>
                        <input type="text" v-on="keyup: findProducto | key 'enter'">
                        <i class="fa fa-search btn-link theme-c" v-on="click: get_table_productos"></i>
                        <i class="fa fa-plus-square btn-link theme-c" v-on="click: togleFormNewProduc"></i>
                    </td>
                </tr>
                <tr>
                    <td>Cantidad: </td>
                    <td>
                        <input v-on="keyup: startKit | key 'enter'" class="parseInt" type="text" name="cantidad">
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-6" style="font-size:11px"  v-if="producto.id">
            <label class="col-md-12">@{{ producto.descripcion }}</label>
            <label class="col-md-3">Precio:</label>
            <label class="col-md-3">@{{ producto.precio | currency 'Q '}}</label>
            <label class="col-md-3">Existencia:</label>
            <label class="col-md-3">@{{ producto.existencia | currency ' '}}</label>
        </div>
    </div>
    <div v-if="!formNewProduc" class="form-footer footer" align="right">
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

</div>

<script type="text/javascript">

    var kits = new Vue({

        el: '#kits',

        data: {
            formNewProduc: false,
            kit_id: '',
            producto: [],
            detalleTable: [],
            totalKit: 0
        },

        watch: {
            'detalleTable': function ()
            {
                var sum = 0

                for (var i = 0; i < this.detalleTable.length; i++)
                    sum += this.detalleTable[i]["total"]

                this.totalKit = sum.toFixed(2)
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
            findProducto: function(e)
            {
                e.preventDefault()
                $.ajax({
                    type: 'GET',
                    url: 'user/ventas/findProducto',
                    data: { codigo: $(e.target).val() },
                }).done(function(data) {
                    if (!data.success)
                        return msg.warning(data)

                    kits.producto = data.values
                })
            },

            get_table_productos: function()
            {
                $.ajax({
                    type: 'GET',
                    url: 'admin/kits/table_productos',
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

                if (!$("input[name=cantidad]").val())
                    return msg.warning('Ingrese la cantidad de kits que desea crear!')

                $.ajax({
                    type: 'POST',
                    url: 'admin/kits/create',
                    data: {
                        _token: this._token,
                        producto_id: this.producto.id,
                        cantidad:    $("input[name=cantidad]").val()
                    },
                }).done(function(data) {
                    return console.log(data)
                    if (!data.success)
                        return msg.warning(data, 'Advertencia!')

                    ventas.detalleTable = data.detalle
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

</script>

<style type="text/css">
    .md-icon {
        padding-left: 10px;
    }
</style>